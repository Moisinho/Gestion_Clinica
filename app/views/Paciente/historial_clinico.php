<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /Gestion_clinica/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Clínico - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/Gestion_clinica/tailwind"></script>
</head>
<body class="bg-gray-50 font-sans">
    <?php include '../../includes/header.php'; ?>
    <!-- Contenido principal -->
    <div class="container mx-auto p-5 min-h-screen">
        
        <div class="bg-white p-5 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-Moradote mb-4">Historial Clínico</h2>
            
            <!-- Datos personales del paciente -->
            <div class="mb-5">
                <h3 class="text-xl font-bold text-Moradote">Datos personales</h3>
                <div id="datosPersonales" class="bg-blue-100 p-4 rounded-lg mt-2"></div>
            </div>

            <!-- Citas Médicas -->
            <div>
                <h3 class="text-xl font-bold text-Moradote">Citas Médicas</h3>
                <div id="citasMedicas"></div>
            </div>

            <!-- Mensaje de error -->
            <div id="mensajeError" class="mt-4"></div>
        </div>
    </div>
    </div>

    <?php include '../../includes/footer.php'; ?>
    <script>
    const id_usuario = "<?php echo $_SESSION['id_usuario']; ?>";
$(document).ready(function() {
    $.ajax({
        url: `/Gestion_clinica/app/controllers/HistorialController.php?action=obtenerPorUsuario&usuario=${id_usuario}`,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error || !response.success) {
                $('#mensajeError').text(response.error || 'Error al obtener datos.');
                return;
            }

            // Mostrar datos del paciente
            const paciente = response.paciente;
            if (!paciente) {
                $('#mensajeError').text('No se encontraron datos del paciente.');
                return;
            }

            const datosPersonales = `
                <p><strong>Nombre del paciente:</strong> ${paciente.nombre_paciente}</p>
                <p><strong>Cédula:</strong> ${paciente.cedula}</p>
                <p><strong>Fecha de nacimiento:</strong> ${paciente.fecha_nacimiento}</p>
                <p><strong>Teléfono:</strong> ${paciente.telefono}</p>
                <p><strong>Correo:</strong> ${paciente.correo_paciente}</p>
            `;
            $('#datosPersonales').html(datosPersonales);

            // Mostrar historial médico (si existe)
            const historial = response.historial;
            if (historial.length === 0) {
                $('#citasMedicas').html('<p>No se encontraron citas médicas para este paciente.</p>');
                return;
            }

            historial.forEach(entry => {
                const cita = `
                    <div class="bg-blue-100 p-4 rounded-lg mt-2">
                        <p><strong>Médico asignado:</strong> ${entry.medico}</p>
                        <p><strong>Fecha de la cita:</strong> ${entry.fecha_cita}</p>
                        <p><strong>Motivo de cita:</strong> ${entry.motivo}</p>
                        <p><strong>Diagnóstico:</strong> ${entry.diagnostico}</p>
                        <p><strong>Tratamiento:</strong> ${entry.tratamiento}</p>
                        <p><strong>Exámenes:</strong> ${entry.examenes}</p>
                        <p><strong>Referencia médica:</strong> ${entry.departamento_referencia}</p>

                        <h2 class="text-Moradote mt-2 mb-1">Datos tomados del paciente</h2>
                        <p><strong>Peso:</strong> ${entry.peso}</p>
                        <p><strong>Altura:</strong> ${entry.altura}</p>
                        <p><strong>Presión Arterial:</strong> ${entry.presion_arterial}</p>
                        <p><strong>Frecuencia cardíaca:</strong> ${entry.frecuencia_cardiaca}</p>

                        <h2 class="text-Moradote mt-2 mb-1">Datos de receta médica</h2>
                        <p><strong>Medicamento:</strong> ${entry.nombre}</p>
                        <p><strong>Dosis:</strong> ${entry.dosis}</p>
                        <p><strong>Frecuencia:</strong> ${entry.frecuencia}</p>
                    </div>
                `;
                $('#citasMedicas').append(cita);
            });
        },
        error: function() {
            $('#mensajeError').text('No se encontraron datos del paciente.');
        }
    });
});

    </script>
</body>

</html>
