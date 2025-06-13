<?php
class PacienteController {
    // Propiedades privadas
    private $pacienteModel;
    

    public function __construct($pacienteModel) {
        $this->pacienteModel = $pacienteModel;
    }
    
    public function listarPacientes() {
        // Llamamos al método del modelo para obtener todos los pacientes
        $stmt = $this->pacienteModel->obtenerTodos();
        
        if ($stmt === false) {
            return [];
        }
        
        // Creamos un arreglo para almacenar los resultados
        $pacientes = [];
        
        // Recorremos los resultados y los agregamos al arreglo
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pacientes[] = $row;
        }
        
        return $pacientes;
    }
    

    public function verificarCedulaExistente($cedula) {
        return $this->pacienteModel->cedulaExiste($cedula);
    }
    
    public function registrarPaciente($datos) {
        if (
            empty($datos['nombre']) || 
            empty($datos['apellido']) || 
            empty($datos['cedula']) || 
            empty($datos['edad']) || 
            empty($datos['motivo_visita'])
        ) {
            return [
                'success' => false,
                'message' => 'Todos los campos son obligatorios.'
            ];
        }
        
        // Verificamos si la cédula ya existe
        if ($this->verificarCedulaExistente($datos['cedula'])) {
            return [
                'success' => false,
                'message' => 'La cédula ' . $datos['cedula'] . ' ya está registrada en el sistema.'
            ];
        }
        
        $this->pacienteModel->nombre = $datos['nombre'];
        $this->pacienteModel->apellido = $datos['apellido'];
        $this->pacienteModel->cedula = $datos['cedula'];
        $this->pacienteModel->edad = $datos['edad'];
        $this->pacienteModel->motivo_visita = $datos['motivo_visita'];
        
        if ($this->pacienteModel->crear()) {
            return [
                'success' => true,
                'message' => 'Paciente registrado correctamente.'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Error al registrar el paciente. Por favor, intente nuevamente.'
        ];
    }
}
?>