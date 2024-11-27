<?php
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /Gestion_Clinica/index.php');
    exit();
}
// Inicializa la variable de selección del criterio
$criterioSeleccionado = isset($_POST['criterio']) ? $_POST['criterio'] : '';
$valorBusqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';
$id_usuario = $_SESSION['id_usuario'];

// Incluir la clase Database y Cita
require_once '../../includes/Database.php';
require_once '../../models/Cita.php';

// Crear instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Crear la instancia de Cita
$cita = new Cita($conn);

// Lógica para convertir el criterio a la columna correspondiente en la base de datos
if ($criterioSeleccionado == 'Fecha') {
    $criterioBD = 'fecha_cita';
} elseif ($criterioSeleccionado == 'Cédula') {
    $criterioBD = 'cedula';
} else {
    $criterioBD = '';
}

// Si se ha enviado el formulario y hay un valor de búsqueda y criterio válidos
if (!empty($criterioBD) && !empty($valorBusqueda)) {
    // Llamar a la función de búsqueda con los parámetros proporcionados
    $citas = $cita->buscarCitasPorCriterio($criterioBD, $valorBusqueda);
    // Limpiar el valor de búsqueda para que el campo aparezca vacío después de la búsqueda
    $valorBusqueda = '';
    // Reiniciar el criterio seleccionado para que el select vuelva a "Seleccione una opción"
    $criterioSeleccionado = ''; // Aquí reiniciamos el criterio seleccionado
} else {
    // Si no se ingresó un criterio o un valor de búsqueda, mostrar todas las citas pendientes
    $citas = $cita->mapear_citas_confirmadas();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturar Citas</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <?php include '../../includes/header_recepcionista.php';?>
    <div class="bg-[#6A5492] text-white p-4 flex items-center justify-center w-full">
        <div class="flex items-center w-full justify-center">
            <form method="POST" action="" class="flex items-center space-x-2 w-3/4">
                <select name="criterio" class="p-2 bg-white text-black rounded-md w-1/3">
                    <option value="" disabled <?php echo $criterioSeleccionado == '' ? 'selected' : ''; ?>>Seleccione una opción</option>
                    <option value="Fecha" <?php echo $criterioSeleccionado == 'Fecha' ? 'selected' : ''; ?>>Fecha</option>
                    <option value="Cédula" <?php echo $criterioSeleccionado == 'Cédula' ? 'selected' : ''; ?>>Cédula</option>
                </select>
                <input type="text" name="busqueda" class="p-2 rounded-md w-1/2 text-black" placeholder="Ingrese criterio de búsqueda" value="<?php echo htmlspecialchars($valorBusqueda); ?>">
                <button class="text-xl font-bold bg-gray-200 text-purple-600 p-2 rounded-md w-32">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Contenido principal -->
    <main class="flex flex-col mt-8 mx-4 md:mx-8 mb-8">
        <!-- Tabla de citas -->
        <div class="bg-white rounded-lg shadow-md h-[80vh] p-6 w-full mb-6 overflow-y-auto">
            <h2 class="text-2xl font-semibold text-purple-700 mb-4">Citas Sin Cobrar</h2>
            <table class="w-full border-collapse">
                <thead class="bg-purple-600 text-white">
                    <tr class="text-center">
                        <th class="p-3">id_cita</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Motivo</th>
                        <th class="p-3">Fecha Cita</th>
                        <th class="p-3">Diagnóstico</th>
                        <th class="p-3">Tratamiento</th>
                        <th class="p-3">Cédula</th>
                        <th class="p-3">id_medico</th>
                        <th class="p-3">id_servicio</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($citas)):?>
                        <?php foreach ($citas as $row): ?>
                            <tr class="border-b text-center">
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['id_cita']); ?></td>
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['estado']); ?></td>
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['motivo']); ?></td>
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['fecha_cita']); ?></td>
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['diagnostico']); ?></td>
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['tratamiento']); ?></td>
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['cedula']); ?></td>
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['id_medico']); ?></td>
                                <td class="border-r p-2"><?php echo htmlspecialchars($row['id_servicio']); ?></td>
                                <td class="border-r p-2">
                                        <div class="flex flex-col gap-2 items-center" method="POST">
                                            <!-- Botón Cobrar -->
                                            <button
                                                type="button" 
                                                id="boton-cobrar"
                                                class="bg-blue-500 text-white mx-2 p-2 w-24 rounded-md boton-cobrar" 
                                                data-id-cita="<?php echo htmlspecialchars($row['id_cita']); ?>" 
                                                data-id-servicio="<?php echo htmlspecialchars($row['id_servicio']); ?>">
                                                COBRAR
                                            </button>

                                            <!-- Botón Cancelar -->
                                            <button 
                                                type="button" 
                                                id="boton-cancelar"
                                                class="bg-red-500 text-white mx-2 p-2 w-24 rounded-md boton-cancelar" 
                                                data-id-cita="<?php echo htmlspecialchars($row['id_cita']); ?>">
                                                CANCELAR
                                            </button>
                                        </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="p-2 text-center">No se encontraron registros</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <!-- Modal Cobro -->
    <div id="modal-cobrar" class="hidden fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50 p-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 max-h-[80vh] overflow-y-auto">
            <!-- Header del Modal -->
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Cobrar Cita</h3>
                <button onclick="cerrarModal()" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>

            <!-- Campos ocultos para id_cita y id_servicio -->
            <input type="hidden" id="id_cita" name="id_cita">
            <input type="hidden" id="id_servicio" name="id_servicio">
            
            <!-- Radio Button para Método de Pago -->
            <div class="mb-4">
                <label class="block font-bold mb-2">Método de Pago:</label>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="metodo_pago" value="Tarjeta" onclick="mostrarCampos('tarjeta')" class="mr-2"> Tarjeta
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="metodo_pago" value="Efectivo" onclick="mostrarCampos('efectivo')" class="mr-2"> Efectivo
                    </label>
                </div>
            </div>
            
            <!-- Campos para Tarjeta -->
                <div id="campos-tarjeta" class="hidden space-y-4 p-4 border rounded-md h-96 overflow-y-auto">
                    <label class="block text-left font-bold" for="monto_tarjeta">Monto:</label>
                    <input required class="bg-gray-200 p-2 w-full monto" type="number" name="monto_tarjeta" placeholder="Ingrese monto">

                    <label class="block text-left font-bold" for="detalles_tarjeta">Detalles:</label>
                    <input required class="bg-gray-200 p-2 w-full detalles" type="text" name="detalles_tarjeta" readonly>

                    <label class="block text-left font-bold" for="numero_tarjeta">Número de Tarjeta:</label>
                    <input required class="bg-gray-200 p-2 w-full" type="text" id="numero_tarjeta" name="numero_tarjeta" placeholder="Ingrese número de tarjeta">

                    <label class="block text-left font-bold" for="nombre_propietario">Nombre del Propietario:</label>
                    <input required class="bg-gray-200 p-2 w-full" type="text" id="nombre_propietario" name="nombre_propietario" placeholder="Ingrese nombre del propietario">

                    <label class="block text-left font-bold" for="fecha_vencimiento">Fecha de Vencimiento:</label>
                    <input required class="bg-gray-200 p-2 w-full" type="month" id="fecha_vencimiento" name="fecha_vencimiento">

                    <label class="block text-left font-bold" for="cvv">CVV:</label>
                    <input required class="bg-gray-200 p-2 w-full" maxlength="3" type="text" id="cvv" name="cvv" placeholder="Ingrese CVV">
                </div>

            <!-- Campo para Efectivo -->
            <div id="campo-efectivo" class="hidden space-y-4 p-4 h-96 border rounded-md">
                <label class="block text-left font-bold mb-2" for="monto_efectivo">Monto:</label>
                <input class="bg-gray-200 p-2 w-full monto" type="number" name="monto_efectivo" placeholder="Ingrese monto">

                <label class="block text-left font-bold mb-2" for="detalles_efectivo">Detalles:</label>
                <input class="bg-gray-200 p-2 w-full detalles" type="text" name="detalles_efectivo" readonly>

            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end mt-4">
                <button onclick="cerrarModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancelar</button>
                <button id="cobrar-modal" class="bg-purple-600 text-white px-4 py-2 rounded-md">Cobrar</button>
            </div>
        </div>
    </div>
    <!-- Modal Cancelar Cita -->
    <div id="modal-cancelar" class="hidden fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50 p-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 max-h-[80vh] overflow-y-auto">
            <!-- Header del Modal -->
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Cancelar Cita</h3>
                <button id="equis-cancelar" onclick="cerrarModalCancelar()" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>

            <!-- Campos ocultos para id_cita y id_servicio -->
            <input type="hidden" id="id_cita_cancelar" name="id_cita_cancelar">
            <input type="hidden" id="id_servicio_cancelar" name="id_servicio_cancelar">

            <!-- Motivo de la Cancelación -->
            <div class="mb-4">
                <label class="block font-bold mb-2" for="motivo_cancelacion">Motivo de la Cancelación:</label>
                <textarea id="motivo_cancelacion" name="motivo_cancelacion" rows="4" class="bg-gray-200 p-2 w-full" placeholder="Ingrese el motivo de la cancelación..."></textarea>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end mt-4">
                <button id="volver-cancelar" onclick="cerrarModalCancelar()" class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Volver</button>
                <button disabled id="enviar-cancelacion" class="bg-red-600 text-white px-4 py-2 rounded-md">Enviar</button>
            </div>
        </div>
    </div>

    <script>
        // Función para verificar si los campos están completos y habilitar el botón de "Cobrar"
        function verificarCampos() {
            let todosCompletos = true; // Variable para verificar si todos los campos están completos

            // Verificar campos de tarjeta si están visibles
            if ($('#campos-tarjeta').is(':visible')) {
                $('#campos-tarjeta input').each(function () {
                    if ($(this).val() === '') {
                        todosCompletos = false;
                        $(this).css('border', '1px solid red'); // Resaltar campo vacío en rojo
                    } else {
                        $(this).css('border', ''); // Limpiar el borde si el campo está lleno
                    }
                });
            }

            // Verificar campos de efectivo si están visibles
            if ($('#campo-efectivo').is(':visible')) {
                $('#campo-efectivo input').each(function () {
                    if ($(this).val() === '') {
                        todosCompletos = false;
                        alert("Debe llenar todos los campos"); // Mostrar alerta si un campo está vacío
                        $(this).css('border', '1px solid red'); // Resaltar campo vacío en rojo
                    } else {
                        $(this).css('border', ''); // Limpiar el borde si el campo está lleno
                    }
                });
            }

            // Habilitar o deshabilitar el botón según el estado de los campos
            if (todosCompletos) {
                $('#cobrar-modal').prop('disabled', false); // Habilitar el botón si todos los campos están completos
            } else {
                $('#cobrar-modal').prop('disabled', true); // Deshabilitar el botón si faltan campos
            }
            return todosCompletos
        }

        // Llamar a la función verificarCampos cuando el usuario cambia el estado de los campos
        $('#campos-tarjeta input, #campo-efectivo input').on('input', function () {
            verificarCampos(); // Verificar los campos cada vez que el usuario ingrese un dato
        });

        // Mostrar los campos según el método de pago seleccionado
        function mostrarCampos(metodo) {
            const camposTarjeta = document.getElementById('campos-tarjeta');
            const campoEfectivo = document.getElementById('campo-efectivo');

            // Mostrar los campos correspondientes según el método seleccionado
            if (metodo === 'tarjeta') {
                camposTarjeta.classList.remove('hidden');
                campoEfectivo.classList.add('hidden');
            } else if (metodo === 'efectivo') {
                campoEfectivo.classList.remove('hidden');
                camposTarjeta.classList.add('hidden');
            }
        }

        // Función para cerrar el modal
        function cerrarModal() {
            const modal = document.getElementById('modal-cobrar');
            modal.classList.add('hidden');
        }

        $(document).ready(function () {
        // Cuando se haga clic en un botón para cobrar
        $('.boton-cobrar').on('click', function () {
            const idCita = $(this).data('id-cita'); // Captura el valor del atributo data-id-cita
            const idServicio = $(this).data('id-servicio'); 

            $('#cobrar-modal').data('id-cita', idCita);

            // Mostrar el modal
            document.getElementById('modal-cobrar').classList.remove('hidden');

            console.log('ID Cita seleccionado:', idCita); // Verificar el ID de la cita
            console.log('ID Servicio seleccionado:', idServicio); // Verificar el ID del servicio

            // Obtener el diagnóstico
            $.ajax({
                url: '/Gestion_Clinica/app/controllers/CitaController.php',
                type: 'GET',
                data: {
                    action: 'obtenerDiagnostico',
                    id_cita: idCita
                },
                success: function (response) {
                    console.log('Respuesta del servidor (Diagnóstico):', response); // Inspeccionar la respuesta del servidor
                    try {
                        const data = JSON.parse(response);
                        if (data.diagnostico) {
                            $('.detalles').val(data.diagnostico); // Rellenar el campo de detalles
                        } else {
                            console.error('El diagnóstico no se encuentra en la respuesta:', data);
                        }
                    } catch (error) {
                        console.error('Error al procesar el JSON del diagnóstico:', error, response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener el diagnóstico:', status, error);
                    console.error('Respuesta completa:', xhr.responseText);
                }
            });

            // Obtener el costo del servicio
            $.ajax({
                url: '/Gestion_Clinica/app/controllers/ServicioController.php',
                type: 'GET',
                data: {
                    action: 'obtenerCosto',
                    id_servicio: idServicio
                },
                success: function (response) {
                    console.log('Respuesta del servidor (Costo):', response); // Inspeccionar la respuesta del servidor
                    try {
                        const data = JSON.parse(response);
                        if (data.monto) {
                            $('.monto').val(data.monto); // Rellenar el campo de monto
                        } else {
                            console.error('El costo no se encuentra en la respuesta:', data);
                        }
                    } catch (error) {
                        console.error('Error al procesar el JSON del costo:', error, response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener el costo del servicio:', status, error);
                    console.error('Respuesta completa:', xhr.responseText);
                }
            });
        });
        // Manejo de apertura del modal
        $('.boton-cancelar').on('click', function () {
            const idCita = $(this).data('id-cita');
            $('#modal-cancelar').removeClass('hidden');

            $('#enviar-cancelacion').data('id-cita', idCita);
        });

        // Verificar si el campo de motivo de cancelación está lleno para habilitar o deshabilitar el botón
        $('#motivo_cancelacion').on('input', function () {
            const motivo_cancelacion = $(this).val();

            // Si el campo motivo_cancelacion tiene texto, habilitar el botón
            if (motivo_cancelacion.trim() !== '') {
                $('#enviar-cancelacion').prop('disabled', false);
            } else {
                $('#enviar-cancelacion').prop('disabled', true);
            }
        });

        // Función para cerrar el modal
        function cerrarModalCancelar() {
            $('#modal-cancelar').addClass('hidden');
        }

        // Cerrar el modal cuando se hace clic en la X
        $('#equis-cancelar').on('click', function () {
            cerrarModalCancelar();
        });

        // Cerrar el modal cuando se hace clic en el botón "Volver"
        $('#volver-cancelar').on('click', function () {
            cerrarModalCancelar();
        });

        $('#enviar-cancelacion').on('click', function () {
            // Obtener el ID de la cita del atributo data-id-cita
            const idCita = $(this).data('id-cita');
            const nuevo_estado = "Cancelada";
            const motivo_cancelacion = $('#motivo_cancelacion').val(); 
            // Realizar la petición POST usando AJAX
            $.ajax({
                url: '/Gestion_Clinica/app/controllers/CitaController.php',  // Cambia esta URL según la ruta de tu controlador
                type: 'POST',
                data: { 
                        action: 'actualizar',
                        id_cita: idCita,
                        nuevo_estado: nuevo_estado
                 },  // Enviar el idCita al servidor
                success: function(response) {
                    console.log("Id cita:",idCita)
                    console.log("Estado:",nuevo_estado)
                    // Aquí puedes manejar la respuesta de la petición
                    console.log('Cita actualizada:', response);
                    alert('Cita cancelada correctamente.');
                    // Si quieres cerrar el modal después de la petición, puedes hacerlo aquí
                    cerrarModalCancelar();
                },
                error: function(xhr, status, error) {
                    // Aquí puedes manejar cualquier error en la petición
                    console.error('Error al actualizar la cita:', error);
                }
            });
            $.ajax({
                url: '/Gestion_Clinica/app/controllers/CitaController.php',  // Cambia esta URL según la ruta de tu controlador
                type: 'POST',
                data: { 
                        action: 'insertarMotivoCancelar',
                        id_cita: idCita,
                        motivo_cancelacion: motivo_cancelacion
                 },  // Enviar el idCita al servidor
                success: function(response) {
                    // Aquí puedes manejar la respuesta de la petición
                    console.log('Cita actualizada:', response);
                    // Si quieres cerrar el modal después de la petición, puedes hacerlo aquí
                    cerrarModalCancelar();
                },
                error: function(xhr, status, error) {
                    // Aquí puedes manejar cualquier error en la petición
                    console.error('Error al actualizar la cita:', error);
                }
            });
        });

        $('#cobrar-modal').on('click', function () {
            if(!verificarCampos){
                alert('Debe llenar todos los campos.');
            }
            else{
                let todosCompletos = true; 

                // Verificar campos de tarjeta si están visibles
                if ($('#campos-tarjeta').is(':visible')) {
                    console.log('Campos de tarjeta visibles');
                    // Verificar cada campo dentro de los campos de tarjeta
                    $('#campos-tarjeta input').each(function () {
                        if ($(this).val() === '') {
                            todosCompletos = false;
                            $(this).css('border', '1px solid red'); // Resaltar campo vacío en rojo
                            console.log('Campo vacío en tarjeta: ', $(this).attr('name'));
                        } else {
                            $(this).css('border', ''); // Limpiar el borde si el campo está lleno
                        }
                    });
                }

                // Verificar campos de efectivo si están visibles
                if ($('#campo-efectivo').is(':visible')) {
                    console.log('Campos de efectivo visibles');
                    // Verificar cada campo dentro de los campos de efectivo
                    $('#campo-efectivo input').each(function () {
                        if ($(this).val() === '') {
                            todosCompletos = false;
                            $(this).css('border', '1px solid red'); // Resaltar campo vacío en rojo
                            console.log('Campo vacío en efectivo: ', $(this).attr('name'));
                        } else {
                            $(this).css('border', ''); // Limpiar el borde si el campo está lleno
                        }
                    });
                }

                // Si alguno de los campos está vacío, mostrar mensaje y no continuar con la ejecución
                if (!todosCompletos) {
                    alert('Por favor, complete todos los campos.');
                    return; // Detener la ejecución del código AJAX
                }

                // Si todos los campos están completos, continuar con la solicitud AJAX
                console.log('Todos los campos están completos. Proceder con el cobro.');

                const monto = $('input[name="monto_tarjeta"], input[name="monto_efectivo"]').val();
                const detalles = $('input[name="detalles_tarjeta"], input[name="detalles_efectivo"]').val();
                const idUsuario = <?php echo $_SESSION['id_usuario']; ?>; // Obtener el ID del recepcionista desde la sesión
                const nuevo_estado = "Pagada";
                const idCita = $(this).data('id-cita'); 
                const metodo_pago = $('input[name="metodo_pago"]:checked').val();

                console.log('Datos obtenidos:');
                console.log('Monto: ', monto);
                console.log('Detalles: ', detalles);
                console.log('ID Recepcionista: ', idUsuario);
                console.log('Método de Pago: ', metodo_pago);
                console.log('ID Cita: ', idCita);

                // Verificar que idCita exista antes de enviar los datos
                if (!idCita) {
                    console.error('El ID de cita no está definido');
                    alert('Error: ID de cita no disponible');
                    return;
                }

                // Enviar solicitud para actualizar la cita
                $.ajax({
                    url: '/Gestion_Clinica/app/controllers/CitaController.php',
                    method: 'POST',
                    data: {
                        action: 'actualizar',
                        id_cita: idCita,
                        nuevo_estado: nuevo_estado
                    },
                    success: function(response) {
                        console.log('Respuesta de CitaController: ', response);

                        // Si la respuesta es exitosa, proceder con la generación de la factura
                        var jsonResponse = JSON.parse(response);
                        console.log(jsonResponse.status);
                        if (jsonResponse.status === 'success') {
                            // Proceder con la generación de la factura
                            $.ajax({
                                url: '/Gestion_Clinica/app/controllers/FacturaController.php',
                                method: 'POST',
                                data: {
                                    action: 'hacerCobro',
                                    monto: monto,
                                    detalles: detalles,
                                    id_cita: idCita,
                                    id_usuario: idUsuario,
                                    metodo_pago: metodo_pago
                                },
                                success: function(response) {
                                    console.log('Respuesta de FacturaController: ', response);
                                    var jsonResponseFactura = JSON.parse(response);
                                    if (jsonResponseFactura.status === 'success') {
                                        alert('Factura Generada Correctamente.');
                                        window.location.href = '/Gestion_Clinica/app/views/Recepcionista/menu_factura.php?id_factura=' + jsonResponseFactura.id_factura;
                                    } else {
                                        alert('Error al generar la factura: ' + jsonResponseFactura.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log('Error en la solicitud de factura:', error);
                                    alert('Hubo un error al generar la factura. Intenta de nuevo.');
                                }
                            });
                        } else {
                            alert('Error al actualizar la cita: ' + jsonResponse.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error en la solicitud AJAX:', error);
                        alert('Hubo un error en la solicitud. Intenta de nuevo.');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>