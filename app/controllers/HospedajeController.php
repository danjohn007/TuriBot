<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Hospedaje.php';

/**
 * Controlador de Hospedajes
 */
class HospedajeController extends BaseController {
    private $hospedajeModel;
    
    public function __construct() {
        parent::__construct();
        $this->hospedajeModel = new Hospedaje();
    }
    
    /**
     * Lista todos los hospedajes
     */
    public function index() {
        $this->requireAnyRole(['admin', 'editor', 'consultor']);
        
        $filters = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filters = [
                'nombre' => cleanInput($_POST['nombre'] ?? ''),
                'categoria' => cleanInput($_POST['categoria'] ?? ''),
                'precio_min' => cleanInput($_POST['precio_min'] ?? ''),
                'precio_max' => cleanInput($_POST['precio_max'] ?? '')
            ];
            $hospedajes = $this->hospedajeModel->search($filters);
        } else {
            $hospedajes = $this->hospedajeModel->getAll();
        }
        
        $this->view('hospedaje/index', ['hospedajes' => $hospedajes]);
    }
    
    /**
     * Muestra formulario de creación
     */
    public function create() {
        $this->requireAnyRole(['admin', 'editor']);
        $this->view('hospedaje/form', ['hospedaje' => null]);
    }
    
    /**
     * Guarda nuevo hospedaje
     */
    public function store() {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('hospedaje/create');
        }
        
        try {
            // Validar campos requeridos
            $errors = [];
            if (empty($_POST['nombre'])) $errors[] = 'El nombre es requerido';
            if (empty($_POST['categoria'])) $errors[] = 'La categoría es requerida';
            if (empty($_POST['direccion'])) $errors[] = 'La dirección es requerida';
            
            if (!empty($errors)) {
                setFlash('danger', implode('<br>', $errors));
                redirect('hospedaje/create');
            }
            
            // Subir imagen si existe
            $imagen = null;
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = uploadImage($_FILES['imagen'], 'hospedaje');
            }
            
            $data = [
                'nombre' => cleanInput($_POST['nombre']),
                'categoria' => (int)$_POST['categoria'],
                'direccion' => cleanInput($_POST['direccion']),
                'telefono' => cleanInput($_POST['telefono'] ?? ''),
                'enlace_reservacion' => cleanInput($_POST['enlace_reservacion'] ?? ''),
                'sitio_web' => cleanInput($_POST['sitio_web'] ?? ''),
                'imagen' => $imagen,
                'rango_precio_min' => !empty($_POST['rango_precio_min']) ? (float)$_POST['rango_precio_min'] : null,
                'rango_precio_max' => !empty($_POST['rango_precio_max']) ? (float)$_POST['rango_precio_max'] : null,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if ($this->hospedajeModel->create($data)) {
                logActivity('Creó hospedaje: ' . $data['nombre'], 'hospedaje');
                setFlash('success', 'Hospedaje creado exitosamente');
                redirect('hospedaje');
            } else {
                setFlash('danger', 'Error al crear el hospedaje');
                redirect('hospedaje/create');
            }
            
        } catch (Exception $e) {
            setFlash('danger', $e->getMessage());
            redirect('hospedaje/create');
        }
    }
    
    /**
     * Muestra formulario de edición
     */
    public function edit($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        $hospedaje = $this->hospedajeModel->getById($id);
        if (!$hospedaje) {
            setFlash('danger', 'Hospedaje no encontrado');
            redirect('hospedaje');
        }
        
        $this->view('hospedaje/form', ['hospedaje' => $hospedaje]);
    }
    
    /**
     * Actualiza hospedaje
     */
    public function update($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('hospedaje/edit/' . $id);
        }
        
        try {
            $hospedaje = $this->hospedajeModel->getById($id);
            if (!$hospedaje) {
                setFlash('danger', 'Hospedaje no encontrado');
                redirect('hospedaje');
            }
            
            // Subir nueva imagen si existe
            $imagen = $hospedaje['imagen'];
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Eliminar imagen anterior
                if (!empty($hospedaje['imagen'])) {
                    deleteImage($hospedaje['imagen'], 'hospedaje');
                }
                $imagen = uploadImage($_FILES['imagen'], 'hospedaje');
            }
            
            $data = [
                'nombre' => cleanInput($_POST['nombre']),
                'categoria' => (int)$_POST['categoria'],
                'direccion' => cleanInput($_POST['direccion']),
                'telefono' => cleanInput($_POST['telefono'] ?? ''),
                'enlace_reservacion' => cleanInput($_POST['enlace_reservacion'] ?? ''),
                'sitio_web' => cleanInput($_POST['sitio_web'] ?? ''),
                'imagen' => $imagen,
                'rango_precio_min' => !empty($_POST['rango_precio_min']) ? (float)$_POST['rango_precio_min'] : null,
                'rango_precio_max' => !empty($_POST['rango_precio_max']) ? (float)$_POST['rango_precio_max'] : null,
                'activo' => isset($_POST['activo']) ? 1 : 0
            ];
            
            if ($this->hospedajeModel->update($id, $data)) {
                logActivity('Actualizó hospedaje: ' . $data['nombre'], 'hospedaje');
                setFlash('success', 'Hospedaje actualizado exitosamente');
                redirect('hospedaje');
            } else {
                setFlash('danger', 'Error al actualizar el hospedaje');
                redirect('hospedaje/edit/' . $id);
            }
            
        } catch (Exception $e) {
            setFlash('danger', $e->getMessage());
            redirect('hospedaje/edit/' . $id);
        }
    }
    
    /**
     * Elimina hospedaje
     */
    public function delete($id) {
        $this->requireAnyRole(['admin', 'editor']);
        
        $hospedaje = $this->hospedajeModel->getById($id);
        if ($hospedaje) {
            // Eliminar imagen
            if (!empty($hospedaje['imagen'])) {
                deleteImage($hospedaje['imagen'], 'hospedaje');
            }
            
            if ($this->hospedajeModel->delete($id)) {
                logActivity('Eliminó hospedaje: ' . $hospedaje['nombre'], 'hospedaje');
                setFlash('success', 'Hospedaje eliminado exitosamente');
            } else {
                setFlash('danger', 'Error al eliminar el hospedaje');
            }
        } else {
            setFlash('danger', 'Hospedaje no encontrado');
        }
        
        redirect('hospedaje');
    }
}
?>
