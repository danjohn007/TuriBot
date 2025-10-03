<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Usuario.php';

/**
 * Controlador del Perfil de Usuario
 */
class PerfilController extends BaseController {
    private $usuarioModel;
    
    public function __construct() {
        parent::__construct();
        $this->usuarioModel = new Usuario();
    }
    
    /**
     * Página de perfil del usuario
     */
    public function index() {
        $this->requireAuth();
        
        $userId = $_SESSION['user_id'];
        $usuario = $this->usuarioModel->getById($userId);
        
        if (!$usuario) {
            setFlash('danger', 'Usuario no encontrado');
            redirect('dashboard');
        }
        
        $this->view('perfil/index', ['usuario' => $usuario]);
    }
    
    /**
     * Actualizar perfil del usuario
     */
    public function update() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('perfil');
        }
        
        $userId = $_SESSION['user_id'];
        $usuario = $this->usuarioModel->getById($userId);
        
        if (!$usuario) {
            setFlash('danger', 'Usuario no encontrado');
            redirect('dashboard');
        }
        
        $data = [
            'nombre' => cleanInput($_POST['nombre']),
            'email' => cleanInput($_POST['email']),
            'password' => !empty($_POST['password']) ? $_POST['password'] : null
        ];
        
        // Verificar si el email ya existe (excepto el del usuario actual)
        $existingUser = $this->usuarioModel->findByEmail($data['email']);
        if ($existingUser && $existingUser['id'] != $userId) {
            setFlash('danger', 'El email ya está en uso por otro usuario');
            redirect('perfil');
        }
        
        if ($this->usuarioModel->updateProfile($userId, $data)) {
            // Actualizar sesión con el nuevo nombre
            $_SESSION['user_name'] = $data['nombre'];
            
            logActivity('Actualizó su perfil', 'perfil');
            setFlash('success', 'Perfil actualizado exitosamente');
        } else {
            setFlash('danger', 'Error al actualizar el perfil');
        }
        
        redirect('perfil');
    }
}
?>
