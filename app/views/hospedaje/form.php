<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-building"></i> 
        <?php echo $hospedaje ? 'Editar Hospedaje' : 'Nuevo Hospedaje'; ?>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo BASE_URL; ?>hospedaje" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" 
              action="<?php echo BASE_URL; ?>hospedaje/<?php echo $hospedaje ? 'update/' . $hospedaje['id'] : 'store'; ?>" 
              enctype="multipart/form-data">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre del Establecimiento *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" 
                           value="<?php echo $hospedaje ? htmlspecialchars($hospedaje['nombre']) : ''; ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label">Categoría (Estrellas) *</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="">Seleccione...</option>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?php echo $i; ?>" 
                                <?php echo ($hospedaje && $hospedaje['categoria'] == $i) ? 'selected' : ''; ?>>
                            <?php echo str_repeat('⭐', $i); ?> <?php echo $i; ?> Estrella<?php echo $i > 1 ? 's' : ''; ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección *</label>
                <textarea class="form-control" id="direccion" name="direccion" rows="2" required><?php echo $hospedaje ? htmlspecialchars($hospedaje['direccion']) : ''; ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="telefono" class="form-label">Teléfono de Contacto</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" 
                           value="<?php echo $hospedaje ? htmlspecialchars($hospedaje['telefono']) : ''; ?>">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="rango_precio_min" class="form-label">Precio Mínimo</label>
                    <input type="number" step="0.01" class="form-control" id="rango_precio_min" name="rango_precio_min" 
                           value="<?php echo $hospedaje ? $hospedaje['rango_precio_min'] : ''; ?>">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="rango_precio_max" class="form-label">Precio Máximo</label>
                    <input type="number" step="0.01" class="form-control" id="rango_precio_max" name="rango_precio_max" 
                           value="<?php echo $hospedaje ? $hospedaje['rango_precio_max'] : ''; ?>">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="enlace_reservacion" class="form-label">Enlace a Reservación</label>
                    <input type="url" class="form-control" id="enlace_reservacion" name="enlace_reservacion" 
                           value="<?php echo $hospedaje ? htmlspecialchars($hospedaje['enlace_reservacion']) : ''; ?>" 
                           placeholder="https://ejemplo.com/reservas">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="sitio_web" class="form-label">Sitio Web</label>
                    <input type="url" class="form-control" id="sitio_web" name="sitio_web" 
                           value="<?php echo $hospedaje ? htmlspecialchars($hospedaje['sitio_web']) : ''; ?>" 
                           placeholder="https://ejemplo.com">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen Representativa</label>
                <?php if ($hospedaje && $hospedaje['imagen']): ?>
                <div class="mb-2">
                    <img src="<?php echo getImageUrl($hospedaje['imagen'], 'hospedaje'); ?>" 
                         alt="Imagen actual" class="img-thumbnail" style="max-width: 200px;">
                </div>
                <?php endif; ?>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                <small class="text-muted">Formatos permitidos: JPG, PNG, GIF. Máximo 5MB.</small>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" 
                       <?php echo (!$hospedaje || $hospedaje['activo']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="activo">
                    Activo (visible en el ChatBot)
                </label>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar
                </button>
                <a href="<?php echo BASE_URL; ?>hospedaje" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
