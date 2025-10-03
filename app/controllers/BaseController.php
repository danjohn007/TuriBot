<?php
/**
 * Controlador Base
 * Todos los controladores heredan de esta clase
 */
class BaseController {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Carga una vista
     */
    protected function view($viewPath, $data = []) {
        extract($data);
        
        // Cargar layout principal
        require_once APP_PATH . '/views/layouts/header.php';
        require_once APP_PATH . '/views/' . $viewPath . '.php';
        require_once APP_PATH . '/views/layouts/footer.php';
    }
    
    /**
     * Carga una vista sin layout (para login, etc)
     */
    protected function viewWithoutLayout($viewPath, $data = []) {
        extract($data);
        require_once APP_PATH . '/views/' . $viewPath . '.php';
    }
    
    /**
     * Retorna JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    /**
     * Verifica autenticación
     */
    protected function requireAuth() {
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
    }
    
    /**
     * Verifica rol específico
     */
    protected function requireRole($role) {
        $this->requireAuth();
        if (!hasRole($role)) {
            setFlash('danger', 'No tiene permisos para acceder a esta sección');
            redirect('dashboard');
        }
    }
    
    /**
     * Verifica uno de varios roles
     */
    protected function requireAnyRole($roles) {
        $this->requireAuth();
        if (!hasAnyRole($roles)) {
            setFlash('danger', 'No tiene permisos para acceder a esta sección');
            redirect('dashboard');
        }
    }
}
?>
