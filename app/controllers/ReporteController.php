<?php
require_once APP_PATH . '/controllers/BaseController.php';

class ReporteController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->requireRole('admin');
        
        // Obtener estadísticas por mes
        $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
        
        $stats = [
            'hospedajes' => $this->getMonthlyStats('hospedajes', $year),
            'restaurantes' => $this->getMonthlyStats('restaurantes', $year),
            'atracciones' => $this->getMonthlyStats('atracciones', $year),
            'eventos' => $this->getMonthlyStats('eventos', $year)
        ];
        
        // Obtener totales generales
        $totals = [
            'hospedajes' => $this->getTotal('hospedajes'),
            'restaurantes' => $this->getTotal('restaurantes'),
            'atracciones' => $this->getTotal('atracciones'),
            'eventos' => $this->getTotal('eventos'),
            'emergencias' => $this->getTotal('emergencias'),
            'usuarios' => $this->getTotal('usuarios')
        ];
        
        $this->view('reporte/index', [
            'stats' => $stats,
            'totals' => $totals,
            'year' => $year
        ]);
    }
    
    private function getMonthlyStats($table, $year) {
        $stmt = $this->db->prepare("
            SELECT MONTH(fecha_creacion) as mes, COUNT(*) as total 
            FROM {$table} 
            WHERE YEAR(fecha_creacion) = ? 
            GROUP BY MONTH(fecha_creacion)
        ");
        $stmt->execute([$year]);
        $results = $stmt->fetchAll();
        
        // Crear array con todos los meses
        $monthly = array_fill(1, 12, 0);
        foreach ($results as $row) {
            $monthly[(int)$row['mes']] = (int)$row['total'];
        }
        
        return array_values($monthly);
    }
    
    private function getTotal($table) {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$table}");
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    public function export() {
        $this->requireRole('admin');
        
        $tipo = $_GET['tipo'] ?? 'general';
        
        // Headers para descarga CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=reporte_' . $tipo . '_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        switch ($tipo) {
            case 'hospedajes':
                fputcsv($output, ['ID', 'Nombre', 'Categoría', 'Dirección', 'Teléfono', 'Precio Min', 'Precio Max', 'Activo', 'Fecha Creación']);
                $stmt = $this->db->query("SELECT * FROM hospedajes ORDER BY fecha_creacion DESC");
                while ($row = $stmt->fetch()) {
                    fputcsv($output, [
                        $row['id'], $row['nombre'], $row['categoria'], $row['direccion'],
                        $row['telefono'], $row['rango_precio_min'], $row['rango_precio_max'],
                        $row['activo'] ? 'Sí' : 'No', $row['fecha_creacion']
                    ]);
                }
                break;
                
            case 'restaurantes':
                fputcsv($output, ['ID', 'Nombre', 'Tipo Comida', 'Dirección', 'Teléfono', 'WhatsApp', 'Activo', 'Fecha Creación']);
                $stmt = $this->db->query("SELECT * FROM restaurantes ORDER BY fecha_creacion DESC");
                while ($row = $stmt->fetch()) {
                    fputcsv($output, [
                        $row['id'], $row['nombre'], $row['tipo_comida'], $row['direccion'],
                        $row['telefono'], $row['whatsapp'], $row['activo'] ? 'Sí' : 'No',
                        $row['fecha_creacion']
                    ]);
                }
                break;
                
            case 'atracciones':
                fputcsv($output, ['ID', 'Nombre', 'Categoría', 'Dirección', 'Costo', 'Activo', 'Fecha Creación']);
                $stmt = $this->db->query("SELECT * FROM atracciones ORDER BY fecha_creacion DESC");
                while ($row = $stmt->fetch()) {
                    fputcsv($output, [
                        $row['id'], $row['nombre'], $row['categoria'], $row['direccion'],
                        $row['costo_acceso'], $row['activo'] ? 'Sí' : 'No',
                        $row['fecha_creacion']
                    ]);
                }
                break;
                
            case 'eventos':
                fputcsv($output, ['ID', 'Nombre', 'Fecha Inicio', 'Fecha Fin', 'Ubicación', 'Activo', 'Fecha Creación']);
                $stmt = $this->db->query("SELECT * FROM eventos ORDER BY fecha_inicio DESC");
                while ($row = $stmt->fetch()) {
                    fputcsv($output, [
                        $row['id'], $row['nombre'], $row['fecha_inicio'], $row['fecha_fin'],
                        $row['ubicacion'], $row['activo'] ? 'Sí' : 'No',
                        $row['fecha_creacion']
                    ]);
                }
                break;
        }
        
        fclose($output);
        exit();
    }
}
?>
