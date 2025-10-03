<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-telephone"></i> Contactos de Emergencia</h1>
    <?php if (hasAnyRole(['admin', 'editor'])): ?>
    <a href="<?php echo BASE_URL; ?>emergencia/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nuevo Contacto</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Número</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($emergencias)): ?>
                        <?php foreach ($emergencias as $emg): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($emg['nombre']); ?></strong></td>
                            <td><span class="badge bg-danger fs-6"><?php echo htmlspecialchars($emg['numero']); ?></span></td>
                            <td><?php echo ucfirst(str_replace('_', ' ', $emg['tipo'])); ?></td>
                            <td><?php echo htmlspecialchars($emg['descripcion']); ?></td>
                            <td><?php echo $emg['activo'] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>'; ?></td>
                            <td>
                                <?php if (hasAnyRole(['admin', 'editor'])): ?>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo BASE_URL; ?>emergencia/edit/<?php echo $emg['id']; ?>" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <a href="<?php echo BASE_URL; ?>emergencia/delete/<?php echo $emg['id']; ?>" class="btn btn-outline-danger delete-confirm"><i class="bi bi-trash"></i></a>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted">No hay contactos registrados</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
