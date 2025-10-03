<?php
require_once APP_PATH . '/models/BaseModel.php';

class Restaurante extends BaseModel {
    protected $table = 'restaurantes';
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (nombre, tipo_comida, direccion, telefono, whatsapp, enlace_reservacion, 
             sitio_web, imagen, activo, creado_por) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['nombre'], $data['tipo_comida'], $data['direccion'],
            $data['telefono'], $data['whatsapp'], $data['enlace_reservacion'],
            $data['sitio_web'], $data['imagen'], $data['activo'] ?? 1,
            $_SESSION['user_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET nombre = ?, tipo_comida = ?, direccion = ?, telefono = ?, 
                whatsapp = ?, enlace_reservacion = ?, sitio_web = ?, 
                imagen = ?, activo = ? 
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['nombre'], $data['tipo_comida'], $data['direccion'],
            $data['telefono'], $data['whatsapp'], $data['enlace_reservacion'],
            $data['sitio_web'], $data['imagen'], $data['activo'], $id
        ]);
    }
    
    public function search($filters = []) {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];
        
        if (!empty($filters['nombre'])) {
            $sql .= " AND nombre LIKE ?";
            $params[] = "%{$filters['nombre']}%";
        }
        
        if (!empty($filters['tipo_comida'])) {
            $sql .= " AND tipo_comida LIKE ?";
            $params[] = "%{$filters['tipo_comida']}%";
        }
        
        $sql .= " ORDER BY nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
