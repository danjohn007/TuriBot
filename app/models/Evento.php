<?php
require_once APP_PATH . '/models/BaseModel.php';

class Evento extends BaseModel {
    protected $table = 'eventos';
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (nombre, descripcion, fecha_inicio, fecha_fin, ubicacion, 
             enlace_boletos, imagen, activo, creado_por) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['nombre'], $data['descripcion'], $data['fecha_inicio'],
            $data['fecha_fin'], $data['ubicacion'], $data['enlace_boletos'],
            $data['imagen'], $data['activo'] ?? 1, $_SESSION['user_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET nombre = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ?,
                ubicacion = ?, enlace_boletos = ?, imagen = ?, activo = ?
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['nombre'], $data['descripcion'], $data['fecha_inicio'],
            $data['fecha_fin'], $data['ubicacion'], $data['enlace_boletos'],
            $data['imagen'], $data['activo'], $id
        ]);
    }
    
    public function getUpcoming() {
        $stmt = $this->db->query("
            SELECT * FROM {$this->table} 
            WHERE fecha_fin >= CURDATE() AND activo = 1 
            ORDER BY fecha_inicio
        ");
        return $stmt->fetchAll();
    }
}
?>
