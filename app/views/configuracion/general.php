<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-sliders"></i> Configuraciones Generales del Sistema</h1>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-building" style="font-size: 3rem; color: var(--primary-color);"></i>
                <h5 class="card-title mt-3">Información del Municipio</h5>
                <p class="card-text text-muted">Configuración de datos de contacto y ubicación</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-robot" style="font-size: 3rem; color: var(--primary-color);"></i>
                <h5 class="card-title mt-3">ChatBot</h5>
                <p class="card-text text-muted">Personalización de mensajes y comportamiento</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-palette" style="font-size: 3rem; color: var(--primary-color);"></i>
                <h5 class="card-title mt-3">Apariencia</h5>
                <p class="card-text text-muted">Logo y colores del sistema</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>configuracion/update">
            <h5 class="mb-3"><i class="bi bi-info-circle"></i> Información del Sistema</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre_sistema" class="form-label">Nombre del Sistema</label>
                    <input type="text" class="form-control" id="nombre_sistema" name="nombre_sistema" 
                           value="<?php echo htmlspecialchars($configuraciones['nombre_sistema'] ?? ''); ?>">
                    <small class="text-muted">Nombre que aparecerá en el encabezado del sistema</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="logo_sistema" class="form-label">Logo del Sistema</label>
                    <input type="text" class="form-control" id="logo_sistema" name="logo_sistema" 
                           value="<?php echo htmlspecialchars($configuraciones['logo_sistema'] ?? ''); ?>">
                    <small class="text-muted">Nombre del archivo de logo (ubicado en public/images/)</small>
                </div>
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3"><i class="bi bi-building"></i> Información del Municipio</h5>
            
            <div class="mb-3">
                <label for="direccion_municipio" class="form-label">Dirección del Municipio</label>
                <textarea class="form-control" id="direccion_municipio" name="direccion_municipio" rows="2"><?php echo htmlspecialchars($configuraciones['direccion_municipio'] ?? ''); ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email_contacto" class="form-label">Email de Contacto</label>
                    <input type="email" class="form-control" id="email_contacto" name="email_contacto" 
                           value="<?php echo htmlspecialchars($configuraciones['email_contacto'] ?? ''); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefono_contacto" class="form-label">Teléfono de Contacto</label>
                    <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" 
                           value="<?php echo htmlspecialchars($configuraciones['telefono_contacto'] ?? ''); ?>">
                </div>
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3"><i class="bi bi-envelope"></i> Configuración de Email</h5>
            
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-gear"></i> Servidor SMTP</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="smtp_host" class="form-label">Host SMTP</label>
                            <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                                   value="<?php echo htmlspecialchars($configuraciones['smtp_host'] ?? ''); ?>"
                                   placeholder="smtp.gmail.com">
                            <small class="text-muted">Servidor SMTP para envío de emails</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="smtp_port" class="form-label">Puerto SMTP</label>
                            <input type="number" class="form-control" id="smtp_port" name="smtp_port" 
                                   value="<?php echo htmlspecialchars($configuraciones['smtp_port'] ?? '587'); ?>"
                                   placeholder="587">
                            <small class="text-muted">Puerto del servidor SMTP (587 o 465)</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="smtp_usuario" class="form-label">Usuario SMTP</label>
                            <input type="text" class="form-control" id="smtp_usuario" name="smtp_usuario" 
                                   value="<?php echo htmlspecialchars($configuraciones['smtp_usuario'] ?? ''); ?>"
                                   placeholder="usuario@ejemplo.com">
                            <small class="text-muted">Usuario para autenticación SMTP</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="smtp_password" class="form-label">Contraseña SMTP</label>
                            <input type="password" class="form-control" id="smtp_password" name="smtp_password" 
                                   value="<?php echo htmlspecialchars($configuraciones['smtp_password'] ?? ''); ?>"
                                   placeholder="••••••••">
                            <small class="text-muted">Contraseña del usuario SMTP</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email_remitente" class="form-label">Email Remitente</label>
                            <input type="email" class="form-control" id="email_remitente" name="email_remitente" 
                                   value="<?php echo htmlspecialchars($configuraciones['email_remitente'] ?? ''); ?>"
                                   placeholder="noreply@turibot.com">
                            <small class="text-muted">Email que aparecerá como remitente</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombre_remitente" class="form-label">Nombre Remitente</label>
                            <input type="text" class="form-control" id="nombre_remitente" name="nombre_remitente" 
                                   value="<?php echo htmlspecialchars($configuraciones['nombre_remitente'] ?? 'TuriBot'); ?>"
                                   placeholder="TuriBot">
                            <small class="text-muted">Nombre que aparecerá como remitente</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="smtp_encriptacion" class="form-label">Tipo de Encriptación</label>
                        <select class="form-control" id="smtp_encriptacion" name="smtp_encriptacion">
                            <option value="tls" <?php echo ($configuraciones['smtp_encriptacion'] ?? 'tls') == 'tls' ? 'selected' : ''; ?>>TLS</option>
                            <option value="ssl" <?php echo ($configuraciones['smtp_encriptacion'] ?? 'tls') == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                        </select>
                        <small class="text-muted">Protocolo de seguridad para la conexión</small>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> <strong>Nota:</strong> Estos datos son necesarios para el envío de emails de recuperación de contraseña y notificaciones del sistema.
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3"><i class="bi bi-robot"></i> Configuración del ChatBot</h5>
            
            <!-- Configuración Básica -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-gear"></i> Configuración Básica</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_nombre" class="form-label">Nombre del ChatBot</label>
                            <input type="text" class="form-control" id="chatbot_nombre" name="chatbot_nombre" 
                                   value="<?php echo htmlspecialchars($configuraciones['chatbot_nombre'] ?? 'TuriBot'); ?>">
                            <small class="text-muted">Nombre que aparecerá en las conversaciones</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_activado" class="form-label">Estado del ChatBot</label>
                            <select class="form-control" id="chatbot_activado" name="chatbot_activado">
                                <option value="1" <?php echo ($configuraciones['chatbot_activado'] ?? '1') == '1' ? 'selected' : ''; ?>>Activado</option>
                                <option value="0" <?php echo ($configuraciones['chatbot_activado'] ?? '1') == '0' ? 'selected' : ''; ?>>Desactivado</option>
                            </select>
                            <small class="text-muted">Activar o desactivar el chatbot globalmente</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_idioma" class="form-label">Idioma Principal</label>
                            <select class="form-control" id="chatbot_idioma" name="chatbot_idioma">
                                <option value="es" <?php echo ($configuraciones['chatbot_idioma'] ?? 'es') == 'es' ? 'selected' : ''; ?>>Español</option>
                                <option value="en" <?php echo ($configuraciones['chatbot_idioma'] ?? 'es') == 'en' ? 'selected' : ''; ?>>English</option>
                                <option value="fr" <?php echo ($configuraciones['chatbot_idioma'] ?? 'es') == 'fr' ? 'selected' : ''; ?>>Français</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_tono_conversacion" class="form-label">Tono de Conversación</label>
                            <select class="form-control" id="chatbot_tono_conversacion" name="chatbot_tono_conversacion">
                                <option value="formal" <?php echo ($configuraciones['chatbot_tono_conversacion'] ?? 'amigable') == 'formal' ? 'selected' : ''; ?>>Formal</option>
                                <option value="amigable" <?php echo ($configuraciones['chatbot_tono_conversacion'] ?? 'amigable') == 'amigable' ? 'selected' : ''; ?>>Amigable</option>
                                <option value="casual" <?php echo ($configuraciones['chatbot_tono_conversacion'] ?? 'amigable') == 'casual' ? 'selected' : ''; ?>>Casual</option>
                                <option value="profesional" <?php echo ($configuraciones['chatbot_tono_conversacion'] ?? 'amigable') == 'profesional' ? 'selected' : ''; ?>>Profesional</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mensajes Personalizados -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-chat-dots"></i> Mensajes Personalizados</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="mensaje_bienvenida" class="form-label">Mensaje de Bienvenida</label>
                        <textarea class="form-control" id="mensaje_bienvenida" name="mensaje_bienvenida" rows="2"><?php echo htmlspecialchars($configuraciones['mensaje_bienvenida'] ?? ''); ?></textarea>
                        <small class="text-muted">Primer mensaje que ve el usuario al abrir el chatbot</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chatbot_respuesta_saludos" class="form-label">Respuesta a Saludos</label>
                        <textarea class="form-control" id="chatbot_respuesta_saludos" name="chatbot_respuesta_saludos" rows="2"><?php echo htmlspecialchars($configuraciones['chatbot_respuesta_saludos'] ?? '¡Hola! Soy TuriBot, tu guía turístico virtual. ¿En qué puedo ayudarte hoy?'); ?></textarea>
                        <small class="text-muted">Respuesta cuando el usuario saluda</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chatbot_mensaje_despedida" class="form-label">Mensaje de Despedida</label>
                        <textarea class="form-control" id="chatbot_mensaje_despedida" name="chatbot_mensaje_despedida" rows="2"><?php echo htmlspecialchars($configuraciones['chatbot_mensaje_despedida'] ?? '¡Hasta pronto! Espero haberte ayudado. Vuelve cuando quieras.'); ?></textarea>
                        <small class="text-muted">Mensaje al finalizar la conversación</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chatbot_respuesta_agradecimiento" class="form-label">Respuesta a Agradecimientos</label>
                        <textarea class="form-control" id="chatbot_respuesta_agradecimiento" name="chatbot_respuesta_agradecimiento" rows="2"><?php echo htmlspecialchars($configuraciones['chatbot_respuesta_agradecimiento'] ?? '¡De nada! Es un placer ayudarte. ¿Hay algo más en lo que pueda asistirte?'); ?></textarea>
                        <small class="text-muted">Respuesta cuando el usuario agradece</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chatbot_mensaje_no_entendido" class="form-label">Mensaje de No Comprensión</label>
                        <textarea class="form-control" id="chatbot_mensaje_no_entendido" name="chatbot_mensaje_no_entendido" rows="2"><?php echo htmlspecialchars($configuraciones['chatbot_mensaje_no_entendido'] ?? 'Lo siento, no entendí tu pregunta. ¿Podrías reformularla?'); ?></textarea>
                        <small class="text-muted">Cuando el bot no comprende la consulta</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_mensaje_error" class="form-label">Mensaje de Error</label>
                            <textarea class="form-control" id="chatbot_mensaje_error" name="chatbot_mensaje_error" rows="2"><?php echo htmlspecialchars($configuraciones['chatbot_mensaje_error'] ?? 'Disculpa, estoy teniendo problemas técnicos.'); ?></textarea>
                            <small class="text-muted">Cuando ocurre un error técnico</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_mensaje_fuera_horario" class="form-label">Mensaje Fuera de Horario</label>
                            <textarea class="form-control" id="chatbot_mensaje_fuera_horario" name="chatbot_mensaje_fuera_horario" rows="2"><?php echo htmlspecialchars($configuraciones['chatbot_mensaje_fuera_horario'] ?? 'Actualmente estoy fuera de horario.'); ?></textarea>
                            <small class="text-muted">Cuando está fuera del horario de atención</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mensajes de Búsqueda y Resultados -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-search"></i> Mensajes de Búsqueda</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="chatbot_mensaje_cargando" class="form-label">Mensaje de Carga</label>
                        <input type="text" class="form-control" id="chatbot_mensaje_cargando" name="chatbot_mensaje_cargando" 
                               value="<?php echo htmlspecialchars($configuraciones['chatbot_mensaje_cargando'] ?? 'Un momento, estoy buscando la información...'); ?>">
                        <small class="text-muted">Mientras se procesa la consulta</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chatbot_mensaje_lista_resultados" class="form-label">Introducción a Resultados</label>
                        <input type="text" class="form-control" id="chatbot_mensaje_lista_resultados" name="chatbot_mensaje_lista_resultados" 
                               value="<?php echo htmlspecialchars($configuraciones['chatbot_mensaje_lista_resultados'] ?? 'Encontré estas opciones para ti:'); ?>">
                        <small class="text-muted">Antes de mostrar lista de resultados</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chatbot_mensaje_sin_resultados" class="form-label">Mensaje Sin Resultados</label>
                        <input type="text" class="form-control" id="chatbot_mensaje_sin_resultados" name="chatbot_mensaje_sin_resultados" 
                               value="<?php echo htmlspecialchars($configuraciones['chatbot_mensaje_sin_resultados'] ?? 'No encontré resultados para tu búsqueda.'); ?>">
                        <small class="text-muted">Cuando no hay resultados</small>
                    </div>
                </div>
            </div>
            
            <!-- Comportamiento -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-sliders"></i> Comportamiento del ChatBot</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="chatbot_mostrar_sugerencias" class="form-label">Mostrar Sugerencias</label>
                            <select class="form-control" id="chatbot_mostrar_sugerencias" name="chatbot_mostrar_sugerencias">
                                <option value="1" <?php echo ($configuraciones['chatbot_mostrar_sugerencias'] ?? '1') == '1' ? 'selected' : ''; ?>>Sí</option>
                                <option value="0" <?php echo ($configuraciones['chatbot_mostrar_sugerencias'] ?? '1') == '0' ? 'selected' : ''; ?>>No</option>
                            </select>
                            <small class="text-muted">Sugerencias de preguntas frecuentes</small>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="chatbot_mostrar_escribiendo" class="form-label">Indicador "Escribiendo..."</label>
                            <select class="form-control" id="chatbot_mostrar_escribiendo" name="chatbot_mostrar_escribiendo">
                                <option value="1" <?php echo ($configuraciones['chatbot_mostrar_escribiendo'] ?? '1') == '1' ? 'selected' : ''; ?>>Sí</option>
                                <option value="0" <?php echo ($configuraciones['chatbot_mostrar_escribiendo'] ?? '1') == '0' ? 'selected' : ''; ?>>No</option>
                            </select>
                            <small class="text-muted">Simular escritura del bot</small>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="chatbot_velocidad_respuesta" class="form-label">Velocidad de Respuesta</label>
                            <select class="form-control" id="chatbot_velocidad_respuesta" name="chatbot_velocidad_respuesta">
                                <option value="lenta" <?php echo ($configuraciones['chatbot_velocidad_respuesta'] ?? 'normal') == 'lenta' ? 'selected' : ''; ?>>Lenta</option>
                                <option value="normal" <?php echo ($configuraciones['chatbot_velocidad_respuesta'] ?? 'normal') == 'normal' ? 'selected' : ''; ?>>Normal</option>
                                <option value="rapida" <?php echo ($configuraciones['chatbot_velocidad_respuesta'] ?? 'normal') == 'rapida' ? 'selected' : ''; ?>>Rápida</option>
                                <option value="instantanea" <?php echo ($configuraciones['chatbot_velocidad_respuesta'] ?? 'normal') == 'instantanea' ? 'selected' : ''; ?>>Instantánea</option>
                            </select>
                            <small class="text-muted">Tiempo de aparición de respuestas</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_tiempo_respuesta_max" class="form-label">Tiempo Máximo de Respuesta (segundos)</label>
                            <input type="number" class="form-control" id="chatbot_tiempo_respuesta_max" name="chatbot_tiempo_respuesta_max" 
                                   value="<?php echo htmlspecialchars($configuraciones['chatbot_tiempo_respuesta_max'] ?? '30'); ?>" min="5" max="120">
                            <small class="text-muted">Antes de mostrar mensaje de espera</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_limite_consultas_dia" class="form-label">Límite de Consultas por Día</label>
                            <input type="number" class="form-control" id="chatbot_limite_consultas_dia" name="chatbot_limite_consultas_dia" 
                                   value="<?php echo htmlspecialchars($configuraciones['chatbot_limite_consultas_dia'] ?? '100'); ?>" min="0">
                            <small class="text-muted">0 = ilimitado</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chatbot_sugerencias_iniciales" class="form-label">Sugerencias Iniciales</label>
                        <textarea class="form-control" id="chatbot_sugerencias_iniciales" name="chatbot_sugerencias_iniciales" rows="2"><?php echo htmlspecialchars($configuraciones['chatbot_sugerencias_iniciales'] ?? '¿Qué lugares puedo visitar?|¿Dónde puedo hospedarme?|¿Qué eventos hay próximamente?|Contactos de emergencia'); ?></textarea>
                        <small class="text-muted">Separar con | (pipe). Ej: Pregunta 1|Pregunta 2|Pregunta 3</small>
                    </div>
                </div>
            </div>
            
            <!-- Horarios de Atención -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-clock"></i> Horarios de Atención</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="chatbot_atencion_247" class="form-label">Atención 24/7</label>
                        <select class="form-control" id="chatbot_atencion_247" name="chatbot_atencion_247">
                            <option value="1" <?php echo ($configuraciones['chatbot_atencion_247'] ?? '1') == '1' ? 'selected' : ''; ?>>Sí, atención las 24 horas</option>
                            <option value="0" <?php echo ($configuraciones['chatbot_atencion_247'] ?? '1') == '0' ? 'selected' : ''; ?>>No, usar horario personalizado</option>
                        </select>
                    </div>
                    
                    <div class="row" id="horario-personalizado">
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_horario_inicio" class="form-label">Hora de Inicio</label>
                            <input type="time" class="form-control" id="chatbot_horario_inicio" name="chatbot_horario_inicio" 
                                   value="<?php echo htmlspecialchars($configuraciones['chatbot_horario_inicio'] ?? '08:00'); ?>">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="chatbot_horario_fin" class="form-label">Hora de Fin</label>
                            <input type="time" class="form-control" id="chatbot_horario_fin" name="chatbot_horario_fin" 
                                   value="<?php echo htmlspecialchars($configuraciones['chatbot_horario_fin'] ?? '22:00'); ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="chatbot_dias_atencion" class="form-label">Días de Atención</label>
                        <input type="text" class="form-control" id="chatbot_dias_atencion" name="chatbot_dias_atencion" 
                               value="<?php echo htmlspecialchars($configuraciones['chatbot_dias_atencion'] ?? 'Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'); ?>">
                        <small class="text-muted">Separar con comas. Ej: Lunes,Martes,Miércoles</small>
                    </div>
                </div>
            </div>
            
            <!-- Funcionalidades Activadas -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-toggles"></i> Funcionalidades Activadas</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_buscar_hospedajes" name="chatbot_buscar_hospedajes" 
                                       value="1" <?php echo ($configuraciones['chatbot_buscar_hospedajes'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_buscar_hospedajes">
                                    <i class="bi bi-building"></i> Búsqueda de Hospedajes
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_buscar_restaurantes" name="chatbot_buscar_restaurantes" 
                                       value="1" <?php echo ($configuraciones['chatbot_buscar_restaurantes'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_buscar_restaurantes">
                                    <i class="bi bi-cup-straw"></i> Búsqueda de Restaurantes
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_buscar_atracciones" name="chatbot_buscar_atracciones" 
                                       value="1" <?php echo ($configuraciones['chatbot_buscar_atracciones'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_buscar_atracciones">
                                    <i class="bi bi-geo-alt"></i> Búsqueda de Atracciones Turísticas
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_buscar_eventos" name="chatbot_buscar_eventos" 
                                       value="1" <?php echo ($configuraciones['chatbot_buscar_eventos'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_buscar_eventos">
                                    <i class="bi bi-calendar-event"></i> Consulta de Eventos
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_emergencias" name="chatbot_emergencias" 
                                       value="1" <?php echo ($configuraciones['chatbot_emergencias'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_emergencias">
                                    <i class="bi bi-shield-exclamation"></i> Contactos de Emergencia
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_recomendaciones" name="chatbot_recomendaciones" 
                                       value="1" <?php echo ($configuraciones['chatbot_recomendaciones'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_recomendaciones">
                                    <i class="bi bi-stars"></i> Recomendaciones Personalizadas
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Apariencia -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-palette"></i> Apariencia del ChatBot</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="chatbot_avatar" class="form-label">Avatar del ChatBot</label>
                            <input type="text" class="form-control" id="chatbot_avatar" name="chatbot_avatar" 
                                   value="<?php echo htmlspecialchars($configuraciones['chatbot_avatar'] ?? 'chatbot-avatar.png'); ?>">
                            <small class="text-muted">Nombre del archivo en public/img/</small>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="chatbot_color_primario" class="form-label">Color Primario</label>
                            <input type="color" class="form-control form-control-color" id="chatbot_color_primario" name="chatbot_color_primario" 
                                   value="<?php echo htmlspecialchars($configuraciones['chatbot_color_primario'] ?? '#667eea'); ?>">
                            <small class="text-muted">Color principal del widget</small>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="chatbot_color_secundario" class="form-label">Color Secundario</label>
                            <input type="color" class="form-control form-control-color" id="chatbot_color_secundario" name="chatbot_color_secundario" 
                                   value="<?php echo htmlspecialchars($configuraciones['chatbot_color_secundario'] ?? '#764ba2'); ?>">
                            <small class="text-muted">Color secundario del widget</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Analítica -->
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-bar-chart"></i> Analítica y Mejora Continua</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_guardar_conversaciones" name="chatbot_guardar_conversaciones" 
                                       value="1" <?php echo ($configuraciones['chatbot_guardar_conversaciones'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_guardar_conversaciones">
                                    Guardar Conversaciones
                                </label>
                                <small class="text-muted d-block">Para análisis posterior</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_solicitar_feedback" name="chatbot_solicitar_feedback" 
                                       value="1" <?php echo ($configuraciones['chatbot_solicitar_feedback'] ?? '1') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_solicitar_feedback">
                                    Solicitar Feedback
                                </label>
                                <small class="text-muted d-block">Calificación de satisfacción</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbot_aprendizaje_activo" name="chatbot_aprendizaje_activo" 
                                       value="1" <?php echo ($configuraciones['chatbot_aprendizaje_activo'] ?? '0') == '1' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="chatbot_aprendizaje_activo">
                                    Aprendizaje Activo
                                </label>
                                <small class="text-muted d-block">Mejora con machine learning</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info">
                <i class="bi bi-lightbulb"></i> <strong>Sugerencia:</strong> Los cambios en la configuración se aplicarán inmediatamente en todo el sistema. Asegúrate de probar el chatbot después de realizar cambios importantes.
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>dashboard" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver al Dashboard
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar Configuración
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-shield-check"></i> Información del Sistema</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <p><strong>Versión:</strong> 1.0.0</p>
            </div>
            <div class="col-md-4">
                <p><strong>PHP:</strong> <?php echo PHP_VERSION; ?></p>
            </div>
            <div class="col-md-4">
                <p><strong>Base de Datos:</strong> MySQL</p>
            </div>
        </div>
    </div>
</div>
