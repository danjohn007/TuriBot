<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Restaurante.php';

class RestauranteController extends BaseController {
    private $restauranteModel;
    
    public function __construct() {
        parent::__construct();
        $this->restauranteModel = new Restaurante();
    }
    
    public function index() {
        $this->requireAnyRole(['admin', 'editor', 'consultor']);
        
        $filters = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filters = [
                'nombre' => cleanInput($_POST['nombre'] ?? ''),
                'tipo_comida' => cleanInput($_POST['tipo_comida'] ?? '')
            ];
            $restaurantes = $this->restauranteModel->search($filters);
        } else {
            $restaurantes = $this->restauranteModel->getAll();
        }
        
        $this->view('restaurante/index', ['restaurantes' => $restaurantes]);
    }
    
    public function create() {
        $this->requireAnyRole(['admin', 'editor']);
        $this->view('restaurante/form', ['restaurante' => null]);
    }
    
    public function store() {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('restaurante/create');
        }
        
        try {
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = uploadImage($_FILES['imagen'], 'restaurantes');
            }
            
            $data = [
                'nombre' => cleanInput($_POST['nombre']),
                'tipo_comida' => cleanInput($_POST['tipo_comida']),
                'direccion' => cleanInput($_POST['direccion']),
                'telefono' => cleanInput($_POST['telefono'] ?? ''),
                'whatsapp' => cleanInput($_POST['whatsapp'] ?? ''),
                'enlace_reservacion' => cleanInput($_POST['enlace_reservacion'] ?? ''),
                'sitio_web' => cleanInput($_POST['sitio_web'] ?? ''),
                'imagen' => $imagen,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if ($this->restauranteModel->create($data)) {
                logActivity('Creó restaurante: ' . $data['nombre'], 'restaurante');
                setFlash('success', 'Restaurante creado exitosamente');
                redirect('restaurante');
            }
        } catch (Exception $e) {
            setFlash('danger', $e->getMessage());
            redirect('restaurante/create');
        }
    }
    
    public function edit($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        $restaurante = $this->restauranteModel->getById($id);
        if (!$restaurante) {
            setFlash('danger', 'Restaurante no encontrado');
            redirect('restaurante');
        }
        
        $this->view('restaurante/form', ['restaurante' => $restaurante]);
    }
    
    public function update($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('restaurante/edit/' . $id);
        }
        
        try {
            $restaurante = $this->restauranteModel->getById($id);
            if (!$restaurante) {
                setFlash('danger', 'Restaurante no encontrado');
                redirect('restaurante');
            }
            
            $imagen = $restaurante['imagen'];
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                if (!empty($restaurante['imagen'])) {
                    deleteImage($restaurante['imagen'], 'restaurantes');
                }
                $imagen = uploadImage($_FILES['imagen'], 'restaurantes');
            }
            
            $data = [
                'nombre' => cleanInput($_POST['nombre']),
                'tipo_comida' => cleanInput($_POST['tipo_comida']),
                'direccion' => cleanInput($_POST['direccion']),
                'telefono' => cleanInput($_POST['telefono'] ?? ''),
                'whatsapp' => cleanInput($_POST['whatsapp'] ?? ''),
                'enlace_reservacion' => cleanInput($_POST['enlace_reservacion'] ?? ''),
                'sitio_web' => cleanInput($_POST['sitio_web'] ?? ''),
                'imagen' => $imagen,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if ($this->restauranteModel->update($id, $data)) {
                logActivity('Actualizó restaurante: ' . $data['nombre'], 'restaurante');
                setFlash('success', 'Restaurante actualizado exitosamente');
                redirect('restaurante');
            }
        } catch (Exception $e) {
            setFlash('danger', $e->getMessage());
            redirect('restaurante/edit/' . $id);
        }
    }
    
    public function delete($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        $restaurante = $this->restauranteModel->getById($id);
        if ($restaurante) {
            if (!empty($restaurante['imagen'])) {
                deleteImage($restaurante['imagen'], 'restaurantes');
            }
            
            if ($this->restauranteModel->delete($id)) {
                logActivity('Eliminó restaurante: ' . $restaurante['nombre'], 'restaurante');
                setFlash('success', 'Restaurante eliminado exitosamente');
            }
        }
        
        redirect('restaurante');
    }
}
?>
