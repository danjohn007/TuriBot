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
        $stmt = $this->db->prepare("
            UPDATE {$this->table} SET valor = ? WHERE clave = ?
        ");
        return $stmt->execute([$valor, $clave]);
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
