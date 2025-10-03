-- Actualización de Base de Datos: Módulo de Personalización de ChatBot
-- TuriBot - Sistema Administrativo
-- Fecha: 2024

USE turibot_db;

-- Insertar nuevas configuraciones para personalización del ChatBot
-- Si ya existen, no se insertarán (evita duplicados)

-- Mensajes Personalizados
INSERT IGNORE INTO configuracion (clave, valor, descripcion) VALUES
('chatbot_nombre', 'TuriBot', 'Nombre del ChatBot que aparecerá en las conversaciones'),
('chatbot_mensaje_despedida', '¡Hasta pronto! Espero haberte ayudado. Vuelve cuando quieras.', 'Mensaje que se muestra al finalizar la conversación'),
('chatbot_mensaje_no_entendido', 'Lo siento, no entendí tu pregunta. ¿Podrías reformularla? O escribe "ayuda" para ver las opciones disponibles.', 'Mensaje cuando el bot no comprende la consulta del usuario'),
('chatbot_mensaje_error', 'Disculpa, estoy teniendo problemas técnicos. Por favor, intenta de nuevo en unos momentos.', 'Mensaje cuando ocurre un error en el sistema'),
('chatbot_mensaje_fuera_horario', 'Actualmente estoy fuera de horario. Puedes dejar tu mensaje y te responderemos pronto.', 'Mensaje cuando el chatbot está fuera de horario de atención');

-- Comportamiento del ChatBot
INSERT IGNORE INTO configuracion (clave, valor, descripcion) VALUES
('chatbot_tono_conversacion', 'amigable', 'Tono de las respuestas: formal, amigable, casual, profesional'),
('chatbot_idioma', 'es', 'Idioma principal del chatbot (es, en, fr)'),
('chatbot_tiempo_respuesta_max', '30', 'Tiempo máximo de respuesta en segundos antes de mostrar mensaje de espera'),
('chatbot_limite_consultas_dia', '100', 'Número máximo de consultas por usuario por día (0 = ilimitado)'),
('chatbot_mostrar_sugerencias', '1', 'Mostrar sugerencias de preguntas frecuentes (1 = sí, 0 = no)');

-- Horarios de Atención
INSERT IGNORE INTO configuracion (clave, valor, descripcion) VALUES
('chatbot_horario_inicio', '08:00', 'Hora de inicio de atención del chatbot (formato 24h)'),
('chatbot_horario_fin', '22:00', 'Hora de fin de atención del chatbot (formato 24h)'),
('chatbot_dias_atencion', 'Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo', 'Días de atención del chatbot'),
('chatbot_atencion_247', '1', 'Atención 24/7 (1 = sí, 0 = no). Si está activado, ignora horarios');

-- Funcionalidades Activadas
INSERT IGNORE INTO configuracion (clave, valor, descripcion) VALUES
('chatbot_activado', '1', 'ChatBot activado globalmente (1 = sí, 0 = no)'),
('chatbot_buscar_hospedajes', '1', 'Permitir búsqueda de hospedajes (1 = sí, 0 = no)'),
('chatbot_buscar_restaurantes', '1', 'Permitir búsqueda de restaurantes (1 = sí, 0 = no)'),
('chatbot_buscar_atracciones', '1', 'Permitir búsqueda de atracciones turísticas (1 = sí, 0 = no)'),
('chatbot_buscar_eventos', '1', 'Permitir consulta de eventos (1 = sí, 0 = no)'),
('chatbot_emergencias', '1', 'Mostrar contactos de emergencia (1 = sí, 0 = no)'),
('chatbot_recomendaciones', '1', 'Generar recomendaciones personalizadas (1 = sí, 0 = no)');

-- Respuestas Rápidas y Sugerencias
INSERT IGNORE INTO configuracion (clave, valor, descripcion) VALUES
('chatbot_sugerencias_iniciales', '¿Qué lugares puedo visitar?|¿Dónde puedo hospedarme?|Lugares recomendados para comer|¿Qué eventos hay próximamente?|Contactos de emergencia', 'Sugerencias de preguntas que se muestran al inicio (separadas por |)'),
('chatbot_respuesta_saludos', '¡Hola! Soy TuriBot, tu guía turístico virtual. ¿En qué puedo ayudarte hoy?', 'Respuesta automática a saludos del usuario'),
('chatbot_respuesta_agradecimiento', '¡De nada! Es un placer ayudarte. ¿Hay algo más en lo que pueda asistirte?', 'Respuesta automática cuando el usuario agradece');

-- Personalización Avanzada
INSERT IGNORE INTO configuracion (clave, valor, descripcion) VALUES
('chatbot_avatar', 'chatbot-avatar.png', 'Nombre del archivo del avatar del chatbot'),
('chatbot_color_primario', '#667eea', 'Color primario del widget del chatbot (hexadecimal)'),
('chatbot_color_secundario', '#764ba2', 'Color secundario del widget del chatbot (hexadecimal)'),
('chatbot_mostrar_escribiendo', '1', 'Mostrar indicador de "escribiendo..." (1 = sí, 0 = no)'),
('chatbot_velocidad_respuesta', 'normal', 'Velocidad de aparición de respuestas: lenta, normal, rápida, instantánea');

-- Analítica y Mejora Continua
INSERT IGNORE INTO configuracion (clave, valor, descripcion) VALUES
('chatbot_guardar_conversaciones', '1', 'Guardar historial de conversaciones para análisis (1 = sí, 0 = no)'),
('chatbot_solicitar_feedback', '1', 'Solicitar calificación después de cada conversación (1 = sí, 0 = no)'),
('chatbot_aprendizaje_activo', '0', 'Activar mejora con machine learning (1 = sí, 0 = no)');

-- Mensajes de Contexto Específico
INSERT IGNORE INTO configuracion (clave, valor, descripcion) VALUES
('chatbot_mensaje_sin_resultados', 'No encontré resultados para tu búsqueda. ¿Quieres que te muestre otras opciones?', 'Mensaje cuando no hay resultados de búsqueda'),
('chatbot_mensaje_lista_resultados', 'Encontré estas opciones para ti:', 'Mensaje antes de mostrar lista de resultados'),
('chatbot_mensaje_cargando', 'Un momento, estoy buscando la información...', 'Mensaje mientras se procesa la consulta');

-- Actualizar descripción del mensaje_bienvenida existente
UPDATE configuracion 
SET descripcion = 'Primer mensaje que ve el usuario al abrir el chatbot'
WHERE clave = 'mensaje_bienvenida';

-- Verificar que todas las configuraciones se insertaron correctamente
SELECT COUNT(*) as total_configuraciones_chatbot 
FROM configuracion 
WHERE clave LIKE 'chatbot_%' OR clave = 'mensaje_bienvenida';

-- Mostrar todas las configuraciones del chatbot
SELECT clave, valor, descripcion 
FROM configuracion 
WHERE clave LIKE 'chatbot_%' OR clave = 'mensaje_bienvenida'
ORDER BY clave;
