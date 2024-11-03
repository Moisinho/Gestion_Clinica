<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reservas de Citas Médicas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../js/tailwind-config.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Encabezado -->
    <?php include '../../includes/header.php'; ?>
    
    <section class="my-8">
        <h2 class="text-Moradote text-3xl font-bold text-center">Registro de Reservas de Citas Médicas</h2>
        <hr class="mt-2 border-t-2 border-purple-700 w-1/2 mx-auto">
    </section>

    <div class="container mx-auto w-6/12 mb-10">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-Moradote mb-4">Datos de la Reserva de Cita</h3>
            <form id="reservaForm" method="POST" action="../../controllers/citaController.php">
                <input type="hidden" name="action" value="registrar">

                <div class="mb-4">
                    <label for="cedula" class="block text-gray-700">Cédula</label>
                    <input type="text" id="cedula" name="cedula" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="mb-4">
                    <label for="servicio" class="block text-gray-700">Servicios</label>
                    <select id="servicio" name="servicio" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Seleccione un servicio</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="motivo" class="block text-gray-700">Motivo de cita</label>
                    <input type="text" id="motivo" name="motivo" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="mb-4">
                    <label for="medico" class="block text-gray-700">Médico de atención</label>
                    <select id="medico" name="medico" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Seleccione un médico</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="fecha" class="block text-gray-700">Fecha de cita</label>
                    <input type="date" id="fecha" name="fecha_cita" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="bg-Moradote text-white px-4 py-2 rounded-lg hover:bg-Moradito">Agendar</button>
                    <button type="button" onclick="borrarReserva()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Borrar reserva</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para vaciar los campos del formulario
        function borrarReserva() {
            document.getElementById("reservaForm").reset();
        }

        // Cargar servicios dinámicamente
        $(document).ready(function() {
            $.ajax({
                url: '../../controllers/citaController.php',
                type: 'GET',
                data: { action: 'obtenerServicios' },
                dataType: 'json',
                success: function(servicios) {
                    console.log(servicios);
                    if (Array.isArray(servicios)) {
                        servicios.forEach(function(servicio) {
                            $('#servicio').append('<option value="' + servicio.id_servicio + '">' + servicio.nombre_servicio + '</option>');
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Error: " + textStatus + ", " + errorThrown);
                    console.log("Response: " + jqXHR.responseText);
                    alert("Error al cargar los servicios.");
                }
            });

            // Cargar médicos dinámicamente
            $.ajax({
                url: '../../controllers/citaController.php',
                type: 'GET',
                data: { action: 'obtenerMedicos' },
                dataType: 'json',
                success: function(medicos) {
                    console.log(medicos);
                    if (Array.isArray(medicos)) {
                        medicos.forEach(function(medico) {
                            $('#medico').append('<option value="' + medico.id_medico + '">' + medico.nombre_medico + '</option>');
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Error: " + textStatus + ", " + errorThrown);
                    console.log("Response: " + jqXHR.responseText);
                    alert("Error al cargar los médicos.");
                }
            });
        });
    </script>
    <?php include '../../includes/footer.php'; ?>
</body>
</html>
