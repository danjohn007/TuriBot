<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-geo-alt"></i> <?php echo $atraccion ? 'Editar Atracción' : 'Nueva Atracción'; ?></h1>
    <a href="<?php echo BASE_URL; ?>atraccion" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>atraccion/<?php echo $atraccion ? 'update/' . $atraccion['id'] : 'store'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="nombre" class="form-label">Nombre del Sitio *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $atraccion ? htmlspecialchars($atraccion['nombre']) : ''; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="categoria" class="form-label">Categoría *</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="">Seleccione...</option>
                        <option value="natural" <?php echo ($atraccion && $atraccion['categoria'] == 'natural') ? 'selected' : ''; ?>>Natural</option>
                        <option value="cultural" <?php echo ($atraccion && $atraccion['categoria'] == 'cultural') ? 'selected' : ''; ?>>Cultural</option>
                        <option value="historica" <?php echo ($atraccion && $atraccion['categoria'] == 'historica') ? 'selected' : ''; ?>>Histórica</option>
                        <option value="recreativa" <?php echo ($atraccion && $atraccion['categoria'] == 'recreativa') ? 'selected' : ''; ?>>Recreativa</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción *</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $atraccion ? htmlspecialchars($atraccion['descripcion']) : ''; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección/Ubicación *</label>
                <textarea class="form-control" id="direccion" name="direccion" rows="2" required><?php echo $atraccion ? htmlspecialchars($atraccion['direccion']) : ''; ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="horario_apertura" class="form-label">Horario Apertura</label>
                    <input type="time" class="form-control" id="horario_apertura" name="horario_apertura" value="<?php echo $atraccion ? $atraccion['horario_apertura'] : ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="horario_cierre" class="form-label">Horario Cierre</label>
                    <input type="time" class="form-control" id="horario_cierre" name="horario_cierre" value="<?php echo $atraccion ? $atraccion['horario_cierre'] : ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="costo_acceso" class="form-label">Costo de Acceso</label>
                    <input type="number" step="0.01" class="form-control" id="costo_acceso" name="costo_acceso" value="<?php echo $atraccion ? $atraccion['costo_acceso'] : '0'; ?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="enlace_externo" class="form-label">Enlace Externo</label>
                    <input type="url" class="form-control" id="enlace_externo" name="enlace_externo" value="<?php echo $atraccion ? htmlspecialchars($atraccion['enlace_externo']) : ''; ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contacto" class="form-label">Contacto</label>
                    <input type="text" class="form-control" id="contacto" name="contacto" value="<?php echo $atraccion ? htmlspecialchars($atraccion['contacto']) : ''; ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <?php if ($atraccion && $atraccion['imagen']): ?>
                <div class="mb-2"><img src="<?php echo getImageUrl($atraccion['imagen'], 'atracciones'); ?>" class="img-thumbnail" style="max-width: 200px;"></div>
                <?php endif; ?>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" <?php echo (!$atraccion || $atraccion['activo']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                <a href="<?php echo BASE_URL; ?>atraccion" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
