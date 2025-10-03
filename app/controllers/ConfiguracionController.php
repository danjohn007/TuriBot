<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Configuracion.php';

class ConfiguracionController extends BaseController {
    private $configuracionModel;
    
    public function __construct() {
        parent::__construct();
        $this->configuracionModel = new Configuracion();
    }
    
    public function index() {
        $this->requireRole('admin');
        $configuraciones = $this->configuracionModel->getAllAsArray();
        $this->view('configuracion/index', ['configuraciones' => $configuraciones]);
    }
    
    public function update() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('configuracion');
        }
        
        try {
            // Lista de campos de checkbox/switch para manejar valores no enviados
            $checkboxFields = [
                'chatbot_activado',
                'chatbot_buscar_hospedajes',
                'chatbot_buscar_restaurantes',
                'chatbot_buscar_atracciones',
                'chatbot_buscar_eventos',
                'chatbot_emergencias',
                'chatbot_recomendaciones',
                'chatbot_mostrar_sugerencias',
                'chatbot_mostrar_escribiendo',
                'chatbot_atencion_247',
                'chatbot_guardar_conversaciones',
                'chatbot_solicitar_feedback',
                'chatbot_aprendizaje_activo'
            ];
            
            // Establecer valores 0 para checkboxes no marcados
            foreach ($checkboxFields as $field) {
                if (!isset($_POST[$field])) {
                    $_POST[$field] = '0';
                }
            }
            
            // Actualizar todas las configuraciones
            foreach ($_POST as $clave => $valor) {
                if ($clave !== 'csrf_token') {
                    $this->configuracionModel->update($clave, cleanInput($valor));
                }
            }
            
            logActivity('Actualizó configuración general', 'configuracion');
            setFlash('success', 'Configuración actualizada exitosamente');
        } catch (Exception $e) {
            setFlash('danger', 'Error al actualizar la configuración');
        }
        
        redirect('configuracion');
    }
    
    public function general() {
        $this->requireRole('admin');
        $configuraciones = $this->configuracionModel->getAllAsArray();
        $this->view('configuracion/general', ['configuraciones' => $configuraciones]);
    }
}
?>
