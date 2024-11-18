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
    <?php include '../../includes/header.php'; ?>
    <!-- Contenido principal -->
    <div class="container mx-auto p-5">

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
            <div id="mensajeError" class="text-red-500 mt-4"></div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../../controllers/HistorialController.php',
                method: 'GET',
                data: {
                    action: 'obtenerPorUsuario'
                },
                dataType: 'json',
                success: function(response) {
                    if (!response.success) {
                        $('#mensajeError').text(response.message || 'Error al obtener el historial clínico');
                        return;
                    }

                    const datos = response.data;

                    // Datos personales del paciente
                    const datosPersonales = `
                    <p><strong>Nombre del paciente:</strong> ${datos.nombre_paciente}</p>
                    <p><strong>Cédula:</strong> ${datos.cedula}</p>
                    <p><strong>Fecha de nacimiento:</strong> ${datos.fecha_nacimiento}</p>
                    <p><strong>Teléfono:</strong> ${datos.telefono}</p>
                    <p><strong>Correo:</strong> ${datos.correo_paciente}</p>
                `;
                    $('#datosPersonales').html(datosPersonales);

                    // Citas Médicas
                    if (datos.citas && datos.citas.length > 0) {
                        datos.citas.forEach(cita => {
                            const citaHTML = `
                            <div class="bg-blue-100 p-4 rounded-lg mt-2">
                                <p><strong>Médico asignado:</strong> ${cita.medico}</p>
                                <p><strong>Fecha de la cita:</strong> ${cita.fecha_cita}</p>
                                <p><strong>Diagnóstico:</strong> ${cita.diagnostico}</p>
                                <p><strong>Tratamiento:</strong> ${cita.tratamiento}</p>
                                <p><strong>Receta:</strong> ${cita.receta}</p>
                                <p><strong>Exámenes:</strong> ${cita.examenes}</p>
                                <p><strong>Observaciones:</strong> ${cita.recomendaciones}</p>
                                <p><strong>Referencia a:</strong>${cita.departamento_referencia || "Sin referencia"}</p>
                            </div>
                        `;
                            $('#citasMedicas').append(citaHTML);
                        });
                    } else {
                        $('#citasMedicas').html('<p>No se encontraron citas médicas registradas.</p>');
                    }
                },
                error: function() {
                    $('#mensajeError').text('Error al cargar el historial clínico.');
                }
            });
        });
    </script>
</body>

</html>