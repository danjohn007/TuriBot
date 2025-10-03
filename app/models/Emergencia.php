<?php
require_once APP_PATH . '/models/BaseModel.php';

class Emergencia extends BaseModel {
    protected $table = 'emergencias';
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (nombre, numero, descripcion, tipo, activo, creado_por) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['nombre'], $data['numero'], $data['descripcion'],
            $data['tipo'], $data['activo'] ?? 1, $_SESSION['user_id']
        ]);
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET nombre = ?, numero = ?, descripcion = ?, tipo = ?, activo = ?
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['nombre'], $data['numero'], $data['descripcion'],
            $data['tipo'], $data['activo'], $id
        ]);
    }
    
    public function hasActiveEmergency() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE activo = 1");
        $result = $stmt->fetch();
        return $result['total'] > 0;
    }
    
    public function canDelete($id) {
        // Verificar que no sea el último contacto activo
        $item = $this->getById($id);
        if ($item && $item['activo'] == 1) {
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table} WHERE activo = 1");
            $result = $stmt->fetch();
            return $result['total'] > 1;
        }
        return true;
    }
}
?>
