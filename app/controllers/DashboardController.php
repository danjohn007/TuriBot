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
        
        // Obtener actividad por módulo para gráfica de pie
        $stmt = $this->db->prepare("
            SELECT modulo, COUNT(*) as total 
            FROM log_actividades 
            GROUP BY modulo 
            ORDER BY total DESC
        ");
        $stmt->execute();
        $activityByModule = $stmt->fetchAll();
        
        // Obtener registros por mes (últimos 6 meses)
        $monthlyStats = $this->getMonthlyRegistrations();
        
        $this->view('dashboard/index', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
            'activityByModule' => $activityByModule,
            'monthlyStats' => $monthlyStats
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
    
    /**
     * Obtiene registros mensuales de los últimos 6 meses
     */
    private function getMonthlyRegistrations() {
        $tables = ['hospedajes', 'restaurantes', 'atracciones', 'eventos'];
        $result = [];
        
        // Obtener últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-$i months"));
            $result['labels'][] = date('M Y', strtotime("-$i months"));
            
            foreach ($tables as $table) {
                $stmt = $this->db->prepare("
                    SELECT COUNT(*) as total 
                    FROM {$table} 
                    WHERE DATE_FORMAT(fecha_creacion, '%Y-%m') = ?
                ");
                $stmt->execute([$date]);
                $row = $stmt->fetch();
                $result['data'][$table][] = (int)$row['total'];
            }
        }
        
        return $result;
    }
}
?>
