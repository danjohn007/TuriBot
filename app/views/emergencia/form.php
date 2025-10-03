<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-telephone"></i> <?php echo $emergencia ? 'Editar Contacto' : 'Nuevo Contacto'; ?></h1>
    <a href="<?php echo BASE_URL; ?>emergencia" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>emergencia/<?php echo $emergencia ? 'update/' . $emergencia['id'] : 'store'; ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $emergencia ? htmlspecialchars($emergencia['nombre']) : ''; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="numero" class="form-label">Número *</label>
                    <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $emergencia ? htmlspecialchars($emergencia['numero']) : ''; ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo *</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione...</option>
                    <option value="cruz_roja" <?php echo ($emergencia && $emergencia['tipo'] == 'cruz_roja') ? 'selected' : ''; ?>>Cruz Roja</option>
                    <option value="bomberos" <?php echo ($emergencia && $emergencia['tipo'] == 'bomberos') ? 'selected' : ''; ?>>Bomberos</option>
                    <option value="policia" <?php echo ($emergencia && $emergencia['tipo'] == 'policia') ? 'selected' : ''; ?>>Policía Municipal</option>
                    <option value="proteccion_civil" <?php echo ($emergencia && $emergencia['tipo'] == 'proteccion_civil') ? 'selected' : ''; ?>>Protección Civil</option>
                    <option value="otro" <?php echo ($emergencia && $emergencia['tipo'] == 'otro') ? 'selected' : ''; ?>>Otro</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="2"><?php echo $emergencia ? htmlspecialchars($emergencia['descripcion']) : ''; ?></textarea>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" <?php echo (!$emergencia || $emergencia['activo']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                <a href="<?php echo BASE_URL; ?>emergencia" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
