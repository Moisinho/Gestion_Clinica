<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../../../index.php');
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
    <script src="../js/tailwind-config.js"></script>
</head>
<body class="bg-gray-50 font-sans">
    <?php include '../../includes/header_doctor.php'; ?>
    <!-- Contenido principal -->
    <div class="container mx-auto p-5">
        
        <div class="bg-white p-5 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-Moradote mb-4">Historial Clínico</h2>
            <div id="historial-container"></div>

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
            <div id="mensajeError" class="text-red-500 mt-4"></div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>
    <script src="../Js/Doctor/detalles_cita_medica.js"></script>
    <script>
    $(document).ready(function() {
    // Obtener id_paciente desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const id_paciente = urlParams.get('id_paciente');
    
    if (!id_paciente) {
        $('#mensajeError').text('ID del paciente no proporcionado.');
        return;
    }

    $(document).ready(function() {
    // Obtener id_paciente desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const id_paciente = urlParams.get('id_paciente');
    
    if (!id_paciente) {
        $('#mensajeError').text('ID del paciente no proporcionado.');
        return;
    }

    $.ajax({
        url: `../../controllers/Historial_clinico.php?id_paciente=${id_paciente}`,  // Cambiar a la URL correcta de tu controlador
        method: 'GET',  // Cambiado a GET
        dataType: 'json',
        success: function(response) {
            if (!response.error) {  // Revisar que no haya error en la respuesta
                const datosPersonales = `
                    <p><strong>Nombre del paciente:</strong> ${response[0].nombre_paciente}</p>
                    <p><strong>Cédula:</strong> ${response[0].cedula}</p>
                    <p><strong>Fecha de nacimiento:</strong> ${new Date(response[0].fecha_nacimiento).toLocaleDateString()}</p>
                    <p><strong>Teléfono:</strong> ${response[0].telefono}</p>
                    <p><strong>Correo:</strong> ${response[0].correo_paciente}</p>
                `;
                $('#datosPersonales').html(datosPersonales);

                response.forEach(entry => {
                    const cita = `
                        <div class="bg-blue-100 p-4 rounded-lg mt-2">
                            <p><strong>Médico asignado:</strong> ${entry.medico}</p>
                            <p><strong>Fecha de la cita:</strong> ${new Date(entry.fecha_cita).toLocaleDateString()}</p>
                            <p><strong>Diagnóstico:</strong> ${entry.diagnostico}</p>
                            <p><strong>Tratamiento:</strong> ${entry.tratamiento}</p>
                            <p><strong>Receta:</strong> ${entry.receta}</p>
                            <p><strong>Exámenes:</strong> ${entry.examenes}</p>
                            <p><strong>Observaciones:</strong> ${entry.recomendaciones}</p>
                        </div>
                    `;
                    $('#citasMedicas').append(cita);
                });
            } else {
                $('#mensajeError').text(response.error);
            }
        },
        error: function() {
            $('#mensajeError').text('Error al cargar el historial clínico.');
        }
    });
});

});

    </script>
    <script src="../../js/tailwind-config.js"></script>
</body>

</html>
