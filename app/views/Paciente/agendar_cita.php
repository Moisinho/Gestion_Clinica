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
            <form id="reservaForm" method="POST" action="/Gestion_clinica/app/controllers/CitaController.php">
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
                    <label for="medico" class="block text-gray-700">Médico de atención</label>
                    <select id="medico" name="medico" required class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Seleccione un médico</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="motivo" class="block text-gray-700">Motivo de cita</label>
                    <input type="text" id="motivo" name="motivo" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
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

        $(document).ready(function() {
            // Cargar la cédula del usuario logeado
            $.ajax({
                url: '/Gestion_Clinica/app/controllers/PacienteController.php', // Ruta al controlador del Paciente
                type: 'GET',
                data: {
                    action: 'obtenerCedulaById',
                    id_usuario: id_usuario // Supongamos que `id_usuario` está definido en algún lado
                },
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        console.log(data.error);
                        alert("Error: " + data.error);
                    } else {
                        $('#cedula').val(data.cedula || 'error'); // Mostrar la cédula en el campo

                        const cedula = data.cedula; // Guardar la cédula obtenida
                        if (cedula) {
                            // Llamar al controlador para obtener los servicios dinámicos
                            cargarServiciosPorUsuario(cedula);
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error al cargar la cédula:", textStatus, errorThrown);
                    console.log("Respuesta del servidor:", jqXHR.responseText); // Ver respuesta completa
                    alert("Error al cargar la cédula.");
                }
            });

            // Función para cargar servicios según la cédula del usuario
            function cargarServiciosPorUsuario(cedula) {
                $.ajax({
                    url: '/Gestion_Clinica/app/controllers/ServicioController.php', // Ruta al controlador del servicio
                    type: 'GET',
                    data: {
                        action: 'obtenerServiciosPorUsuario',
                        cedula: cedula
                    },
                    dataType: 'json',
                    success: function(response) {
                        const selectServicio = $('#servicio');
                        selectServicio.empty(); // Limpiar opciones del select
                        selectServicio.append('<option value="">Seleccione un servicio</option>');

                        if (response.success && Array.isArray(response.data)) {
                            // Agregar cada servicio al select
                            response.data.forEach(function(servicio) {
                                selectServicio.append(
                                    '<option value="' +
                                    servicio.id_departamento +
                                    '">' +
                                    servicio.nombre_departamento + '</option>'
                                );
                            });
                        } else {
                            alert("No se encontraron servicios para este usuario.");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error al cargar servicios:", textStatus, errorThrown);

                    }
                });
            }

            // Escuchar cambios en el select de servicios para cargar médicos
            $('#servicio').on('change', function() {
                const idDepartamento = $(this).val();

                if (idDepartamento) {
                    cargarMedicosPorDepartamento(idDepartamento);
                } else {
                    $('#medico').empty();
                    $('#medico').append('<option value="">Seleccione un médico</option>');
                }
            });

            // Función para cargar médicos según el departamento seleccionado
            function cargarMedicosPorDepartamento(idDepartamento) {
                id_servicio = idDepartamento

                $.ajax({
                    url: '/Gestion_Clinica/app/controllers/MedicoController.php', // Ruta al controlador del médico
                    type: 'GET',
                    data: {
                        action: 'obtenerMedicosPorServicio',
                        id_servicio: id_servicio
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log("Médicos obtenidos:", response);
                        const selectMedico = $('#medico');
                        selectMedico.empty(); // Limpiar opciones del select
                        selectMedico.append('<option value="">Seleccione un médico</option>');

                        if (response.success && Array.isArray(response.data)) {
                            response.data.forEach(function(medico) {
                                if (medico.id_medico && medico.nombre_medico) {
                                    selectMedico.append(
                                        `<option value="${medico.id_medico}">${medico.nombre_medico}</option>`
                                    );
                                } else {
                                    console.error("Faltan datos en el objeto medico:", medico);
                                }
                            });
                        } else {
                            alert("No se encontraron médicos para este departamento.");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error al cargar médicos:", textStatus, errorThrown);
                        console.log("Respuesta del servidor:", jqXHR.responseText);
                        alert("Error al cargar los médicos.");
                    }
                });
            }
        });
    </script>
    <?php include '../../includes/footer.php'; ?>
</body>

</html>