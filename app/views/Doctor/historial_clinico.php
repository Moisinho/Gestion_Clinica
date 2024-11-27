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
</head>

<body class="bg-gray-50 font-sans">
    <?php include '../../includes/header_doctor.php'; ?>
    <!-- Contenido principal -->
    <div class="container mx-auto p-5 min-h-screen">

        <div class="bg-white p-5 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-Moradote mb-6">Historial Clínico</h2>

            <!-- Datos personales del paciente -->
            <div class="bg-blue-50 p-4 rounded-lg shadow-sm mb-6">
                <h3 class="text-xl font-semibold text-Moradote mb-3">Datos personales</h3>
                <div id="datosPersonales" class="text-gray-700"></div>
            </div>

            <!-- Citas Médicas -->
            <div>
                <h3 class="text-xl font-semibold text-Moradote mb-3">Citas Médicas</h3>
                <div id="citasMedicas">
                    <!-- Aquí se agregarán las citas -->
                </div>
            </div>

            <!-- Mensaje de error -->
            <div id="mensajeError" class="mt-4 text-red-600"></div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id_paciente = urlParams.get("id_paciente");

            if (!id_paciente) {
                document.getElementById("mensajeError").innerText = "ID del paciente no proporcionado.";
                return;
            }

            $.ajax({
                url: `/Gestion_clinica/app/controllers/HistorialController.php?action=obtenerPorCedula&cedula=${id_paciente}`,
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
                        $('#citasMedicas').html('<p class="text-gray-600">No se encontraron citas médicas para este paciente.</p>');
                        return;
                    }

                    historial.forEach(entry => {
                        // Dividir correctamente medicamentos, dosis y frecuencia
                        const medicamentos = entry.medicamentos ? entry.medicamentos.split(", ") : [];
                        const dosis = entry.dosis ? entry.dosis.split(", ") : [];
                        const frecuencia = entry.frecuencia ? entry.frecuencia.split(", ") : [];

                        let cita = `
                            <div class="bg-blue-100 p-6 rounded-lg shadow-md mb-6">
                                <h4 class="text-xl font-bold text-Moradote mb-3">Cita - ${entry.fecha_cita}</h4>
                                <p><strong>Médico asignado:</strong> ${entry.medico}</p>
                                <p><strong>Motivo de cita:</strong> ${entry.motivo}</p>
                                <p><strong>Diagnóstico:</strong> ${entry.diagnostico}</p>
                                <p><strong>Tratamiento:</strong> ${entry.tratamiento}</p>
                                <p><strong>Exámenes:</strong> ${entry.examenes}</p>
                                <p><strong>Referencia médica:</strong> ${entry.departamento_referencia}</p>

                                <div class="mt-4">
                                    <h5 class="font-semibold text-lg text-Moradote">Datos tomados del paciente</h5>
                                    <div class="grid grid-cols-2 gap-4 mt-2">
                                        <p><strong>Peso:</strong> ${entry.peso} kg</p>
                                        <p><strong>Altura:</strong> ${entry.altura} cm</p>
                                        <p><strong>Presión Arterial:</strong> ${entry.presion_arterial} mmHg</p>
                                        <p><strong>Frecuencia cardíaca:</strong> ${entry.frecuencia_cardiaca} bpm</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h5 class="font-semibold text-lg text-Moradote">Datos de receta médica</h5>
                                    ${medicamentos.length > 0 ? `
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 ">
                                            ${medicamentos.map((medicamento, index) => `
                                                <div class="p-4 rounded-lg shadow-sm bg-blue-100 border border-2 border-blue-300">
                                                    <p><strong>Medicamento:</strong> ${medicamento}</p>
                                                    <p><strong>Dosis:</strong> ${dosis[index] || "No especificado"}</p>
                                                    <p><strong>Frecuencia/hora:</strong> ${frecuencia[index] || "No especificado"}</p>
                                                </div>
                                            `).join('')}
                                        </div>
                                    ` : `<p class="text-gray-600">No hay medicamentos registrados.</p>`}
                                </div>
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