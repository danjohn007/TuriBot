<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-people"></i> <?php echo $usuario ? 'Editar Usuario' : 'Nuevo Usuario'; ?></h1>
    <a href="<?php echo BASE_URL; ?>usuario" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>usuario/<?php echo $usuario ? 'update/' . $usuario['id'] : 'store'; ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre Completo *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario ? htmlspecialchars($usuario['nombre']) : ''; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario ? htmlspecialchars($usuario['email']) : ''; ?>" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Contraseña <?php echo $usuario ? '(dejar vacío para mantener)' : '*'; ?></label>
                    <input type="password" class="form-control" id="password" name="password" <?php echo !$usuario ? 'required' : ''; ?> minlength="6">
                    <small class="text-muted">Mínimo 6 caracteres</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="rol" class="form-label">Rol *</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="">Seleccione...</option>
                        <option value="admin" <?php echo ($usuario && $usuario['rol'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                        <option value="editor" <?php echo ($usuario && $usuario['rol'] == 'editor') ? 'selected' : ''; ?>>Editor</option>
                        <option value="consultor" <?php echo ($usuario && $usuario['rol'] == 'consultor') ? 'selected' : ''; ?>>Consultor</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" <?php echo (!$usuario || $usuario['activo']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="activo">Usuario Activo</label>
            </div>
            
            <div class="alert alert-info">
                <strong>Permisos por Rol:</strong><br>
                <strong>Administrador:</strong> Acceso completo al sistema<br>
                <strong>Editor:</strong> Puede crear y editar contenido turístico<br>
                <strong>Consultor:</strong> Solo visualización de contenido
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                <a href="<?php echo BASE_URL; ?>usuario" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
