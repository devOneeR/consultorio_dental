<?php
require_once '../config/database.php';
require_once '../models/Paciente.php';
require_once '../controllers/PacienteController.php';

$database = Database::getInstance();
$db = $database->getConnection();

$paciente = new Paciente($db);

$pacienteController = new PacienteController($paciente);

$pacientes = $pacienteController->listarPacientes();

include_once '../includes/header.php';
?>

<!-- Contenido principal -->
<section class="pacientes-section">
    <div class="section-header">
        <h2>Registro de Visitas</h2>
        <a href="registro.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Visita
        </a>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
        <div class="alert alert-success">
            Visita registrada correctamente.
        </div>
    <?php endif; ?>

    <?php if (count($pacientes) > 0): ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cédula</th>
                        <th>Edad</th>
                        <th>Motivo de Visita</th>
                        <th>Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $paciente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($paciente['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['cedula']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['edad']); ?></td>
                            <td><?php echo htmlspecialchars($paciente['motivo_visita']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($paciente['fecha_hora'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            No hay visitas registradas aún.
        </div>
    <?php endif; ?>
</section>

<?php
include_once '../includes/footer.php';
?>