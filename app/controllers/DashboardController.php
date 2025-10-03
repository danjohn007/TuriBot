<?php
require_once APP_PATH . '/controllers/BaseController.php';

/**
 * Controlador del Dashboard
 */
class DashboardController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Página principal del dashboard
     */
    public function index() {
        $this->requireAuth();
        
        // Obtener estadísticas
        $stats = [
            'hospedajes' => $this->getCount('hospedajes'),
            'restaurantes' => $this->getCount('restaurantes'),
            'atracciones' => $this->getCount('atracciones'),
            'eventos' => $this->getCount('eventos'),
            'usuarios' => $this->getCount('usuarios'),
            'emergencias' => $this->getCount('emergencias')
        ];
        
        // Obtener actividad reciente
        $stmt = $this->db->prepare("
            SELECT l.*, u.nombre as usuario_nombre 
            FROM log_actividades l 
            JOIN usuarios u ON l.usuario_id = u.id 
            ORDER BY l.fecha_creacion DESC 
            LIMIT 10
        ");
        $stmt->execute();
        $recentActivity = $stmt->fetchAll();
        
        $this->view('dashboard/index', [
            'stats' => $stats,
            'recentActivity' => $recentActivity
        ]);
    }
    
    /**
     * Obtiene el conteo de registros de una tabla
     */
    private function getCount($table) {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$table}");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
?>
