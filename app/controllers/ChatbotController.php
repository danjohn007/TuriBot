<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Configuracion.php';
require_once APP_PATH . '/models/Atraccion.php';
require_once APP_PATH . '/models/Restaurante.php';
require_once APP_PATH . '/models/Hospedaje.php';
require_once APP_PATH . '/models/Evento.php';
require_once APP_PATH . '/models/Emergencia.php';

class ChatbotController extends BaseController {
    
    /**
     * Vista pública del chatbot (no requiere autenticación)
     */
    public function index() {
        $configModel = new Configuracion();
        $configuraciones = $configModel->getAllAsArray();
        
        // Cargar vista sin layout de admin
        $this->viewWithoutLayout('chatbot/public', [
            'configuraciones' => $configuraciones
        ]);
    }
    
    /**
     * API: Obtener configuración del chatbot
     */
    public function config() {
        $configModel = new Configuracion();
        $configuraciones = $configModel->getAllAsArray();
        
        // Filtrar solo las configuraciones relevantes para el chatbot público
        $chatbotConfig = [
            'nombre' => $configuraciones['chatbot_nombre'] ?? 'TuriBot',
            'activado' => ($configuraciones['chatbot_activado'] ?? '1') == '1',
            'idioma' => $configuraciones['chatbot_idioma'] ?? 'es',
            'tono' => $configuraciones['chatbot_tono_conversacion'] ?? 'amigable',
            'mensajeBienvenida' => $configuraciones['mensaje_bienvenida'] ?? '¡Bienvenido a TuriBot! ¿En qué puedo ayudarte?',
            'respuestaSaludos' => $configuraciones['chatbot_respuesta_saludos'] ?? '¡Hola! Soy TuriBot, tu guía turístico virtual.',
            'mensajeDespedida' => $configuraciones['chatbot_mensaje_despedida'] ?? '¡Hasta pronto! Espero haberte ayudado.',
            'respuestaAgradecimiento' => $configuraciones['chatbot_respuesta_agradecimiento'] ?? '¡De nada! Fue un placer ayudarte.',
            'mensajeNoEntendido' => $configuraciones['chatbot_mensaje_no_entendido'] ?? 'Lo siento, no entendí tu pregunta.',
            'mensajeError' => $configuraciones['chatbot_mensaje_error'] ?? 'Disculpa, tuve un problema técnico.',
            'mensajeFueraHorario' => $configuraciones['chatbot_mensaje_fuera_horario'] ?? 'Estoy fuera de horario.',
            'mensajeCargando' => $configuraciones['chatbot_mensaje_cargando'] ?? 'Buscando información...',
            'mensajeListaResultados' => $configuraciones['chatbot_mensaje_lista_resultados'] ?? 'Encontré estas opciones:',
            'mensajeSinResultados' => $configuraciones['chatbot_mensaje_sin_resultados'] ?? 'No encontré resultados.',
            'mostrarSugerencias' => ($configuraciones['chatbot_mostrar_sugerencias'] ?? '1') == '1',
            'mostrarEscribiendo' => ($configuraciones['chatbot_mostrar_escribiendo'] ?? '1') == '1',
            'velocidadRespuesta' => $configuraciones['chatbot_velocidad_respuesta'] ?? 'normal',
            'sugerenciasIniciales' => explode('|', $configuraciones['chatbot_sugerencias_iniciales'] ?? ''),
            'atencion247' => ($configuraciones['chatbot_atencion_247'] ?? '1') == '1',
            'horarioInicio' => $configuraciones['chatbot_horario_inicio'] ?? '08:00',
            'horarioFin' => $configuraciones['chatbot_horario_fin'] ?? '22:00',
            'diasAtencion' => explode(',', $configuraciones['chatbot_dias_atencion'] ?? 'Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'),
            'avatar' => $configuraciones['chatbot_avatar'] ?? 'chatbot-avatar.png',
            'colorPrimario' => $configuraciones['chatbot_color_primario'] ?? '#667eea',
            'colorSecundario' => $configuraciones['chatbot_color_secundario'] ?? '#764ba2',
            'funcionalidades' => [
                'hospedajes' => ($configuraciones['chatbot_buscar_hospedajes'] ?? '1') == '1',
                'restaurantes' => ($configuraciones['chatbot_buscar_restaurantes'] ?? '1') == '1',
                'atracciones' => ($configuraciones['chatbot_buscar_atracciones'] ?? '1') == '1',
                'eventos' => ($configuraciones['chatbot_buscar_eventos'] ?? '1') == '1',
                'emergencias' => ($configuraciones['chatbot_emergencias'] ?? '1') == '1',
                'recomendaciones' => ($configuraciones['chatbot_recomendaciones'] ?? '1') == '1'
            ]
        ];
        
        $this->json($chatbotConfig);
    }
    
    /**
     * API: Procesar mensaje del chatbot
     */
    public function chat() {
        // Verificar que sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Método no permitido'], 405);
        }
        
        // Obtener mensaje del usuario
        $input = json_decode(file_get_contents('php://input'), true);
        $mensaje = trim($input['mensaje'] ?? '');
        
        if (empty($mensaje)) {
            $this->json(['error' => 'Mensaje vacío'], 400);
        }
        
        // Obtener configuración
        $configModel = new Configuracion();
        $configuraciones = $configModel->getAllAsArray();
        
        // Verificar si el chatbot está activado
        if (($configuraciones['chatbot_activado'] ?? '1') != '1') {
            $this->json([
                'respuesta' => 'El chatbot está temporalmente desactivado. Disculpa las molestias.',
                'tipo' => 'sistema'
            ]);
        }
        
        // Verificar horario de atención
        if (!$this->isWithinWorkingHours($configuraciones)) {
            $this->json([
                'respuesta' => $configuraciones['chatbot_mensaje_fuera_horario'] ?? 'Estoy fuera de horario de atención.',
                'tipo' => 'sistema'
            ]);
        }
        
        // Procesar mensaje
        $respuesta = $this->processMessage($mensaje, $configuraciones);
        
        $this->json($respuesta);
    }
    
    /**
     * Verifica si está dentro del horario de atención
     */
    private function isWithinWorkingHours($config) {
        // Si es 24/7, siempre está disponible
        if (($config['chatbot_atencion_247'] ?? '1') == '1') {
            return true;
        }
        
        // Verificar día de la semana
        $diasAtencion = explode(',', $config['chatbot_dias_atencion'] ?? '');
        $diaActual = date('l'); // Monday, Tuesday, etc.
        $diasEspanol = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        $diaActualEspanol = $diasEspanol[$diaActual] ?? '';
        
        if (!in_array($diaActualEspanol, $diasAtencion)) {
            return false;
        }
        
        // Verificar hora
        $horaActual = date('H:i');
        $horarioInicio = $config['chatbot_horario_inicio'] ?? '08:00';
        $horarioFin = $config['chatbot_horario_fin'] ?? '22:00';
        
        return $horaActual >= $horarioInicio && $horaActual <= $horarioFin;
    }
    
    /**
     * Procesa el mensaje del usuario y genera una respuesta
     */
    private function processMessage($mensaje, $config) {
        $mensajeLower = strtolower($mensaje);
        
        // Detectar saludos
        $saludos = ['hola', 'buenos dias', 'buenas tardes', 'buenas noches', 'hey', 'hi', 'hello'];
        foreach ($saludos as $saludo) {
            if (strpos($mensajeLower, $saludo) !== false) {
                return [
                    'respuesta' => $config['chatbot_respuesta_saludos'] ?? '¡Hola! ¿En qué puedo ayudarte?',
                    'tipo' => 'saludo'
                ];
            }
        }
        
        // Detectar agradecimientos
        $agradecimientos = ['gracias', 'muchas gracias', 'thanks', 'thank you'];
        foreach ($agradecimientos as $gracias) {
            if (strpos($mensajeLower, $gracias) !== false) {
                return [
                    'respuesta' => $config['chatbot_respuesta_agradecimiento'] ?? '¡De nada! ¿Hay algo más en lo que pueda ayudarte?',
                    'tipo' => 'agradecimiento'
                ];
            }
        }
        
        // Detectar despedidas
        $despedidas = ['adios', 'chao', 'hasta luego', 'bye', 'hasta pronto'];
        foreach ($despedidas as $despedida) {
            if (strpos($mensajeLower, $despedida) !== false) {
                return [
                    'respuesta' => $config['chatbot_mensaje_despedida'] ?? '¡Hasta pronto!',
                    'tipo' => 'despedida'
                ];
            }
        }
        
        // Buscar hospedajes
        if (($config['chatbot_buscar_hospedajes'] ?? '1') == '1' && 
            (strpos($mensajeLower, 'hotel') !== false || 
             strpos($mensajeLower, 'hospedaje') !== false || 
             strpos($mensajeLower, 'hospedarm') !== false ||
             strpos($mensajeLower, 'hospedar') !== false || 
             strpos($mensajeLower, 'donde quedar') !== false ||
             strpos($mensajeLower, 'alojamiento') !== false ||
             strpos($mensajeLower, 'dormir') !== false)) {
            return $this->searchHospedajes($mensaje, $config);
        }
        
        // Buscar restaurantes
        if (($config['chatbot_buscar_restaurantes'] ?? '1') == '1' && 
            (strpos($mensajeLower, 'restaurant') !== false || 
             strpos($mensajeLower, 'comer') !== false || 
             strpos($mensajeLower, 'comida') !== false ||
             strpos($mensajeLower, 'donde comer') !== false ||
             strpos($mensajeLower, 'almorzar') !== false ||
             strpos($mensajeLower, 'cenar') !== false)) {
            return $this->searchRestaurantes($mensaje, $config);
        }
        
        // Buscar atracciones
        if (($config['chatbot_buscar_atracciones'] ?? '1') == '1' && 
            (strpos($mensajeLower, 'atraccion') !== false || 
             strpos($mensajeLower, 'visitar') !== false || 
             strpos($mensajeLower, 'lugares') !== false ||
             strpos($mensajeLower, 'turistico') !== false)) {
            return $this->searchAtracciones($mensaje, $config);
        }
        
        // Buscar eventos
        if (($config['chatbot_buscar_eventos'] ?? '1') == '1' && 
            (strpos($mensajeLower, 'evento') !== false || 
             strpos($mensajeLower, 'actividad') !== false)) {
            return $this->searchEventos($mensaje, $config);
        }
        
        // Emergencias
        if (($config['chatbot_emergencias'] ?? '1') == '1' && 
            (strpos($mensajeLower, 'emergencia') !== false || 
             strpos($mensajeLower, 'ayuda') !== false ||
             strpos($mensajeLower, 'policia') !== false ||
             strpos($mensajeLower, 'bomberos') !== false ||
             strpos($mensajeLower, 'hospital') !== false)) {
            return $this->getEmergencias($config);
        }
        
        // Si no entendió
        return [
            'respuesta' => $config['chatbot_mensaje_no_entendido'] ?? 'Lo siento, no entendí tu pregunta. ¿Podrías reformularla?',
            'tipo' => 'no_entendido',
            'sugerencias' => [
                '¿Dónde puedo hospedarme?',
                '¿Qué lugares puedo visitar?',
                '¿Dónde puedo comer?',
                '¿Qué eventos hay?',
                'Números de emergencia'
            ]
        ];
    }
    
    /**
     * Busca hospedajes
     */
    private function searchHospedajes($mensaje, $config) {
        $hospedajeModel = new Hospedaje();
        $hospedajes = $hospedajeModel->getAll();
        
        if (empty($hospedajes)) {
            return [
                'respuesta' => $config['chatbot_mensaje_sin_resultados'] ?? 'No encontré hospedajes disponibles.',
                'tipo' => 'sin_resultados'
            ];
        }
        
        $respuesta = ($config['chatbot_mensaje_lista_resultados'] ?? 'Encontré estas opciones:') . "\n\n";
        foreach (array_slice($hospedajes, 0, 5) as $hospedaje) {
            $respuesta .= "🏨 " . $hospedaje['nombre'] . "\n";
            if (!empty($hospedaje['direccion'])) {
                $respuesta .= "   📍 " . $hospedaje['direccion'] . "\n";
            }
            if (!empty($hospedaje['telefono'])) {
                $respuesta .= "   📞 " . $hospedaje['telefono'] . "\n";
            }
            $respuesta .= "\n";
        }
        
        return [
            'respuesta' => $respuesta,
            'tipo' => 'hospedajes',
            'resultados' => array_slice($hospedajes, 0, 5)
        ];
    }
    
    /**
     * Busca restaurantes
     */
    private function searchRestaurantes($mensaje, $config) {
        $restauranteModel = new Restaurante();
        $restaurantes = $restauranteModel->getAll();
        
        if (empty($restaurantes)) {
            return [
                'respuesta' => $config['chatbot_mensaje_sin_resultados'] ?? 'No encontré restaurantes disponibles.',
                'tipo' => 'sin_resultados'
            ];
        }
        
        $respuesta = ($config['chatbot_mensaje_lista_resultados'] ?? 'Encontré estas opciones:') . "\n\n";
        foreach (array_slice($restaurantes, 0, 5) as $restaurante) {
            $respuesta .= "🍽️ " . $restaurante['nombre'] . "\n";
            if (!empty($restaurante['tipo_comida'])) {
                $respuesta .= "   🍴 " . $restaurante['tipo_comida'] . "\n";
            }
            if (!empty($restaurante['direccion'])) {
                $respuesta .= "   📍 " . $restaurante['direccion'] . "\n";
            }
            if (!empty($restaurante['telefono'])) {
                $respuesta .= "   📞 " . $restaurante['telefono'] . "\n";
            }
            $respuesta .= "\n";
        }
        
        return [
            'respuesta' => $respuesta,
            'tipo' => 'restaurantes',
            'resultados' => array_slice($restaurantes, 0, 5)
        ];
    }
    
    /**
     * Busca atracciones
     */
    private function searchAtracciones($mensaje, $config) {
        $atraccionModel = new Atraccion();
        $atracciones = $atraccionModel->getAll();
        
        if (empty($atracciones)) {
            return [
                'respuesta' => $config['chatbot_mensaje_sin_resultados'] ?? 'No encontré atracciones disponibles.',
                'tipo' => 'sin_resultados'
            ];
        }
        
        $respuesta = ($config['chatbot_mensaje_lista_resultados'] ?? 'Encontré estas opciones:') . "\n\n";
        foreach (array_slice($atracciones, 0, 5) as $atraccion) {
            $respuesta .= "🎯 " . $atraccion['nombre'] . "\n";
            if (!empty($atraccion['categoria'])) {
                $respuesta .= "   📂 " . $atraccion['categoria'] . "\n";
            }
            if (!empty($atraccion['direccion'])) {
                $respuesta .= "   📍 " . $atraccion['direccion'] . "\n";
            }
            if (!empty($atraccion['horario_apertura'])) {
                $respuesta .= "   🕐 " . $atraccion['horario_apertura'] . " - " . $atraccion['horario_cierre'] . "\n";
            }
            $respuesta .= "\n";
        }
        
        return [
            'respuesta' => $respuesta,
            'tipo' => 'atracciones',
            'resultados' => array_slice($atracciones, 0, 5)
        ];
    }
    
    /**
     * Busca eventos
     */
    private function searchEventos($mensaje, $config) {
        $eventoModel = new Evento();
        $eventos = $eventoModel->getAll();
        
        if (empty($eventos)) {
            return [
                'respuesta' => $config['chatbot_mensaje_sin_resultados'] ?? 'No encontré eventos disponibles.',
                'tipo' => 'sin_resultados'
            ];
        }
        
        $respuesta = ($config['chatbot_mensaje_lista_resultados'] ?? 'Encontré estas opciones:') . "\n\n";
        foreach (array_slice($eventos, 0, 5) as $evento) {
            $respuesta .= "🎉 " . $evento['nombre'] . "\n";
            if (!empty($evento['fecha_inicio'])) {
                $respuesta .= "   📅 " . date('d/m/Y', strtotime($evento['fecha_inicio'])) . "\n";
            }
            if (!empty($evento['lugar'])) {
                $respuesta .= "   📍 " . $evento['lugar'] . "\n";
            }
            $respuesta .= "\n";
        }
        
        return [
            'respuesta' => $respuesta,
            'tipo' => 'eventos',
            'resultados' => array_slice($eventos, 0, 5)
        ];
    }
    
    /**
     * Obtiene contactos de emergencia
     */
    private function getEmergencias($config) {
        $emergenciaModel = new Emergencia();
        $emergencias = $emergenciaModel->getAll();
        
        if (empty($emergencias)) {
            return [
                'respuesta' => 'No hay contactos de emergencia registrados.',
                'tipo' => 'sin_resultados'
            ];
        }
        
        $respuesta = "🚨 Contactos de Emergencia:\n\n";
        foreach ($emergencias as $emergencia) {
            $numero = $emergencia['numero'] ?? $emergencia['telefono'] ?? '';
            $respuesta .= "📞 " . $emergencia['nombre'] . ": " . $numero . "\n";
            if (!empty($emergencia['descripcion'])) {
                $respuesta .= "   ℹ️ " . $emergencia['descripcion'] . "\n";
            }
            $respuesta .= "\n";
        }
        
        return [
            'respuesta' => $respuesta,
            'tipo' => 'emergencias',
            'resultados' => $emergencias
        ];
    }
}
?>
