<?php
class Database {
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            die("Error de conexión: " . $e->getMessage());
        }
        return $this->conn;
    }
}
?><?php
