<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-calendar-event"></i> <?php echo $evento ? 'Editar Evento' : 'Nuevo Evento'; ?></h1>
    <a href="<?php echo BASE_URL; ?>evento" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>evento/<?php echo $evento ? 'update/' . $evento['id'] : 'store'; ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Evento *</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $evento ? htmlspecialchars($evento['nombre']) : ''; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción *</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $evento ? htmlspecialchars($evento['descripcion']) : ''; ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $evento ? $evento['fecha_inicio'] : ''; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fecha_fin" class="form-label">Fecha de Fin *</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $evento ? $evento['fecha_fin'] : ''; ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación *</label>
                <textarea class="form-control" id="ubicacion" name="ubicacion" rows="2" required><?php echo $evento ? htmlspecialchars($evento['ubicacion']) : ''; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="enlace_boletos" class="form-label">Enlace de Compra de Boletos</label>
                <input type="url" class="form-control" id="enlace_boletos" name="enlace_boletos" value="<?php echo $evento ? htmlspecialchars($evento['enlace_boletos']) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <?php if ($evento && $evento['imagen']): ?>
                <div class="mb-2"><img src="<?php echo getImageUrl($evento['imagen'], 'eventos'); ?>" class="img-thumbnail" style="max-width: 200px;"></div>
                <?php endif; ?>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" <?php echo (!$evento || $evento['activo']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                <a href="<?php echo BASE_URL; ?>evento" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
