<?php
// Configuración del sistema TuriBot
// Detectar automáticamente la URL base

// Función para detectar la URL base automáticamente
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $scriptPath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $scriptPath = ($scriptPath === '/') ? '' : $scriptPath;
    return $protocol . "://" . $host . $scriptPath;
}

// Configuración de Base URL
define('BASE_URL', getBaseUrl() . '/');

// Configuración de Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'fix360_recaudabot');
define('DB_USER', 'fix360_recaudabot');
define('DB_PASS', 'Danjohn007!');
define('DB_CHARSET', 'utf8mb4');

// Configuración de la aplicación
define('APP_NAME', 'TuriBot Admin');
define('APP_VERSION', '1.0.0');
define('SITE_LOGO', BASE_URL . 'public/img/logo.png');

// Configuración de sesiones
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
session_name('TURIBOT_SESSION');

// Zona horaria
date_default_timezone_set('America/Mexico_City');

// Configuración de errores (desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de uploads
define('UPLOAD_MAX_SIZE', 5242880); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');
?>
