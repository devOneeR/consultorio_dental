<?php

class Paciente {
    private $conn;        
    private $table_name = "pacientes";

    // Propiedades que corresponden a los campos de la tabla
    public $id;
    public $nombre;
    public $apellido;
    public $cedula;
    public $edad;
    public $motivo_visita;
    public $fecha_hora;

  
    public function __construct($db) {
        $this->conn = $db;
    }
    public function obtenerTodos() {
        if ($this->conn === null) {
            echo "Error: No hay conexión a la base de datos disponible.";
            return false;
        }
        
        try {
            // Consulta SQL para seleccionar todos los pacientes ordenados por fecha
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY fecha_hora DESC";
            
            $stmt = $this->conn->prepare($query);
            
            // Ejecutamos la consulta
            $stmt->execute();
            
            return $stmt;
        } catch (PDOException $e) {
            echo "Error al obtener pacientes: " . $e->getMessage();
            return false;
        }
    }

    public function cedulaExiste($cedula) {
        if ($this->conn === null) {
            return false;
        }
        
        try {
            // Consulta SQL para verificar si la cédula existe
            $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE cedula = :cedula";
            
            $stmt = $this->conn->prepare($query);
            
            $cedula = htmlspecialchars(strip_tags($cedula));
            
            $stmt->bindParam(":cedula", $cedula);
            
            $stmt->execute();
            
            $count = $stmt->fetchColumn();
            
            return $count > 0;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function crear() {
        if ($this->conn === null) {
            echo "Error: No hay conexión a la base de datos disponible.";
            return false;
        }
        
        try {
            // Primero verificamos si la cédula ya existe
            if ($this->cedulaExiste($this->cedula)) {
                // Si la cédula ya existe, no intentamos insertar
                return false;
            }
            
            // Consulta SQL para insertar un nuevo paciente
            $query = "INSERT INTO " . $this->table_name . " 
                    (nombre, apellido, cedula, edad, motivo_visita, fecha_hora) 
                    VALUES (:nombre, :apellido, :cedula, :edad, :motivo_visita, :fecha_hora)";
            
            $stmt = $this->conn->prepare($query);
            
            $this->nombre = htmlspecialchars(strip_tags($this->nombre));
            $this->apellido = htmlspecialchars(strip_tags($this->apellido));
            $this->cedula = htmlspecialchars(strip_tags($this->cedula));
            $this->edad = htmlspecialchars(strip_tags($this->edad));
            $this->motivo_visita = htmlspecialchars(strip_tags($this->motivo_visita));

            $this->fecha_hora = date('Y-m-d H:i:s');
            
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":apellido", $this->apellido);
            $stmt->bindParam(":cedula", $this->cedula);
            $stmt->bindParam(":edad", $this->edad);
            $stmt->bindParam(":motivo_visita", $this->motivo_visita);
            $stmt->bindParam(":fecha_hora", $this->fecha_hora);
            
            if($stmt->execute()) {
                return true; // Éxito
            }
            
            return false; // Error
        } catch (PDOException $e) {
            // Capturamos específicamente el error de duplicación de cédula
            if ($e->getCode() == '23000') {
                return false;
            }
            
            // Para otros errores, podemos mostrar el mensaje
            echo "Error al crear paciente: " . $e->getMessage();
            return false;
        }
    }
}
?>