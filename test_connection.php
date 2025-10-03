<?php
/**
 * Test de conexión y verificación de URL Base
 * Este archivo verifica que la configuración sea correcta
 */
require_once 'config/config.php';

// Test de URL Base
$url_base_detectada = BASE_URL;
$protocolo_detectado = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$host_detectado = $_SERVER['HTTP_HOST'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Conexión - TuriBot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .test-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
        }
        .test-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }
        .status-ok {
            color: #28a745;
        }
        .status-error {
            color: #dc3545;
        }
        .info-row {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="test-card">
            <div class="test-header">
                <h1><i class="bi bi-gear-fill"></i> Test de Configuración</h1>
                <p class="mb-0">Sistema TuriBot - Verificación de Instalación</p>
            </div>
            <div class="card-body p-4">
                <h4 class="mb-4">Configuración del Sistema</h4>
                
                <div class="info-row">
                    <strong><i class="bi bi-link-45deg"></i> URL Base Detectada:</strong><br>
                    <code class="text-primary"><?php echo htmlspecialchars($url_base_detectada); ?></code>
                </div>
                
                <div class="info-row">
                    <strong><i class="bi bi-shield-lock"></i> Protocolo:</strong><br>
                    <code><?php echo htmlspecialchars($protocolo_detectado); ?></code>
                </div>
                
                <div class="info-row">
                    <strong><i class="bi bi-hdd-network"></i> Host:</strong><br>
                    <code><?php echo htmlspecialchars($host_detectado); ?></code>
                </div>
                
                <div class="info-row">
                    <strong><i class="bi bi-folder"></i> Ruta del Script:</strong><br>
                    <code><?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?></code>
                </div>
                
                <hr class="my-4">
                
                <h4 class="mb-4">Test de Base de Datos</h4>
                
                <?php
                try {
                    require_once 'config/database.php';
                    $db = Database::getInstance();
                    $conn = $db->getConnection();
                    
                    // Test de consulta simple
                    $stmt = $conn->query("SELECT 1");
                    $result = $stmt->fetch();
                    
                    echo '<div class="alert alert-success" role="alert">';
                    echo '<i class="bi bi-check-circle-fill"></i> <strong>¡Conexión exitosa!</strong><br>';
                    echo 'La conexión a la base de datos <strong>' . DB_NAME . '</strong> fue establecida correctamente.';
                    echo '</div>';
                    
                    // Verificar si existen las tablas
                    $stmt = $conn->query("SHOW TABLES");
                    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    
                    if (count($tables) > 0) {
                        echo '<div class="alert alert-info" role="alert">';
                        echo '<i class="bi bi-info-circle-fill"></i> <strong>Tablas encontradas:</strong> ' . count($tables);
                        echo '<br><small>Tablas: ' . implode(', ', $tables) . '</small>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-warning" role="alert">';
                        echo '<i class="bi bi-exclamation-triangle-fill"></i> <strong>Base de datos vacía</strong><br>';
                        echo 'Por favor, importa el archivo <code>database/turibot_schema.sql</code>';
                        echo '</div>';
                    }
                    
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo '<i class="bi bi-x-circle-fill"></i> <strong>Error de conexión</strong><br>';
                    echo 'No se pudo conectar a la base de datos. Verifica las credenciales en <code>config/config.php</code><br>';
                    echo '<small class="text-muted">Error: ' . htmlspecialchars($e->getMessage()) . '</small>';
                    echo '</div>';
                }
                ?>
                
                <hr class="my-4">
                
                <h4 class="mb-4">Información del PHP</h4>
                
                <div class="info-row">
                    <strong><i class="bi bi-file-code"></i> Versión de PHP:</strong><br>
                    <code><?php echo PHP_VERSION; ?></code>
                    <?php if (version_compare(PHP_VERSION, '7.4.0', '>=')): ?>
                        <span class="status-ok"><i class="bi bi-check-circle-fill"></i> Compatible</span>
                    <?php else: ?>
                        <span class="status-error"><i class="bi bi-x-circle-fill"></i> Se requiere PHP 7.4 o superior</span>
                    <?php endif; ?>
                </div>
                
                <div class="info-row">
                    <strong><i class="bi bi-plugin"></i> Extensión PDO:</strong><br>
                    <?php if (extension_loaded('pdo')): ?>
                        <span class="status-ok"><i class="bi bi-check-circle-fill"></i> Instalada</span>
                    <?php else: ?>
                        <span class="status-error"><i class="bi bi-x-circle-fill"></i> No instalada</span>
                    <?php endif; ?>
                </div>
                
                <div class="info-row">
                    <strong><i class="bi bi-plugin"></i> PDO MySQL:</strong><br>
                    <?php if (extension_loaded('pdo_mysql')): ?>
                        <span class="status-ok"><i class="bi bi-check-circle-fill"></i> Instalada</span>
                    <?php else: ?>
                        <span class="status-error"><i class="bi bi-x-circle-fill"></i> No instalada</span>
                    <?php endif; ?>
                </div>
                
                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-house-door"></i> Ir al Sistema
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
