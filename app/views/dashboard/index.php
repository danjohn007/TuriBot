<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-speedometer2"></i> Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <span class="badge bg-primary p-2">
                <i class="bi bi-clock"></i> <?php echo date('d/m/Y H:i'); ?>
            </span>
        </div>
    </div>
</div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-primary border-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Hospedajes</h6>
                        <h2 class="mb-0"><?php echo $stats['hospedajes']; ?></h2>
                    </div>
                    <div class="text-primary" style="font-size: 3rem;">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-success border-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Restaurantes</h6>
                        <h2 class="mb-0"><?php echo $stats['restaurantes']; ?></h2>
                    </div>
                    <div class="text-success" style="font-size: 3rem;">
                        <i class="bi bi-cup-hot"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-info border-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Atracciones</h6>
                        <h2 class="mb-0"><?php echo $stats['atracciones']; ?></h2>
                    </div>
                    <div class="text-info" style="font-size: 3rem;">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-warning border-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Eventos</h6>
                        <h2 class="mb-0"><?php echo $stats['eventos']; ?></h2>
                    </div>
                    <div class="text-warning" style="font-size: 3rem;">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-danger border-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Emergencias</h6>
                        <h2 class="mb-0"><?php echo $stats['emergencias']; ?></h2>
                    </div>
                    <div class="text-danger" style="font-size: 3rem;">
                        <i class="bi bi-telephone"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (hasRole('admin')): ?>
    <div class="col-md-4 mb-3">
        <div class="card stat-card border-start border-secondary border-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Usuarios</h6>
                        <h2 class="mb-0"><?php echo $stats['usuarios']; ?></h2>
                    </div>
                    <div class="text-secondary" style="font-size: 3rem;">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Actividad Reciente -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-activity"></i> Actividad Reciente</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Acción</th>
                                <th>Módulo</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentActivity)): ?>
                                <?php foreach ($recentActivity as $activity): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($activity['usuario_nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($activity['accion']); ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?php echo htmlspecialchars($activity['modulo']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo formatDate($activity['fecha_creacion'], 'd/m/Y H:i'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay actividad reciente</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
