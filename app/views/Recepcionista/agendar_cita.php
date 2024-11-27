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
    <title>Agendar Cita - Recepcionista</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/Gestion_clinica/app/js/tailwind-config.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100">
    <!-- Encabezado -->
    <?php include '../../includes/header_recepcionista.php'; ?>

    <section class="my-8">
        <h2 class="text-Moradote text-3xl font-bold text-center">Agendar Cita Médica</h2>
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
                    <div id="errorCedula" class="text-red-500 mt-2"></div> <!-- Aquí se mostrará el mensaje de error -->
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
        // Variable para almacenar el tiempo de espera
        let timeout;

        $('#cedula').keyup(function() {
            var cedula = $(this).val(); // Obtener el valor de la cédula

            // Eliminar mensaje de error anterior
            $('#errorCedula').remove();

            // Limitar las solicitudes con un retraso
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                if (cedula.length > 0) {
                    $.ajax({
                        url: '/Gestion_Clinica/app/controllers/PacienteController.php',
                        type: 'GET',
                        data: {
                            action: 'buscarPorCedula',
                            cedula: cedula
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response.existe)
                            // Si la cédula existe
                            if (response.existe) {
                                cargarServiciosPorUsuario(cedula);
                            } else {
                                // Si no existe, mostrar el error
                                $('#cedula').after('<div id="errorCedula" class="text-red-500 mt-2">Cédula no encontrada</div>');
                            }
                        },
                        error: function() {
                            alert("Error al verificar la cédula.");
                        }
                    });
                }
            }, 500); // Espera 500ms después de que el usuario deje de escribir
        });

        // Función para cargar los médicos según el servicio seleccionado
        function cargarMedicosPorServicio() {
            var id_servicio = $('#servicio').val();
            if (id_servicio) {
                $.ajax({
                    url: '/Gestion_Clinica/app/controllers/MedicoController.php',
                    type: 'GET',
                    data: {
                        action: 'obtenerMedicosPorServicio',
                        id_servicio: id_servicio
                    },
                    dataType: 'json',
                    success: function(medicos) {
                        var selectMedico = $('#medico');
                        selectMedico.empty();
                        selectMedico.append('<option value="">Seleccione un médico</option>');

                        if (medicos.success && Array.isArray(medicos.data)) {
                            medicos.data.forEach(function(medico) {
                                selectMedico.append('<option value="' + medico.id_medico + '">' + medico.nombre_medico + '</option>');
                            });
                        } else {
                            alert("No se encontraron médicos para el servicio seleccionado.");
                        }
                    },
                    error: function() {
                        alert("Error al cargar los médicos.");
                    }
                });
            } else {
                $('#medico').empty().append('<option value="">Seleccione un médico</option>');
            }
        }

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
                        console.log(response)
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
    </script>

    <?php include '../../includes/footer.php'; ?>
</body>

</html>