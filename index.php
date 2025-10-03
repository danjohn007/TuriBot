<?php
/**
 * TuriBot - Sistema Administrativo
 * Punto de entrada principal de la aplicación
 */

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar configuración
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'app/helpers/functions.php';

// Obtener la URL solicitada
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Determinar controlador y método
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'DashboardController';
$methodName = isset($url[1]) && !empty($url[1]) ? $url[1] : 'index';

// Parámetros adicionales
$params = array_slice($url, 2);

// Ruta por defecto - si no está logueado, ir a login
if (empty($url[0]) && !isLoggedIn()) {
    $controllerName = 'AuthController';
    $methodName = 'login';
}

// Ruta del controlador
$controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';

// Verificar si existe el controlador
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        
        if (method_exists($controller, $methodName)) {
            call_user_func_array([$controller, $methodName], $params);
        } else {
            // Método no encontrado
            http_response_code(404);
            echo "Método no encontrado: " . htmlspecialchars($methodName);
        }
    } else {
        // Clase no encontrada
        http_response_code(404);
        echo "Controlador no encontrado: " . htmlspecialchars($controllerName);
    }
} else {
    // Archivo no encontrado
    http_response_code(404);
    echo "Página no encontrada: " . htmlspecialchars($url[0]);
}
?>
