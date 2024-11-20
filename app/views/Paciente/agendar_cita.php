<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../../../index.php');
    exit();
}

$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null; 

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reservas de Citas Médicas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/Gestion_clinica/app/js/tailwind-config.js"></script>
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
            <form id="reservaForm" method="POST" action="/Gestion_clinica/app/controllers/citaController.php">
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
        var id_usuario = <?php echo json_encode($id_usuario); ?>;

        // Función para vaciar los campos del formulario
        function borrarReserva() {
            document.getElementById("reservaForm").reset();
        }

        // Cargar servicios dinámicamente
        $(document).ready(function() {
            // Cargar la cédula del usuario logeado
            $.ajax({
                url: '../../controllers/PacienteController.php', // Ruta al controlador del Paciente
                type: 'GET',
                data: {
                    action: 'obtenerCedulaById',
                    id_usuario: id_usuario 
                },
                dataType: 'json',
                success: function (data) {
                    console.log("Respuesta de obtenerCedulaById:", data); // Verificar respuesta
                    if (data.error) {
                        console.log(data.error);
                        alert("Error: " + data.error);
                    } else {
                        console.log("Cédula obtenida:", data.cedula);
                        $('#cedula').val(data.cedula || 'error'); // Mostrar la cédula en el campo

                        // Verificar cita de Medicina General con la cédula obtenida
                        const cedula = data.cedula; // Guardar la cédula obtenida
                        if (cedula) {
                            $.ajax({
                                url: '../../controllers/HistorialController.php', // Ruta al controlador del Historial
                                type: 'GET',
                                data: {
                                    action: 'verificarCitaMedicinaGeneral',
                                    cedula: cedula
                                },
                                dataType: 'json',
                                success: function (response) {
                                    console.log("Respuesta de verificar cita:", response); // Verificar respuesta

                                    const selectServicio = $('#servicio');
                                    selectServicio.empty(); // Limpiar las opciones del select

                                    if (response.success) {
                                        alert(response.mensaje);
                                        // Mapear todos los servicios menos Medicina General
                                        $.ajax({
                                            url: '../../controllers/ServicioController.php',
                                            type: 'GET',
                                            data: {
                                                action: 'obtenerServiciosSinMedicinaGeneral',
                                                excluir: 'Cita Medicina General'
                                            },
                                            dataType: 'json',
                                            success: function (servicios) {
                                                console.log("Servicios obtenidos:", servicios);
                                                servicios.forEach(function (servicio) {
                                                    console.log("Agregando servicio: ", servicio);
                                                    selectServicio.append('<option value="' + servicio.id_servicio + '">' + servicio.nombre_servicio + '</option>');
                                                });

                                                // Llamar la función para cargar médicos al cargar la página
                                                cargarMedicosPorServicio();
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                console.error("Error al cargar servicios:", textStatus, errorThrown);
                                                console.log("Respuesta del servidor:", jqXHR.responseText);
                                                alert("Error al cargar los servicios.");
                                            }
                                        });
                                    } else {
                                        // Mapear solo Cita Medicina General y Odontología
                                        selectServicio.append('<option value="1">Cita Medicina General</option>');
                                        selectServicio.append('<option value="6">Cita Odontología</option>');

                                        // Llamar la función para cargar los médicos al verificar que no hay historial
                                        cargarMedicosPorServicio();
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.error("Error al verificar cita:", textStatus, errorThrown);
                                    console.log("Respuesta del servidor:", jqXHR.responseText); // Ver respuesta completa
                                    alert("Error al verificar la cita.");
                                }
                            });
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Error al cargar la cédula:", textStatus, errorThrown);
                    console.log("Respuesta del servidor:", jqXHR.responseText); // Ver respuesta completa
                    alert("Error al cargar la cédula.");
                }
            });

            // Función para cargar los médicos según el servicio seleccionado
            function cargarMedicosPorServicio() {
                var id_servicio = $('#servicio').val(); // Obtener el servicio seleccionado
                console.log("Servicio seleccionado: ", id_servicio);

                if (id_servicio) {
                    $.ajax({
                        url: '../../controllers/MedicoController.php',
                        type: 'GET',
                        data: {
                            action: 'obtenerMedicosPorServicio',
                            id_servicio: id_servicio
                        },
                        dataType: 'json',
                        success: function(medicos) {
                            console.log("Médicos obtenidos: ", medicos);
                            var selectMedico = $('#medico');
                            selectMedico.empty(); // Limpiar los médicos existentes
                            selectMedico.append('<option value="">Seleccione un médico</option>');

                            if (medicos.success && Array.isArray(medicos.data) && medicos.data.length > 0) {
                                // Agregar médicos al select
                                medicos.data.forEach(function(medico) {
                                    console.log("Agregando médico: ", medico);
                                    console.log("id del medico: ", medico.id_medico);
                                    selectMedico.append('<option value="' + medico.id_medico + '">' + medico.nombre_medico + '</option>');
                                });
                            } else {
                                alert("No se encontraron médicos para el servicio seleccionado.");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Error al cargar médicos por servicio:", textStatus, errorThrown);
                            alert("Error al cargar los médicos.");
                        }
                    });
                } else {
                    $('#medico').empty().append('<option value="">Seleccione un médico</option>');
                }
            }

            // Evento change para el select de servicios
            $('#servicio').change(function() {
                cargarMedicosPorServicio(); // Volver a cargar médicos cada vez que se cambie el servicio
            });
        });
    </script>
    <?php include '../../includes/footer.php'; ?>
</body>
</html>
