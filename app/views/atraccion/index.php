<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-geo-alt"></i> Atracciones Turísticas</h1>
    <?php if (hasAnyRole(['admin', 'editor'])): ?>
    <a href="<?php echo BASE_URL; ?>atraccion/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nueva Atracción</a>
    <?php endif; ?>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?php echo BASE_URL; ?>atraccion">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="nombre" placeholder="Buscar por nombre">
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="categoria">
                        <option value="">Todas las categorías</option>
                        <option value="natural">Natural</option>
                        <option value="cultural">Cultural</option>
                        <option value="historica">Histórica</option>
                        <option value="recreativa">Recreativa</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
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
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Costo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($atracciones)): ?>
                        <?php foreach ($atracciones as $atr): ?>
                        <tr>
                            <td><img src="<?php echo getImageUrl($atr['imagen'], 'atracciones'); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;"></td>
                            <td><strong><?php echo htmlspecialchars($atr['nombre']); ?></strong></td>
                            <td><span class="badge bg-info"><?php echo ucfirst($atr['categoria']); ?></span></td>
                            <td><?php echo truncateText($atr['descripcion'], 60); ?></td>
                            <td><?php echo formatCurrency($atr['costo_acceso']); ?></td>
                            <td><?php echo $atr['activo'] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>'; ?></td>
                            <td>
                                <?php if (hasAnyRole(['admin', 'editor'])): ?>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo BASE_URL; ?>atraccion/edit/<?php echo $atr['id']; ?>" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="<?php echo BASE_URL; ?>atraccion/delete/<?php echo $atr['id']; ?>" class="btn btn-outline-danger delete-confirm"><i class="bi bi-trash"></i></a>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">No hay atracciones registradas</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
