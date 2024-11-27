<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /Gestion_clinica/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="flex justify-center items-center h-screen bg-purple-100">
    <div class="bg-white p-8 rounded-xl shadow-xl w-[36rem]">
        <h2 class="text-4xl font-extrabold mb-8 text-center text-purple-800">Detalles de la Factura</h2>

        <!-- Aquí se mostrarán los datos de la factura -->
        <div id="factura-details" class="space-y-6">
            <p class="text-black font-bold text-lg"><strong class="text-purple-700">ID Factura:</strong> <span id="id_factura">N/A</span></p>
            <p class="text-black font-bold text-lg"><strong class="text-purple-700">Nombre del Paciente:</strong> <span id="nombre_paciente">N/A</span></p>
            <p class="text-black font-bold text-lg"><strong class="text-purple-700">Correo:</strong> <span id="correo_paciente">N/A</span></p>
            <p class="text-black font-bold text-lg"><strong class="text-purple-700">Teléfono:</strong> <span id="telefono">N/A</span></p>
            <p class="text-black font-bold text-lg"><strong class="text-purple-700">Monto:</strong> <span id="monto">N/A</span></p>
            <p class="text-black font-bold text-lg"><strong class="text-purple-700">Método de Pago:</strong> <span id="metodo_pago">N/A</span></p>
            <p class="text-black font-bold text-lg"><strong class="text-purple-700">Detalles:</strong> <span id="detalles_factura">N/A</span></p>
            <p class="text-black font-bold text-lg"><strong class="text-purple-700">Fecha de Creación:</strong> <span id="fecha_creacion">N/A</span></p>
        </div>

        <!-- Mensaje de confirmación y botón para volver -->
        <div class="mt-8 text-center">
            <p class="text-green-700 font-bold text-xl">¡Cobro realizado con éxito!</p>
            <a href="/Gestion_clinica/home_recepcionista" class="mt-6 inline-block bg-purple-700 text-white py-3 px-8 text-lg rounded-lg shadow-lg hover:bg-purple-600 transition-all">
                Volver
            </a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Obtener el id_factura desde el URL (pasado como parámetro GET)
            var facturaId = new URLSearchParams(window.location.search).get('id_factura');

            if (facturaId) {
                // Llamada AJAX para obtener los detalles de la factura
                $.ajax({
                    url: '/Gestion_Clinica/app/controllers/FacturaController.php',
                    type: 'GET',
                    data: {
                        action: 'facturaPorId',
                        id_factura: facturaId
                    },
                    success: function(response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }

                        if (response.status === 'success') {
                            var facturaDetails = response.factura_details;

                            // Mostrar los detalles de la factura en el HTML
                            $('#id_factura').text(facturaDetails.id_factura);
                            $('#nombre_paciente').text(facturaDetails.nombre_paciente);
                            $('#correo_paciente').text(facturaDetails.correo_paciente);
                            $('#telefono').text(facturaDetails.telefono);
                            $('#monto').text(facturaDetails.monto);
                            $('#metodo_pago').text(facturaDetails.metodo_pago);
                            $('#detalles_factura').text(facturaDetails.detalles_factura);
                            $('#fecha_creacion').text(facturaDetails.fecha_creacion);
                        } else {
                            $('#factura-details').html('<p class="text-red-600 text-center text-lg">No se encontró la factura.</p>');
                        }
                    },
                    error: function() {
                        alert('Error al obtener los detalles de la factura.');
                    }
                });
            } else {
                alert('No se ha proporcionado un ID de factura.');
            }
        });
    </script>
</body>
</html>
