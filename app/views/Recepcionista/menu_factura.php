<?php 
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /Gestion_clinica/index.php');
    exit();
}
require_once '../../includes/Database.php';
require_once '../../models/Factura.php';

$database = new Database();
$conn = $database->getConnection();
$factura = new Factura($conn);
$id_factura = isset($_GET['id_factura']) ? $_GET['id_factura'] : null;
$factura_details = null;
if ($id_factura) {
    $factura_details = $factura->obtenerDetallesFactura($id_factura);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center h-screen bg-gray-200">
<div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-2xl font-bold mb-4 text-center">Factura</h2>
    <p class="mb-2"><strong>ID Factura:</strong> <?php echo isset($factura_details['id_factura']) ? $factura_details['id_factura'] : 'N/A'; ?></p>
    <p class="mb-2"><strong>Nombre Paciente:</strong> <?php echo isset($factura_details['nombre_paciente']) ? $factura_details['nombre_paciente'] : 'N/A'; ?></p>
    <p class="mb-2"><strong>Correo:</strong> <?php echo isset($factura_details['correo_paciente']) ? $factura_details['correo_paciente'] : 'N/A'; ?></p>
    <p class="mb-2"><strong>Teléfono:</strong> <?php echo isset($factura_details['telefono']) ? $factura_details['telefono'] : 'N/A'; ?></p>
    <p class="mb-2"><strong>Monto:</strong> <?php echo isset($factura_details['monto']) ? $factura_details['monto'] : 'N/A'; ?></p>
    <p class="mb-2"><strong>Detalles:</strong> <?php echo isset($factura_details['detalles_factura']) ? $factura_details['detalles_factura'] : 'N/A'; ?></p>
    <p class="mb-2"><strong>Fecha de Creación:</strong> <?php echo isset($factura_details['fecha_creacion']) ? $factura_details['fecha_creacion'] : 'N/A'; ?></p>

    <div class="mt-4 text-center">
        <p class="text-green-600 text-lg">¡Cobro realizado con éxito!</p>
        <a href="/Gestion_clinica/home_recepcionista" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-500 transition">Volver</a>
    </div>
</div>

</body>
</html>
