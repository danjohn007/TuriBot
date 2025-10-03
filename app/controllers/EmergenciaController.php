<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Emergencia.php';

class EmergenciaController extends BaseController {
    private $emergenciaModel;
    
    public function __construct() {
        parent::__construct();
        $this->emergenciaModel = new Emergencia();
    }
    
    public function index() {
        $this->requireAnyRole(['admin', 'editor', 'consultor']);
        $emergencias = $this->emergenciaModel->getAll();
        $this->view('emergencia/index', ['emergencias' => $emergencias]);
    }
    
    public function create() {
        $this->requireAnyRole(['admin', 'editor']);
        $this->view('emergencia/form', ['emergencia' => null]);
    }
    
    public function store() {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('emergencia/create');
        }
        
        $data = [
            'nombre' => cleanInput($_POST['nombre']),
            'numero' => cleanInput($_POST['numero']),
            'descripcion' => cleanInput($_POST['descripcion'] ?? ''),
            'tipo' => cleanInput($_POST['tipo']),
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];
        
        if ($this->emergenciaModel->create($data)) {
            logActivity('Creó contacto de emergencia: ' . $data['nombre'], 'emergencia');
            setFlash('success', 'Contacto de emergencia creado exitosamente');
            redirect('emergencia');
        } else {
            setFlash('danger', 'Error al crear el contacto');
            redirect('emergencia/create');
        }
    }
    
    public function edit($id) {
        $this->requireAnyRole(['admin', 'editor']);
        $emergencia = $this->emergenciaModel->getById($id);
        if (!$emergencia) {
            setFlash('danger', 'Contacto no encontrado');
            redirect('emergencia');
        }
        $this->view('emergencia/form', ['emergencia' => $emergencia]);
    }
    
    public function update($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('emergencia/edit/' . $id);
        }
        
        $data = [
            'nombre' => cleanInput($_POST['nombre']),
            'numero' => cleanInput($_POST['numero']),
            'descripcion' => cleanInput($_POST['descripcion'] ?? ''),
            'tipo' => cleanInput($_POST['tipo']),
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];
        
        if ($this->emergenciaModel->update($id, $data)) {
            logActivity('Actualizó contacto de emergencia: ' . $data['nombre'], 'emergencia');
            setFlash('success', 'Contacto actualizado exitosamente');
            redirect('emergencia');
        } else {
            setFlash('danger', 'Error al actualizar el contacto');
            redirect('emergencia/edit/' . $id);
        }
    }
    
    public function delete($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        if (!$this->emergenciaModel->canDelete($id)) {
            setFlash('danger', 'No se puede eliminar el último contacto de emergencia activo');
            redirect('emergencia');
        }
        
        $emergencia = $this->emergenciaModel->getById($id);
        if ($emergencia) {
            if ($this->emergenciaModel->delete($id)) {
                logActivity('Eliminó contacto de emergencia: ' . $emergencia['nombre'], 'emergencia');
                setFlash('success', 'Contacto eliminado exitosamente');
            }
        }
        redirect('emergencia');
    }
}
?>
