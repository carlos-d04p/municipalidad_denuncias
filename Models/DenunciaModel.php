<?php
class DenunciaModel {
    
    private $db;
    private $tabla = "denuncias";

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getDenuncias($busqueda, $estado, $limit, $offset) {
        
        $sql = "SELECT * FROM {$this->tabla}";
        $whereClauses = [];
        $params_where = [];

        if (!empty($busqueda)) {
            $whereClauses[] = "(titulo LIKE ? OR ciudadano LIKE ? OR ubicacion LIKE ?)";
            $searchTerm = "%{$busqueda}%";
            $params_where[] = $searchTerm;
            $params_where[] = $searchTerm;
            $params_where[] = $searchTerm;
        }

        // 2. Añadir filtro de estado (si existe)
        if (!empty($estado)) {
            $whereClauses[] = "estado = ?";
            $params_where[] = $estado;
        }
        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }
        

        $limit_int = (int) $limit;
        $offset_int = (int) $offset;
   
        $sql .= " ORDER BY id ASC LIMIT $limit_int OFFSET $offset_int";
        

        $stmt = $this->db->prepare($sql);
        
        $stmt->execute($params_where); 
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countDenuncias($busqueda, $estado) {
        $sql = "SELECT COUNT(id) FROM {$this->tabla}";
        $whereClauses = [];
        $params = []; 
        if (!empty($busqueda)) {
            $whereClauses[] = "(titulo LIKE ? OR ciudadano LIKE ? OR ubicacion LIKE ?)";
            $searchTerm = "%{$busqueda}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($estado)) {
            $whereClauses[] = "estado = ?";
            $params[] = $estado;
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function getDenunciaById($id) {
        $sql = "SELECT * FROM {$this->tabla} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registrarDenuncia($datos) {
        $sql = "INSERT INTO {$this->tabla} (titulo, ciudadano, telefono_ciudadano, ubicacion, descripcion, estado, fecha_registro) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['titulo'],
            $datos['ciudadano'],
            $datos['telefono_ciudadano'],
            $datos['ubicacion'],
            $datos['descripcion'],
            $datos['estado'],
            $datos['fecha_registro']
        ]);
    }

    public function actualizarDenuncia($datos) {
        $sql = "UPDATE {$this->tabla} SET 
                titulo = ?, ciudadano = ?, telefono_ciudadano = ?, 
                ubicacion = ?, descripcion = ?, estado = ?, fecha_registro = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $datos['titulo'], $datos['ciudadano'], $datos['telefono_ciudadano'],
            $datos['ubicacion'], $datos['descripcion'], $datos['estado'],
            $datos['fecha_registro'],
            $datos['id']
        ]);
    }

    public function eliminarDenuncia($id) {
        $sql = "DELETE FROM {$this->tabla} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function countPendientes() {
        $sql = "SELECT COUNT(id) FROM {$this->tabla} WHERE estado = 'pendiente'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>