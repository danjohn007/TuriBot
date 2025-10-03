<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Usuario.php';

/**
 * Controlador de Autenticación
 */
class AuthController extends BaseController {
    private $usuarioModel;
    
    public function __construct() {
        parent::__construct();
        $this->usuarioModel = new Usuario();
    }
    
    /**
     * Muestra formulario de login
     */
    public function login() {
        if (isLoggedIn()) {
            redirect('dashboard');
        }
        
        $this->viewWithoutLayout('auth/login');
    }
    
    /**
     * Procesa el login
     */
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('auth/login');
        }
        
        $email = cleanInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validar campos
        if (empty($email) || empty($password)) {
            setFlash('danger', 'Por favor complete todos los campos');
            redirect('auth/login');
        }
        
        // Verificar credenciales
        $user = $this->usuarioModel->verify($email, $password);
        
        if ($user) {
            // Establecer sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nombre'] = $user['nombre'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_rol'] = $user['rol'];
            
            // Registrar actividad
            logActivity('Inicio de sesión', 'auth');
            
            setFlash('success', '¡Bienvenido ' . $user['nombre'] . '!');
            redirect('dashboard');
        } else {
            setFlash('danger', 'Credenciales incorrectas');
            redirect('auth/login');
        }
    }
    
    /**
     * Cierra sesión
     */
    public function logout() {
        logActivity('Cierre de sesión', 'auth');
        
        session_destroy();
        redirect('auth/login');
    }
    
    /**
     * Muestra formulario de recuperación
     */
    public function recovery() {
        if (isLoggedIn()) {
            redirect('dashboard');
        }
        
        $this->viewWithoutLayout('auth/recovery');
    }
    
    /**
     * Envía email de recuperación
     */
    public function sendRecovery() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('auth/recovery');
        }
        
        $email = cleanInput($_POST['email'] ?? '');
        
        if (empty($email) || !validateEmail($email)) {
            setFlash('danger', 'Por favor ingrese un email válido');
            redirect('auth/recovery');
        }
        
        $user = $this->usuarioModel->findByEmail($email);
        
        if ($user) {
            $token = $this->usuarioModel->generateRecoveryToken($email);
            
            if ($token) {
                // En producción, aquí se enviaría un email
                // Por ahora, mostraremos el link
                $resetLink = BASE_URL . 'auth/reset/' . $token;
                
                setFlash('success', 'Se ha generado un link de recuperación. Link: ' . $resetLink);
            } else {
                setFlash('danger', 'Error al generar el token de recuperación');
            }
        } else {
            // Por seguridad, no revelamos si el email existe
            setFlash('success', 'Si el email existe, recibirá un link de recuperación');
        }
        
        redirect('auth/recovery');
    }
    
    /**
     * Muestra formulario de reset
     */
    public function reset($token = null) {
        if (isLoggedIn()) {
            redirect('dashboard');
        }
        
        if (!$token) {
            redirect('auth/login');
        }
        
        $user = $this->usuarioModel->validateRecoveryToken($token);
        
        if (!$user) {
            setFlash('danger', 'Token inválido o expirado');
            redirect('auth/login');
        }
        
        $this->viewWithoutLayout('auth/reset', ['token' => $token]);
    }
    
    /**
     * Procesa el reset de contraseña
     */
    public function processReset() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('auth/login');
        }
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($password) || empty($confirmPassword)) {
            setFlash('danger', 'Por favor complete todos los campos');
            redirect('auth/reset/' . $token);
        }
        
        if ($password !== $confirmPassword) {
            setFlash('danger', 'Las contraseñas no coinciden');
            redirect('auth/reset/' . $token);
        }
        
        if (strlen($password) < 6) {
            setFlash('danger', 'La contraseña debe tener al menos 6 caracteres');
            redirect('auth/reset/' . $token);
        }
        
        if ($this->usuarioModel->resetPassword($token, $password)) {
            setFlash('success', 'Contraseña actualizada correctamente');
            redirect('auth/login');
        } else {
            setFlash('danger', 'Error al actualizar la contraseña');
            redirect('auth/reset/' . $token);
        }
    }
}
?>
