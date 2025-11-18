<?php
class DenunciasController {
    
    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new DenunciaModel();
    }

    public function index() {
        // 1. Leer los parámetros de la URL
        $busqueda = $_GET['busqueda'] ?? '';
        $pagina = $_GET['page'] ?? 1;
        $estado = $_GET['estado'] ?? '';

        $pagina = filter_var($pagina, FILTER_VALIDATE_INT, [
            'options' => ['default' => 1, 'min_range' => 1]
        ]);

        $registrosPorPagina = defined('REGISTROS_POR_PAGINA') ? REGISTROS_POR_PAGINA : 5;

        $totalRegistros = (int) $this->model->countDenuncias($busqueda, $estado);

        $totalPaginas = 1; // Por defecto es 1
        if ($totalRegistros > 0) {
            $totalPaginas = (int) ceil($totalRegistros / $registrosPorPagina);
        }

        if ($pagina > $totalPaginas) {
            $pagina = $totalPaginas;
        }
        

        $offset = ($pagina - 1) * $registrosPorPagina;

        $data['denuncias'] = $this->model->getDenuncias($busqueda, $estado, $registrosPorPagina, $offset);

        $data['totalPaginas'] = $totalPaginas;
        $data['paginaActual'] = $pagina;
        $data['busqueda'] = $busqueda;
        $data['estado'] = $estado;
        $data['totalRegistros'] = $totalRegistros;

        // 10. Cargar la vista
        $this->cargarVista('listar', $data);
    }

    /**
     * Muestra el formulario para crear (crear.php)
     */
    public function crear() {
        $data['fecha_actual'] = date('Y-m-d\TH:i');
        $this->cargarVista('crear', $data);
    }

    /**
     * Guarda una nueva denuncia (desde crear.php)
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST;
            $errores = $this->validarDatos($datos);

            if (empty($errores)) {
                $this->model->registrarDenuncia($datos);
                unset($_SESSION['datos']); 
                header("Location: " . BASE_URL . "denuncias");
                exit;
            } else {
                $_SESSION['errores'] = $errores;
                $_SESSION['datos'] = $datos;
                header("Location: " . BASE_URL . "denuncias/crear");
                exit;
            }
        }
    }


    public function editar($params) {
        $id = $params[0] ?? null;
        if (!$id) {
            header("Location: " . BASE_URL . "denuncias");
            exit;
        }
        
        $data['denuncia'] = $this->model->getDenunciaById($id);
        if ($data['denuncia']) {
            $data['denuncia']['fecha_registro'] = date('Y-m-d\TH:i', strtotime($data['denuncia']['fecha_registro']));
        }
        
        $this->cargarVista('editar', $data);
    }


    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST;
            $errores = $this->validarDatos($datos);

            if (empty($errores)) {
                $this->model->actualizarDenuncia($datos);
                unset($_SESSION['datos']);
                header("Location: " . BASE_URL . "denuncias");
                exit;
            } else {
                $_SESSION['errores'] = $errores;
                $_SESSION['datos'] = $datos;
                header("Location: " . BASE_URL . "denuncias/editar/" . $datos['id']);
                exit;
            }
        }
    }

    public function eliminar($params) {
        $id = $params[0] ?? null;
        if ($id) {
            $this->model->eliminarDenuncia($id);
        }
        header("Location: " . BASE_URL . "denuncias");
        exit;
    }

    public function acerca() {
        $this->cargarVista('acerca');
    }

    private function cargarVista($vista, $data = []) {
        extract($data);
        
        require_once "Views/template/header.php";
        require_once "Views/vistas/" . $vista . ".php";
        require_once "Views/template/footer.php";
    }

    private function validarDatos($datos) {
        $errores = [];

        if (empty($datos['titulo'])) {
            $errores['titulo'] = "El título es obligatorio.";
        } elseif (strlen($datos['titulo']) < 5 || strlen($datos['titulo']) > 100) {
            $errores['titulo'] = "Debe tener entre 5 y 100 caracteres.";
        }
        
        if (empty($datos['ciudadano'])) {
            $errores['ciudadano'] = "El nombre del ciudadano es obligatorio.";
        } elseif (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/", $datos['ciudadano'])) {
            $errores['ciudadano'] = "Solo debe contener letras y espacios.";
        }
        
        if (empty($datos['telefono_ciudadano'])) {
            $errores['telefono_ciudadano'] = "El teléfono es obligatorio.";
        } elseif (!preg_match("/^[0-9]{9}$/", $datos['telefono_ciudadano'])) {
            $errores['telefono_ciudadano'] = "Debe contener exactamente 9 dígitos numéricos.";
        }
        
        if (empty($datos['ubicacion'])) {
            $errores['ubicacion'] = "La ubicación es obligatoria.";
        } elseif (strlen($datos['ubicacion']) < 5 || strlen($datos['ubicacion']) > 150) {
            $errores['ubicacion'] = "Debe tener entre 5 y 150 caracteres.";
        }
        
        if (empty($datos['descripcion'])) {
            $errores['descripcion'] = "La descripción es obligatoria.";
        } elseif (strlen($datos['descripcion']) < 10 || strlen($datos['descripcion']) > 255) {
            $errores['descripcion'] = "Debe tener entre 10 y 255 caracteres.";
        }
        
        if (empty($datos['estado']) || !in_array($datos['estado'], ['pendiente', 'en proceso', 'resuelto'])) {
            $errores['estado'] = "Seleccione un estado válido.";
        }

        if (empty($datos['fecha_registro'])) {
            $errores['fecha_registro'] = "La fecha y hora son obligatorias.";
        }

        return $errores;
    }
}
?>