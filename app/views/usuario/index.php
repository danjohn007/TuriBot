<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-people"></i> Usuarios del Sistema</h1>
    <a href="<?php echo BASE_URL; ?>usuario/create" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nuevo Usuario</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usr): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($usr['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($usr['email']); ?></td>
                            <td>
                                <?php
                                $rolBadge = [
                                    'admin' => 'danger',
                                    'editor' => 'warning',
                                    'consultor' => 'info'
                                ];
                                ?>
                                <span class="badge bg-<?php echo $rolBadge[$usr['rol']]; ?>"><?php echo ucfirst($usr['rol']); ?></span>
                            </td>
                            <td><?php echo $usr['activo'] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>'; ?></td>
                            <td><?php echo formatDate($usr['fecha_creacion'], 'd/m/Y'); ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="<?php echo BASE_URL; ?>usuario/edit/<?php echo $usr['id']; ?>" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                    <?php if ($usr['id'] != $_SESSION['user_id']): ?>
                                    <a href="<?php echo BASE_URL; ?>usuario/delete/<?php echo $usr['id']; ?>" class="btn btn-outline-danger delete-confirm"><i class="bi bi-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center text-muted">No hay usuarios registrados</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
