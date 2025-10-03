<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-calendar-event"></i> Eventos</h1>
    <?php if (hasAnyRole(['admin', 'editor'])): ?>
    <a href="<?php echo BASE_URL; ?>evento/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nuevo Evento</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($eventos)): ?>
                        <?php foreach ($eventos as $evt): ?>
                        <tr>
                            <td><img src="<?php echo getImageUrl($evt['imagen'], 'eventos'); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;"></td>
                            <td><strong><?php echo htmlspecialchars($evt['nombre']); ?></strong></td>
                            <td><?php echo formatDate($evt['fecha_inicio']); ?></td>
                            <td><?php echo formatDate($evt['fecha_fin']); ?></td>
                            <td><?php echo truncateText($evt['ubicacion'], 40); ?></td>
                            <td><?php echo $evt['activo'] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>'; ?></td>
                            <td>
                                <?php if (hasAnyRole(['admin', 'editor'])): ?>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo BASE_URL; ?>evento/edit/<?php echo $evt['id']; ?>" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="<?php echo BASE_URL; ?>evento/delete/<?php echo $evt['id']; ?>" class="btn btn-outline-danger delete-confirm"><i class="bi bi-trash"></i></a>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center text-muted">No hay eventos registrados</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
