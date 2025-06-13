<?php
require_once '../config/database.php';
require_once '../models/Paciente.php';
require_once '../controllers/PacienteController.php';

// Variables para controlar mensajes
$error = false;
$errorMsg = '';
$success = false;
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = Database::getInstance();
    $db = $database->getConnection();
    
    // Verificamos si la conexión fue exitosa
    if (!$db) {
        $error = true;
        $errorMsg = 'Error de conexión a la base de datos.';
    } else {
        // Creamos una instancia del modelo
        $paciente = new Paciente($db);
        
        // Creamos una instancia del controlador
        $pacienteController = new PacienteController($paciente);
        
        $resultado = $pacienteController->registrarPaciente($_POST);
        
        if ($resultado['success']) {
            // Si el registro fue exitoso, redirigimos a la página principal
            header('Location: index.php?success=true');
            exit;
        } else {
            // Si hay un error, lo mostramos
            $error = true;
            $errorMsg = $resultado['message'];
        }
    }
}

// Incluimos el encabezado
include_once '../includes/header.php';
?>

<!-- Contenido principal -->
<section class="registro-section">
    <div class="form-container">
        <h2 class="form-title">Registrar Nueva Visita</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo $errorMsg; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $successMsg; ?>
            </div>
        <?php endif; ?>
        
        <form id="formRegistro" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" id="apellido" name="apellido" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="cedula" class="form-label">Cédula:</label>
                <input type="text" id="cedula" name="cedula" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="edad" class="form-label">Edad:</label>
                <input type="number" id="edad" name="edad" class="form-control" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="motivo_visita" class="form-label">Motivo de la visita:</label>
                <select id="motivo_visita" name="motivo_visita" class="form-control" required>
                    <option value="">Seleccione un motivo</option>
                    <option value="Limpieza">Limpieza</option>
                    <option value="Caries">Caries</option>
                    <option value="Dolor">Dolor</option>
                    <option value="Chequeo">Chequeo</option>
                    <option value="Ortodoncia">Ortodoncia</option>
                    <option value="Extracción">Extracción</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Registrar Visita</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</section>

<?php
// Incluimos el pie de página
include_once '../includes/footer.php';
?>