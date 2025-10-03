<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-gear"></i> Configuración General del Sistema</h1>
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
                </div>
                <div class="col-md-6 mb-3">
                    <label for="logo_sistema" class="form-label">Logo del Sistema (nombre archivo)</label>
                    <input type="text" class="form-control" id="logo_sistema" name="logo_sistema" 
                           value="<?php echo htmlspecialchars($configuraciones['logo_sistema'] ?? ''); ?>">
                </div>
            </div>
            
            <hr>
            
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
            
            <hr>
            
            <h5 class="mb-3"><i class="bi bi-robot"></i> Configuración del ChatBot</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="chatbot_nombre" class="form-label">Nombre del ChatBot</label>
                    <input type="text" class="form-control" id="chatbot_nombre" name="chatbot_nombre" 
                           value="<?php echo htmlspecialchars($configuraciones['chatbot_nombre'] ?? 'TuriBot'); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="chatbot_activado" class="form-label">Estado</label>
                    <select class="form-control" id="chatbot_activado" name="chatbot_activado">
                        <option value="1" <?php echo ($configuraciones['chatbot_activado'] ?? '1') == '1' ? 'selected' : ''; ?>>Activado</option>
                        <option value="0" <?php echo ($configuraciones['chatbot_activado'] ?? '1') == '0' ? 'selected' : ''; ?>>Desactivado</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="mensaje_bienvenida" class="form-label">Mensaje de Bienvenida</label>
                <textarea class="form-control" id="mensaje_bienvenida" name="mensaje_bienvenida" rows="2"><?php echo htmlspecialchars($configuraciones['mensaje_bienvenida'] ?? ''); ?></textarea>
                <small class="text-muted">Primer mensaje que ve el usuario al abrir el chatbot</small>
            </div>
            
            <div class="mb-3">
                <label for="chatbot_tono_conversacion" class="form-label">Tono de Conversación</label>
                <select class="form-control" id="chatbot_tono_conversacion" name="chatbot_tono_conversacion">
                    <option value="formal" <?php echo ($configuraciones['chatbot_tono_conversacion'] ?? 'amigable') == 'formal' ? 'selected' : ''; ?>>Formal</option>
                    <option value="amigable" <?php echo ($configuraciones['chatbot_tono_conversacion'] ?? 'amigable') == 'amigable' ? 'selected' : ''; ?>>Amigable</option>
                    <option value="casual" <?php echo ($configuraciones['chatbot_tono_conversacion'] ?? 'amigable') == 'casual' ? 'selected' : ''; ?>>Casual</option>
                    <option value="profesional" <?php echo ($configuraciones['chatbot_tono_conversacion'] ?? 'amigable') == 'profesional' ? 'selected' : ''; ?>>Profesional</option>
                </select>
            </div>
            
            <div class="alert alert-info">
                <i class="bi bi-lightbulb"></i> <strong>Sugerencia:</strong> Los cambios en la configuración se aplicarán inmediatamente en el sistema administrativo y en el ChatBot. Para configuración avanzada, visita <a href="<?php echo BASE_URL; ?>configuracion/general">Configuraciones Generales</a>.
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Guardar Configuración
            </button>
        </form>
    </div>
</div>
