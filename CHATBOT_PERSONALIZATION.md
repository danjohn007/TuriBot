# Módulo de Personalización del ChatBot - TuriBot

## 📋 Descripción General

Este módulo permite personalizar completamente el comportamiento, mensajes y apariencia del ChatBot turístico de TuriBot. Todos los campos son configurables desde el panel administrativo en la sección **Configuraciones Generales del Sistema**.

## 🎯 Características Implementadas

### 1. Configuración Básica
- **Nombre del ChatBot**: Personalizar el nombre que aparece en las conversaciones
- **Estado del ChatBot**: Activar o desactivar el bot globalmente
- **Idioma Principal**: Soporte para Español, English y Français
- **Tono de Conversación**: Formal, Amigable, Casual o Profesional

### 2. Mensajes Personalizados
- **Mensaje de Bienvenida**: Primer mensaje al abrir el chat
- **Respuesta a Saludos**: Cuando el usuario saluda (Hola, Buenos días, etc.)
- **Mensaje de Despedida**: Al finalizar la conversación
- **Respuesta a Agradecimientos**: Cuando el usuario dice gracias
- **Mensaje de No Comprensión**: Cuando el bot no entiende la pregunta
- **Mensaje de Error**: Para errores técnicos
- **Mensaje Fuera de Horario**: Cuando está fuera del horario de atención

### 3. Mensajes de Búsqueda y Resultados
- **Mensaje de Carga**: Mientras procesa la consulta
- **Introducción a Resultados**: Antes de mostrar resultados
- **Mensaje Sin Resultados**: Cuando no hay coincidencias

### 4. Comportamiento del ChatBot
- **Mostrar Sugerencias**: Activar/desactivar sugerencias de preguntas frecuentes
- **Indicador "Escribiendo..."**: Simular que el bot está escribiendo
- **Velocidad de Respuesta**: Lenta, Normal, Rápida o Instantánea
- **Tiempo Máximo de Respuesta**: Segundos antes de mostrar mensaje de espera (5-120s)
- **Límite de Consultas por Día**: Control de uso (0 = ilimitado)
- **Sugerencias Iniciales**: Preguntas frecuentes separadas por |

### 5. Horarios de Atención
- **Atención 24/7**: Disponibilidad continua
- **Horario Personalizado**: 
  - Hora de Inicio (formato 24h)
  - Hora de Fin (formato 24h)
  - Días de Atención (separados por comas)

### 6. Funcionalidades Activadas (Toggles)
- ✅ Búsqueda de Hospedajes
- ✅ Búsqueda de Restaurantes
- ✅ Búsqueda de Atracciones Turísticas
- ✅ Consulta de Eventos
- ✅ Contactos de Emergencia
- ✅ Recomendaciones Personalizadas

### 7. Apariencia del ChatBot
- **Avatar del ChatBot**: Imagen del bot (ubicada en public/img/)
- **Color Primario**: Color principal del widget (hexadecimal)
- **Color Secundario**: Color secundario del widget (hexadecimal)

### 8. Analítica y Mejora Continua
- **Guardar Conversaciones**: Para análisis posterior
- **Solicitar Feedback**: Calificación de satisfacción al finalizar
- **Aprendizaje Activo**: Mejora con machine learning (futuro)

## 📊 Campos de Configuración en Base de Datos

### Tabla: `configuracion`

| Clave | Valor por Defecto | Descripción |
|-------|-------------------|-------------|
| `chatbot_nombre` | TuriBot | Nombre del ChatBot |
| `chatbot_activado` | 1 | Estado: 1=Activado, 0=Desactivado |
| `chatbot_idioma` | es | Idioma: es, en, fr |
| `chatbot_tono_conversacion` | amigable | Tono: formal, amigable, casual, profesional |
| `mensaje_bienvenida` | ¡Bienvenido a TuriBot!... | Mensaje inicial |
| `chatbot_respuesta_saludos` | ¡Hola! Soy TuriBot... | Respuesta a saludos |
| `chatbot_mensaje_despedida` | ¡Hasta pronto!... | Mensaje de despedida |
| `chatbot_respuesta_agradecimiento` | ¡De nada!... | Respuesta a gracias |
| `chatbot_mensaje_no_entendido` | Lo siento, no entendí... | No comprensión |
| `chatbot_mensaje_error` | Disculpa, problemas técnicos... | Error del sistema |
| `chatbot_mensaje_fuera_horario` | Fuera de horario... | Mensaje fuera de horario |
| `chatbot_mensaje_cargando` | Buscando información... | Mensaje de carga |
| `chatbot_mensaje_lista_resultados` | Encontré estas opciones... | Antes de resultados |
| `chatbot_mensaje_sin_resultados` | No encontré resultados... | Sin coincidencias |
| `chatbot_mostrar_sugerencias` | 1 | Mostrar sugerencias: 1/0 |
| `chatbot_mostrar_escribiendo` | 1 | Indicador escribiendo: 1/0 |
| `chatbot_velocidad_respuesta` | normal | lenta, normal, rapida, instantanea |
| `chatbot_tiempo_respuesta_max` | 30 | Segundos (5-120) |
| `chatbot_limite_consultas_dia` | 100 | 0 = ilimitado |
| `chatbot_sugerencias_iniciales` | Pregunta1\|Pregunta2... | Separadas por \| |
| `chatbot_horario_inicio` | 08:00 | Hora inicio (24h) |
| `chatbot_horario_fin` | 22:00 | Hora fin (24h) |
| `chatbot_dias_atencion` | Lunes,Martes... | Días separados por comas |
| `chatbot_atencion_247` | 1 | Atención 24/7: 1/0 |
| `chatbot_buscar_hospedajes` | 1 | Funcionalidad activa: 1/0 |
| `chatbot_buscar_restaurantes` | 1 | Funcionalidad activa: 1/0 |
| `chatbot_buscar_atracciones` | 1 | Funcionalidad activa: 1/0 |
| `chatbot_buscar_eventos` | 1 | Funcionalidad activa: 1/0 |
| `chatbot_emergencias` | 1 | Funcionalidad activa: 1/0 |
| `chatbot_recomendaciones` | 1 | Funcionalidad activa: 1/0 |
| `chatbot_avatar` | chatbot-avatar.png | Archivo de imagen |
| `chatbot_color_primario` | #667eea | Color hexadecimal |
| `chatbot_color_secundario` | #764ba2 | Color hexadecimal |
| `chatbot_guardar_conversaciones` | 1 | Guardar historial: 1/0 |
| `chatbot_solicitar_feedback` | 1 | Pedir calificación: 1/0 |
| `chatbot_aprendizaje_activo` | 0 | Machine learning: 1/0 |

## 🚀 Instalación y Actualización

### 1. Ejecutar el Script SQL

Para agregar todos los campos de configuración a la base de datos:

```bash
mysql -u usuario -p nombre_bd < database/chatbot_personalization_update.sql
```

O desde phpMyAdmin, importar el archivo:
```
database/chatbot_personalization_update.sql
```

### 2. Verificar la Instalación

El script SQL incluye verificaciones automáticas que muestran:
- Total de configuraciones del chatbot instaladas
- Listado completo de todas las configuraciones

### 3. Acceder a la Configuración

Desde el panel administrativo:
1. Iniciar sesión como administrador
2. Ir a **Configuración** → **Configuraciones Generales**
3. Desplazarse a la sección **Configuración del ChatBot**

## 📝 Ejemplos de Uso

### Ejemplo 1: Cambiar el Tono del ChatBot

```
chatbot_tono_conversacion = 'formal'
mensaje_bienvenida = 'Buenos días. Le damos la bienvenida al sistema de información turística.'
chatbot_respuesta_saludos = 'Buenos días. ¿En qué puedo asistirle?'
```

### Ejemplo 2: Configurar Horario Limitado

```
chatbot_atencion_247 = '0'
chatbot_horario_inicio = '09:00'
chatbot_horario_fin = '18:00'
chatbot_dias_atencion = 'Lunes,Martes,Miércoles,Jueves,Viernes'
chatbot_mensaje_fuera_horario = 'Nuestro horario de atención es de Lunes a Viernes, 9:00 AM a 6:00 PM'
```

### Ejemplo 3: Personalizar Colores

```
chatbot_color_primario = '#ff6b6b'
chatbot_color_secundario = '#4ecdc4'
```

### Ejemplo 4: Sugerencias Personalizadas

```
chatbot_sugerencias_iniciales = '¿Dónde puedo comer?|Lugares para visitar|¿Hay eventos este fin de semana?|Necesito un hotel'
```

## 🔧 Integración con el ChatBot

### Acceso desde PHP

```php
require_once APP_PATH . '/models/Configuracion.php';

$config = new Configuracion();
$configuraciones = $config->getAllAsArray();

// Usar configuraciones
$nombreBot = $configuraciones['chatbot_nombre'];
$mensajeBienvenida = $configuraciones['mensaje_bienvenida'];
$tonoConversacion = $configuraciones['chatbot_tono_conversacion'];
```

### Acceso desde JavaScript (Frontend)

```javascript
// Endpoint API para obtener configuración
fetch('/api/chatbot/config')
  .then(response => response.json())
  .then(config => {
    // Aplicar configuración al widget
    chatWidget.setName(config.chatbot_nombre);
    chatWidget.setColors(config.chatbot_color_primario, config.chatbot_color_secundario);
    chatWidget.showWelcomeMessage(config.mensaje_bienvenida);
  });
```

## 🎨 Personalización Avanzada

### Velocidades de Respuesta

- **Lenta**: 2-3 segundos de delay
- **Normal**: 1-1.5 segundos de delay
- **Rápida**: 0.5 segundos de delay
- **Instantánea**: Sin delay

### Tonos de Conversación

- **Formal**: Usted, lenguaje profesional
- **Amigable**: Tú, cercano pero respetuoso
- **Casual**: Tú, lenguaje relajado
- **Profesional**: Usted, técnico y preciso

## 🔐 Seguridad y Validación

### Validaciones Implementadas

1. **Horarios**: Formato 24h (HH:MM)
2. **Colores**: Formato hexadecimal (#RRGGBB)
3. **Números**: Rangos válidos (tiempo respuesta: 5-120s)
4. **Checkboxes**: Valores booleanos (0/1)
5. **Texto**: Sanitización con `cleanInput()`

### Permisos

- Solo usuarios con rol **admin** pueden modificar configuraciones
- Todas las actualizaciones se registran en el log de actividades

## 📈 Mejoras Futuras

1. **API RESTful**: Endpoint para que el chatbot consuma la configuración
2. **Vista Previa**: Ver cambios antes de aplicarlos
3. **Plantillas**: Configuraciones predefinidas (Formal, Casual, etc.)
4. **Multiidioma**: Mensajes diferentes por idioma
5. **A/B Testing**: Probar diferentes configuraciones
6. **Estadísticas**: Dashboard de uso del chatbot
7. **Respuestas Dinámicas**: Basadas en ML/AI

## 📞 Soporte

Para más información sobre la implementación del ChatBot completo:
- Ver: `PROJECT_SUMMARY.md`
- Ver: `README.md`
- Contacto: admin@turibot.com

---

**Versión**: 1.0.0  
**Fecha**: 2024  
**Módulo**: Personalización de ChatBot  
**Estado**: ✅ Implementado y Funcional
