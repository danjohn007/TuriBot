<?php
require_once APP_PATH . '/models/BaseModel.php';

/**
 * Modelo Usuario
 */
class Usuario extends BaseModel {
    protected $table = 'usuarios';
    
    /**
     * Busca usuario por email
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    /**
     * Crea un nuevo usuario
     */
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (nombre, email, password, rol, activo) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['nombre'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['rol'],
            $data['activo'] ?? 1
        ]);
    }
    
    /**
     * Actualiza usuario
     */
    public function update($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $stmt = $this->db->prepare("
                UPDATE {$this->table} 
                SET nombre = ?, email = ?, password = ?, rol = ?, activo = ? 
                WHERE id = ?
            ");
            return $stmt->execute([
                $data['nombre'],
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['rol'],
                $data['activo'],
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE {$this->table} 
                SET nombre = ?, email = ?, rol = ?, activo = ? 
                WHERE id = ?
            ");
            return $stmt->execute([
                $data['nombre'],
                $data['email'],
                $data['rol'],
                $data['activo'],
                $id
            ]);
        }
    }
    
    /**
     * Verifica credenciales
     */
    public function verify($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && $user['activo'] == 1 && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Genera token de recuperación
     */
    public function generateRecoveryToken($email) {
        $token = bin2hex(random_bytes(32));
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET token_recuperacion = ?, token_expiracion = ? 
            WHERE email = ?
        ");
        
        if ($stmt->execute([$token, $expiration, $email])) {
            return $token;
        }
        
        return false;
    }
    
    /**
     * Valida token de recuperación
     */
    public function validateRecoveryToken($token) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE token_recuperacion = ? 
            AND token_expiracion > NOW()
        ");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }
    
    /**
     * Resetea contraseña
     */
    public function resetPassword($token, $newPassword) {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET password = ?, token_recuperacion = NULL, token_expiracion = NULL 
            WHERE token_recuperacion = ?
        ");
        
        return $stmt->execute([
            password_hash($newPassword, PASSWORD_DEFAULT),
            $token
        ]);
    }
    
    /**
     * Obtiene usuarios por rol
     */
    public function getByRole($rol) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE rol = ? ORDER BY nombre");
        $stmt->execute([$rol]);
        return $stmt->fetchAll();
    }
}
?>
