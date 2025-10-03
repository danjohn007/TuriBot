<?php
require_once APP_PATH . '/controllers/BaseController.php';
require_once APP_PATH . '/models/Configuracion.php';

class ConfiguracionController extends BaseController {
    private $configuracionModel;
    
    public function __construct() {
        parent::__construct();
        $this->configuracionModel = new Configuracion();
    }
    
    public function index() {
        $this->requireRole('admin');
        $configuraciones = $this->configuracionModel->getAllAsArray();
        $this->view('configuracion/index', ['configuraciones' => $configuraciones]);
    }
    
    public function update() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('configuracion');
        }
        
        try {
            // Actualizar todas las configuraciones
            foreach ($_POST as $clave => $valor) {
                if ($clave !== 'csrf_token') {
                    $this->configuracionModel->update($clave, cleanInput($valor));
                }
            }
            
            logActivity('Actualizó configuración general', 'configuracion');
            setFlash('success', 'Configuración actualizada exitosamente');
        } catch (Exception $e) {
            setFlash('danger', 'Error al actualizar la configuración');
        }
        
        redirect('configuracion');
    }
}
?>
