<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-cup-hot"></i> Restaurantes</h1>
    <?php if (hasAnyRole(['admin', 'editor'])): ?>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo BASE_URL; ?>restaurante/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Restaurante
        </a>
    </div>
    <?php endif; ?>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>restaurante">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Buscar por nombre">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Tipo de Comida</label>
                    <input type="text" class="form-control" name="tipo_comida" placeholder="Ej: Mexicana, Italiana">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Buscar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Tipo de Comida</th>
                        <th>Dirección</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($restaurantes)): ?>
                        <?php foreach ($restaurantes as $rest): ?>
                        <tr>
                            <td>
                                <img src="<?php echo getImageUrl($rest['imagen'], 'restaurantes'); ?>" 
                                     alt="<?php echo htmlspecialchars($rest['nombre']); ?>" 
                                     class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td><strong><?php echo htmlspecialchars($rest['nombre']); ?></strong></td>
                            <td><span class="badge bg-info"><?php echo htmlspecialchars($rest['tipo_comida']); ?></span></td>
                            <td><?php echo truncateText($rest['direccion'], 50); ?></td>
                            <td>
                                <?php if ($rest['telefono']): ?>
                                    <i class="bi bi-telephone"></i> <?php echo htmlspecialchars($rest['telefono']); ?><br>
                                <?php endif; ?>
                                <?php if ($rest['whatsapp']): ?>
                                    <i class="bi bi-whatsapp"></i> <?php echo htmlspecialchars($rest['whatsapp']); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($rest['activo']): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (hasAnyRole(['admin', 'editor'])): ?>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo BASE_URL; ?>restaurante/edit/<?php echo $rest['id']; ?>" 
                                       class="btn btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>restaurante/delete/<?php echo $rest['id']; ?>" 
                                       class="btn btn-outline-danger delete-confirm" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay restaurantes registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
