<?php
require_once APP_PATH . '/models/BaseModel.php';

class Atraccion extends BaseModel {
    protected $table = 'atracciones';
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (nombre, descripcion, categoria, direccion, horario_apertura, horario_cierre,
             costo_acceso, enlace_externo, contacto, imagen, activo, creado_por) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['nombre'], $data['descripcion'], $data['categoria'],
            $data['direccion'], $data['horario_apertura'], $data['horario_cierre'],
            $data['costo_acceso'], $data['enlace_externo'], $data['contacto'],
            $data['imagen'], $data['activo'] ?? 1, $_SESSION['user_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET nombre = ?, descripcion = ?, categoria = ?, direccion = ?,
                horario_apertura = ?, horario_cierre = ?, costo_acceso = ?,
                enlace_externo = ?, contacto = ?, imagen = ?, activo = ?
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['nombre'], $data['descripcion'], $data['categoria'],
            $data['direccion'], $data['horario_apertura'], $data['horario_cierre'],
            $data['costo_acceso'], $data['enlace_externo'], $data['contacto'],
            $data['imagen'], $data['activo'], $id
        ]);
    }
    
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
        
        $sql .= " ORDER BY nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
