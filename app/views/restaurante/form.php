<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-cup-hot"></i> <?php echo $restaurante ? 'Editar Restaurante' : 'Nuevo Restaurante'; ?></h1>
    <a href="<?php echo BASE_URL; ?>restaurante" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>restaurante/<?php echo $restaurante ? 'update/' . $restaurante['id'] : 'store'; ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Restaurante *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $restaurante ? htmlspecialchars($restaurante['nombre']) : ''; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tipo_comida" class="form-label">Tipo de Comida *</label>
                    <input type="text" class="form-control" id="tipo_comida" name="tipo_comida" value="<?php echo $restaurante ? htmlspecialchars($restaurante['tipo_comida']) : ''; ?>" placeholder="Ej: Mexicana, Italiana, Vegetariana" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección *</label>
                <textarea class="form-control" id="direccion" name="direccion" rows="2" required><?php echo $restaurante ? htmlspecialchars($restaurante['direccion']) : ''; ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $restaurante ? htmlspecialchars($restaurante['telefono']) : ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="whatsapp" class="form-label">WhatsApp</label>
                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?php echo $restaurante ? htmlspecialchars($restaurante['whatsapp']) : ''; ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="enlace_reservacion" class="form-label">Enlace Reservación</label>
                    <input type="url" class="form-control" id="enlace_reservacion" name="enlace_reservacion" value="<?php echo $restaurante ? htmlspecialchars($restaurante['enlace_reservacion']) : ''; ?>">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="sitio_web" class="form-label">Sitio Web</label>
                <input type="url" class="form-control" id="sitio_web" name="sitio_web" value="<?php echo $restaurante ? htmlspecialchars($restaurante['sitio_web']) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <?php if ($restaurante && $restaurante['imagen']): ?>
                <div class="mb-2">
                    <img src="<?php echo getImageUrl($restaurante['imagen'], 'restaurantes'); ?>" class="img-thumbnail" style="max-width: 200px;">
                </div>
                <?php endif; ?>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" <?php echo (!$restaurante || $restaurante['activo']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="activo">Activo</label>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                <a href="<?php echo BASE_URL; ?>restaurante" class="btn btn-secondary"><i class="bi bi-x-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
