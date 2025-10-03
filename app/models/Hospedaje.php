<?php
require_once APP_PATH . '/models/BaseModel.php';

/**
 * Modelo Hospedaje
 */
class Hospedaje extends BaseModel {
    protected $table = 'hospedajes';
    
    /**
     * Obtiene todos los hospedajes activos
     */
    public function getAllActive() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} WHERE activo = 1 ORDER BY nombre");
        return $stmt->fetchAll();
    }
    
    /**
     * Crea un nuevo hospedaje
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (nombre, categoria, direccion, telefono, enlace_reservacion, sitio_web, imagen, 
             rango_precio_min, rango_precio_max, activo, creado_por) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['nombre'],
            $data['categoria'],
            $data['direccion'],
            $data['telefono'],
            $data['enlace_reservacion'],
            $data['sitio_web'],
            $data['imagen'],
            $data['rango_precio_min'],
            $data['rango_precio_max'],
            $data['activo'] ?? 1,
            $_SESSION['user_id']
        ]);
    }
    
    /**
     * Actualiza hospedaje
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET nombre = ?, categoria = ?, direccion = ?, telefono = ?, 
                enlace_reservacion = ?, sitio_web = ?, imagen = ?, 
                rango_precio_min = ?, rango_precio_max = ?, activo = ? 
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['nombre'],
            $data['categoria'],
            $data['direccion'],
            $data['telefono'],
            $data['enlace_reservacion'],
            $data['sitio_web'],
            $data['imagen'],
            $data['rango_precio_min'],
            $data['rango_precio_max'],
            $data['activo'],
            $id
        ]);
    }
    
    /**
     * Busca hospedajes por filtros
     */
    public function search($filters = []) {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        if (!empty($filters['nombre'])) {
            $sql .= " AND nombre LIKE ?";
            $params[] = "%{$filters['nombre']}%";
        }
        
        if (!empty($filters['categoria'])) {
            $sql .= " AND categoria = ?";
            $params[] = $filters['categoria'];
        }
        
        if (!empty($filters['precio_min'])) {
            $sql .= " AND rango_precio_max >= ?";
            $params[] = $filters['precio_min'];
        }
        
        if (!empty($filters['precio_max'])) {
            $sql .= " AND rango_precio_min <= ?";
            $params[] = $filters['precio_max'];
        }
        
        $sql .= " ORDER BY nombre";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
