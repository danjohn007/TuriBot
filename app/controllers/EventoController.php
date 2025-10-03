<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Evento.php';

class EventoController extends BaseController {
    private $eventoModel;
    
    public function __construct() {
        parent::__construct();
        $this->eventoModel = new Evento();
    }
    
    public function index() {
        $this->requireAnyRole(['admin', 'editor', 'consultor']);
        $eventos = $this->eventoModel->getAll();
        $this->view('evento/index', ['eventos' => $eventos]);
    }
    
    public function create() {
        $this->requireAnyRole(['admin', 'editor']);
        $this->view('evento/form', ['evento' => null]);
    }
    
    public function store() {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('evento/create');
        }
        
        try {
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = uploadImage($_FILES['imagen'], 'eventos');
            }
            
            $data = [
                'nombre' => cleanInput($_POST['nombre']),
                'descripcion' => cleanInput($_POST['descripcion']),
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin'],
                'ubicacion' => cleanInput($_POST['ubicacion']),
                'enlace_boletos' => cleanInput($_POST['enlace_boletos'] ?? ''),
                'imagen' => $imagen,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if ($this->eventoModel->create($data)) {
                logActivity('Creó evento: ' . $data['nombre'], 'evento');
                setFlash('success', 'Evento creado exitosamente');
                redirect('evento');
            }
        } catch (Exception $e) {
            setFlash('danger', $e->getMessage());
            redirect('evento/create');
        }
    }
    
    public function edit($id) {
        $this->requireAnyRole(['admin', 'editor']);
        $evento = $this->eventoModel->getById($id);
        if (!$evento) {
            setFlash('danger', 'Evento no encontrado');
            redirect('evento');
        }
        $this->view('evento/form', ['evento' => $evento]);
    }
    
    public function update($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('evento/edit/' . $id);
        }
        
        try {
            $evento = $this->eventoModel->getById($id);
            if (!$evento) {
                setFlash('danger', 'Evento no encontrado');
                redirect('evento');
            }
            
            $imagen = $evento['imagen'];
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                if (!empty($evento['imagen'])) {
                    deleteImage($evento['imagen'], 'eventos');
                }
                $imagen = uploadImage($_FILES['imagen'], 'eventos');
            }
            
            $data = [
                'nombre' => cleanInput($_POST['nombre']),
                'descripcion' => cleanInput($_POST['descripcion']),
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin'],
                'ubicacion' => cleanInput($_POST['ubicacion']),
                'enlace_boletos' => cleanInput($_POST['enlace_boletos'] ?? ''),
                'imagen' => $imagen,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if ($this->eventoModel->update($id, $data)) {
                logActivity('Actualizó evento: ' . $data['nombre'], 'evento');
                setFlash('success', 'Evento actualizado exitosamente');
                redirect('evento');
            }
        } catch (Exception $e) {
            setFlash('danger', $e->getMessage());
            redirect('evento/edit/' . $id);
        }
    }
    
    public function delete($id) {
        $this->requireAnyRole(['admin', 'editor']);
        $evento = $this->eventoModel->getById($id);
        if ($evento) {
            if (!empty($evento['imagen'])) {
                deleteImage($evento['imagen'], 'eventos');
            }
            if ($this->eventoModel->delete($id)) {
                logActivity('Eliminó evento: ' . $evento['nombre'], 'evento');
                setFlash('success', 'Evento eliminado exitosamente');
            }
        }
        redirect('evento');
    }
}
?>
