<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-graph-up"></i> Reportes y Estadísticas</h1>
</div>

<!-- Estadísticas Generales -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center border-primary">
            <div class="card-body">
                <h3 class="text-primary"><?php echo $totals['hospedajes']; ?></h3>
                <p class="mb-0">Hospedajes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <h3 class="text-success"><?php echo $totals['restaurantes']; ?></h3>
                <p class="mb-0">Restaurantes</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center border-info">
            <div class="card-body">
                <h3 class="text-info"><?php echo $totals['atracciones']; ?></h3>
                <p class="mb-0">Atracciones</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center border-warning">
            <div class="card-body">
                <h3 class="text-warning"><?php echo $totals['eventos']; ?></h3>
                <p class="mb-0">Eventos</p>
            </div>
        </div>
    </div>
</div>

<!-- Gráficas -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-bar-chart"></i> Registros por Mes - <?php echo $year; ?></h5>
        <div class="btn-group btn-group-sm">
            <a href="<?php echo BASE_URL; ?>reporte?year=<?php echo $year - 1; ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> <?php echo $year - 1; ?>
            </a>
            <a href="<?php echo BASE_URL; ?>reporte?year=<?php echo $year + 1; ?>" class="btn btn-outline-secondary">
                <?php echo $year + 1; ?> <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        <canvas id="monthlyChart" style="max-height: 400px;"></canvas>
    </div>
</div>

<!-- Exportar Reportes -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-download"></i> Exportar Reportes</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="<?php echo BASE_URL; ?>reporte/export?tipo=hospedajes" class="btn btn-primary w-100">
                    <i class="bi bi-file-earmark-excel"></i> Hospedajes
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="<?php echo BASE_URL; ?>reporte/export?tipo=restaurantes" class="btn btn-success w-100">
                    <i class="bi bi-file-earmark-excel"></i> Restaurantes
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="<?php echo BASE_URL; ?>reporte/export?tipo=atracciones" class="btn btn-info w-100">
                    <i class="bi bi-file-earmark-excel"></i> Atracciones
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="<?php echo BASE_URL; ?>reporte/export?tipo=eventos" class="btn btn-warning w-100">
                    <i class="bi bi-file-earmark-excel"></i> Eventos
                </a>
            </div>
        </div>
        <p class="text-muted mb-0"><i class="bi bi-info-circle"></i> Los archivos se exportarán en formato CSV compatible con Excel</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [
                {
                    label: 'Hospedajes',
                    data: <?php echo json_encode($stats['hospedajes']); ?>,
                    backgroundColor: 'rgba(102, 126, 234, 0.7)',
                    borderColor: 'rgb(102, 126, 234)',
                    borderWidth: 1
                },
                {
                    label: 'Restaurantes',
                    data: <?php echo json_encode($stats['restaurantes']); ?>,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgb(40, 167, 69)',
                    borderWidth: 1
                },
                {
                    label: 'Atracciones',
                    data: <?php echo json_encode($stats['atracciones']); ?>,
                    backgroundColor: 'rgba(23, 162, 184, 0.7)',
                    borderColor: 'rgb(23, 162, 184)',
                    borderWidth: 1
                },
                {
                    label: 'Eventos',
                    data: <?php echo json_encode($stats['eventos']); ?>,
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgb(255, 193, 7)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Nuevos registros por mes en <?php echo $year; ?>'
                }
            }
        }
    });
});
</script>
