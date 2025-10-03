<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-building"></i> Hospedajes</h1>
    <?php if (hasAnyRole(['admin', 'editor'])): ?>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo BASE_URL; ?>hospedaje/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Hospedaje
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- Filtros de búsqueda -->
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>hospedaje">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" placeholder="Buscar por nombre">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Categoría</label>
                    <select class="form-select" name="categoria">
                        <option value="">Todas</option>
                        <option value="1">⭐ 1 Estrella</option>
                        <option value="2">⭐⭐ 2 Estrellas</option>
                        <option value="3">⭐⭐⭐ 3 Estrellas</option>
                        <option value="4">⭐⭐⭐⭐ 4 Estrellas</option>
                        <option value="5">⭐⭐⭐⭐⭐ 5 Estrellas</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Precio Mín.</label>
                    <input type="number" class="form-control" name="precio_min" placeholder="0">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Precio Máx.</label>
                    <input type="number" class="form-control" name="precio_max" placeholder="9999">
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Listado de hospedajes -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Rango de Precios</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($hospedajes)): ?>
                        <?php foreach ($hospedajes as $hospedaje): ?>
                        <tr>
                            <td>
                                <img src="<?php echo getImageUrl($hospedaje['imagen'], 'hospedaje'); ?>" 
                                     alt="<?php echo htmlspecialchars($hospedaje['nombre']); ?>" 
                                     class="img-thumbnail" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td><strong><?php echo htmlspecialchars($hospedaje['nombre']); ?></strong></td>
                            <td><?php echo renderStars($hospedaje['categoria']); ?></td>
                            <td><?php echo truncateText($hospedaje['direccion'], 50); ?></td>
                            <td><?php echo htmlspecialchars($hospedaje['telefono']); ?></td>
                            <td>
                                <?php if ($hospedaje['rango_precio_min'] && $hospedaje['rango_precio_max']): ?>
                                    <?php echo formatCurrency($hospedaje['rango_precio_min']); ?> - 
                                    <?php echo formatCurrency($hospedaje['rango_precio_max']); ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($hospedaje['activo']): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (hasAnyRole(['admin', 'editor'])): ?>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo BASE_URL; ?>hospedaje/edit/<?php echo $hospedaje['id']; ?>" 
                                       class="btn btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>hospedaje/delete/<?php echo $hospedaje['id']; ?>" 
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
                            <td colspan="8" class="text-center text-muted">
                                No hay hospedajes registrados
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
