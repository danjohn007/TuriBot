<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Usuario.php';

class UsuarioController extends BaseController {
    private $usuarioModel;
    
    public function __construct() {
        parent::__construct();
        $this->usuarioModel = new Usuario();
    }
    
    public function index() {
        $this->requireRole('admin');
        $usuarios = $this->usuarioModel->getAll();
        $this->view('usuario/index', ['usuarios' => $usuarios]);
    }
    
    public function create() {
        $this->requireRole('admin');
        $this->view('usuario/form', ['usuario' => null]);
    }
    
    public function store() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('usuario/create');
        }
        
        $email = cleanInput($_POST['email']);
        if ($this->usuarioModel->findByEmail($email)) {
            setFlash('danger', 'El email ya está registrado');
            redirect('usuario/create');
        }
        
        $data = [
            'nombre' => cleanInput($_POST['nombre']),
            'email' => $email,
            'password' => $_POST['password'],
            'rol' => cleanInput($_POST['rol']),
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];
        
        if ($this->usuarioModel->create($data)) {
            logActivity('Creó usuario: ' . $data['nombre'], 'usuario');
            setFlash('success', 'Usuario creado exitosamente');
            redirect('usuario');
        } else {
            setFlash('danger', 'Error al crear el usuario');
            redirect('usuario/create');
        }
    }
    
    public function edit($id) {
        $this->requireRole('admin');
        $usuario = $this->usuarioModel->getById($id);
        if (!$usuario) {
            setFlash('danger', 'Usuario no encontrado');
            redirect('usuario');
        }
        $this->view('usuario/form', ['usuario' => $usuario]);
    }
    
    public function update($id) {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('usuario/edit/' . $id);
        }
        
        $usuario = $this->usuarioModel->getById($id);
        if (!$usuario) {
            setFlash('danger', 'Usuario no encontrado');
            redirect('usuario');
        }
        
        $data = [
            'nombre' => cleanInput($_POST['nombre']),
            'email' => cleanInput($_POST['email']),
            'password' => $_POST['password'],
            'rol' => cleanInput($_POST['rol']),
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];
        
        if ($this->usuarioModel->update($id, $data)) {
            logActivity('Actualizó usuario: ' . $data['nombre'], 'usuario');
            setFlash('success', 'Usuario actualizado exitosamente');
            redirect('usuario');
        } else {
            setFlash('danger', 'Error al actualizar el usuario');
            redirect('usuario/edit/' . $id);
        }
    }
    
    public function delete($id) {
        $this->requireRole('admin');
        
        // No permitir eliminar el propio usuario
        if ($id == $_SESSION['user_id']) {
            setFlash('danger', 'No puede eliminar su propio usuario');
            redirect('usuario');
        }
        
        $usuario = $this->usuarioModel->getById($id);
        if ($usuario) {
            if ($this->usuarioModel->delete($id)) {
                logActivity('Eliminó usuario: ' . $usuario['nombre'], 'usuario');
                setFlash('success', 'Usuario eliminado exitosamente');
            }
        }
        redirect('usuario');
    }
}
?>
