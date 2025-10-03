<?php
/**
 * Funciones auxiliares del sistema
 */

/**
 * Redirige a una URL
 */
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

/**
 * Muestra mensajes flash en la sesión
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Obtiene y elimina el mensaje flash
 */
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Verifica si el usuario está autenticado
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Obtiene el usuario actual de la sesión
 */
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'nombre' => $_SESSION['user_nombre'],
            'email' => $_SESSION['user_email'],
            'rol' => $_SESSION['user_rol']
        ];
    }
    return null;
}

/**
 * Verifica si el usuario tiene un rol específico
 */
function hasRole($role) {
    return isLoggedIn() && $_SESSION['user_rol'] === $role;
}

/**
 * Verifica si el usuario tiene uno de los roles especificados
 */
function hasAnyRole($roles) {
    if (!isLoggedIn()) return false;
    return in_array($_SESSION['user_rol'], $roles);
}

/**
 * Registra una actividad en el log
 */
function logActivity($accion, $modulo, $detalles = null) {
    if (!isLoggedIn()) return;
    
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $stmt = $conn->prepare("INSERT INTO log_actividades (usuario_id, accion, modulo, detalles, ip_address) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $accion,
            $modulo,
            $detalles,
            $_SERVER['REMOTE_ADDR']
        ]);
    } catch (Exception $e) {
        // Silenciosamente fallar el log para no interrumpir la aplicación
        error_log("Error al registrar actividad: " . $e->getMessage());
    }
}

/**
 * Limpia y valida input
 */
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Valida email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Sube una imagen y retorna el nombre del archivo
 */
function uploadImage($file, $folder) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    
    // Validar tamaño
    if ($file['size'] > UPLOAD_MAX_SIZE) {
        throw new Exception("El archivo es demasiado grande. Máximo 5MB.");
    }
    
    // Validar extensión
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, ALLOWED_EXTENSIONS)) {
        throw new Exception("Formato de archivo no permitido. Use JPG, PNG o GIF.");
    }
    
    // Generar nombre único
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $uploadPath = UPLOAD_PATH . '/' . $folder;
    
    // Crear directorio si no existe
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }
    
    // Mover archivo
    $destination = $uploadPath . '/' . $filename;
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $filename;
    }
    
    throw new Exception("Error al subir el archivo.");
}

/**
 * Elimina una imagen
 */
function deleteImage($filename, $folder) {
    if (empty($filename)) return;
    
    $filepath = UPLOAD_PATH . '/' . $folder . '/' . $filename;
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}

/**
 * Formatea fecha
 */
function formatDate($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}

/**
 * Genera estrellas HTML para categoría de hotel
 */
function renderStars($count) {
    $html = '';
    for ($i = 0; $i < $count; $i++) {
        $html .= '<i class="bi bi-star-fill text-warning"></i>';
    }
    return $html;
}

/**
 * Genera token de seguridad para formularios
 */
function generateToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valida token de seguridad
 */
function validateToken($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    return true;
}

/**
 * Formatea moneda
 */
function formatCurrency($amount) {
    return '$' . number_format($amount, 2, '.', ',');
}

/**
 * Genera URL de imagen
 */
function getImageUrl($filename, $folder) {
    if (empty($filename)) {
        return BASE_URL . 'public/img/no-image.png';
    }
    return BASE_URL . 'public/uploads/' . $folder . '/' . $filename;
}

/**
 * Trunca texto
 */
function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}
?>
