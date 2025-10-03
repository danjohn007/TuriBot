<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Atraccion.php';

class AtraccionController extends BaseController {
    private $atraccionModel;
    
    public function __construct() {
        parent::__construct();
        $this->atraccionModel = new Atraccion();
    }
    
    public function index() {
        $this->requireAnyRole(['admin', 'editor', 'consultor']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filters = [
                'nombre' => cleanInput($_POST['nombre'] ?? ''),
                'categoria' => cleanInput($_POST['categoria'] ?? '')
            ];
            $atracciones = $this->atraccionModel->search($filters);
        } else {
            $atracciones = $this->atraccionModel->getAll();
        }
        
        $this->view('atraccion/index', ['atracciones' => $atracciones]);
    }
    
    public function create() {
        $this->requireAnyRole(['admin', 'editor']);
        $this->view('atraccion/form', ['atraccion' => null]);
    }
    
    public function store() {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('atraccion/create');
        }
        
        try {
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = uploadImage($_FILES['imagen'], 'atracciones');
            }
            
            $data = [
                'nombre' => cleanInput($_POST['nombre']),
                'descripcion' => cleanInput($_POST['descripcion']),
                'categoria' => cleanInput($_POST['categoria']),
                'direccion' => cleanInput($_POST['direccion']),
                'horario_apertura' => $_POST['horario_apertura'] ?? null,
                'horario_cierre' => $_POST['horario_cierre'] ?? null,
                'costo_acceso' => !empty($_POST['costo_acceso']) ? (float)$_POST['costo_acceso'] : 0.00,
                'enlace_externo' => cleanInput($_POST['enlace_externo'] ?? ''),
                'contacto' => cleanInput($_POST['contacto'] ?? ''),
                'imagen' => $imagen,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if ($this->atraccionModel->create($data)) {
                logActivity('Creó atracción: ' . $data['nombre'], 'atraccion');
                setFlash('success', 'Atracción creada exitosamente');
                redirect('atraccion');
            }
        } catch (Exception $e) {
            setFlash('danger', $e->getMessage());
            redirect('atraccion/create');
        }
    }
    
    public function edit($id) {
        $this->requireAnyRole(['admin', 'editor']);
        $atraccion = $this->atraccionModel->getById($id);
        if (!$atraccion) {
            setFlash('danger', 'Atracción no encontrada');
            redirect('atraccion');
        }
        $this->view('atraccion/form', ['atraccion' => $atraccion]);
    }
    
    public function update($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('atraccion/edit/' . $id);
        }
        
        try {
            $atraccion = $this->atraccionModel->getById($id);
            if (!$atraccion) {
                setFlash('danger', 'Atracción no encontrada');
                redirect('atraccion');
            }
            
            $imagen = $atraccion['imagen'];
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                if (!empty($atraccion['imagen'])) {
                    deleteImage($atraccion['imagen'], 'atracciones');
                }
                $imagen = uploadImage($_FILES['imagen'], 'atracciones');
            }
            
            $data = [
                'nombre' => cleanInput($_POST['nombre']),
                'descripcion' => cleanInput($_POST['descripcion']),
                'categoria' => cleanInput($_POST['categoria']),
                'direccion' => cleanInput($_POST['direccion']),
                'horario_apertura' => $_POST['horario_apertura'] ?? null,
                'horario_cierre' => $_POST['horario_cierre'] ?? null,
                'costo_acceso' => !empty($_POST['costo_acceso']) ? (float)$_POST['costo_acceso'] : 0.00,
                'enlace_externo' => cleanInput($_POST['enlace_externo'] ?? ''),
                'contacto' => cleanInput($_POST['contacto'] ?? ''),
                'imagen' => $imagen,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if ($this->atraccionModel->update($id, $data)) {
                logActivity('Actualizó atracción: ' . $data['nombre'], 'atraccion');
                setFlash('success', 'Atracción actualizada exitosamente');
                redirect('atraccion');
            }
        } catch (Exception $e) {
            setFlash('danger', $e->getMessage());
            redirect('atraccion/edit/' . $id);
        }
    }
    
    public function delete($id) {
        $this->requireAnyRole(['admin', 'editor']);
        $atraccion = $this->atraccionModel->getById($id);
        if ($atraccion) {
            if (!empty($atraccion['imagen'])) {
                deleteImage($atraccion['imagen'], 'atracciones');
            }
            if ($this->atraccionModel->delete($id)) {
                logActivity('Eliminó atracción: ' . $atraccion['nombre'], 'atraccion');
                setFlash('success', 'Atracción eliminada exitosamente');
            }
        }
        redirect('atraccion');
    }
}
?>
