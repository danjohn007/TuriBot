<?php
require_once APP_PATH . '/models/BaseModel.php';

class Configuracion extends BaseModel {
    protected $table = 'configuracion';
    
    public function getByClave($clave) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE clave = ?");
        $stmt->execute([$clave]);
        return $stmt->fetch();
    }
    
    public function update($clave, $valor) {
        // Usar INSERT ... ON DUPLICATE KEY UPDATE para evitar errores de duplicados
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (clave, valor, descripcion) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE valor = VALUES(valor)
        ");
        return $stmt->execute([$clave, $valor, 'Configuración agregada automáticamente']);
    }
    
    public function getAllAsArray() {
        $stmt = $this->db->query("SELECT clave, valor FROM {$this->table}");
        $results = $stmt->fetchAll();
        $config = [];
        foreach ($results as $row) {
            $config[$row['clave']] = $row['valor'];
        }
        return $config;
    }
}
?>
