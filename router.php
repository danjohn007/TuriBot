<?php
/**
 * Router for PHP built-in server
 * This mimics the .htaccess rewrite rules
 */

// Get the requested URI
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the file exists (CSS, JS, images), serve it directly
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Otherwise, route through index.php
$_GET['url'] = trim($uri, '/');
require __DIR__ . '/index.php';
?>
