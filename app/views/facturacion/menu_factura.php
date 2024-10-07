<?php
// Incluir la clase Database y Factura
require_once '../../includes/Database.php';
require_once '../../models/Factura.php';
require_once '../../models/Cita.php';

// Crear instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Crear la instancia de Factura
$factura = new Factura($conn);
$cita = new Cita($conn);

// Recoger datos del formulario
$id_cita = $_POST['id_cita'];
$monto = $_POST['monto_tarjeta'] ?? $_POST['monto_efectivo']; // Usar el monto según el método de pago
$detalles_factura = $_POST['detalles_tarjeta'] ?? $_POST['detalles_efectivo'];
$fecha_creacion = date('Y-m-d H:i:s');
$metodo_pago = $_POST['metodo_pago'];
// Obtener datos del paciente según el id_cita
$sql_paciente = "
    SELECT p.nombre_paciente, p.correo_paciente, p.telefono 
    FROM paciente p
    JOIN cita c ON p.cedula = c.cedula
    WHERE c.id_cita = :id_cita"; // Usar un marcador de posición nombrado

$stmt = $conn->prepare($sql_paciente);
$stmt->bindValue(':id_cita', $id_cita, PDO::PARAM_INT); // Usar bindValue
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Recuperar todos los resultados

if (count($result) > 0) { // Cambia a count para verificar resultados
    // Obtener los datos del paciente
    $row = $result[0]; // Acceder al primer elemento del array
    $nombre_paciente = $row['nombre_paciente'];
    $correo_paciente = $row['correo_paciente'];
    $telefono = $row['telefono'];

    try {
        // Insertar la factura
        $id_factura = $factura->insertarFactura($monto, $fecha_creacion, $detalles_factura, $id_cita, $nombre_paciente, $correo_paciente, $telefono, $metodo_pago);
        
        // Obtener los detalles de la factura insertada
        $factura_details = $factura->obtenerDetallesFactura($id_factura);
        
        // Actualizar el estado de la cita a 'Pagada'
        $cita_actualizada = $cita->actualizarEstadoCita($id_cita, 'Pagada');
        
        // Mensaje de éxito
        $mensaje = "¡Cobro realizado con éxito!";

    } catch (Exception $e) {
        echo $e->getMessage(); // Manejo de errores
    }
} else {
    echo "No se encontraron datos del paciente para el id_cita: " . $id_cita;
}

// No necesitas cerrar $stmt
$conn = null; // Esto cerrará la conexión si es necesario
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
    <p class="mb-2"><strong>ID Factura:</strong> <?php echo isset($factura_details['id_factura']) ? $factura_details['id_factura'] : ''; ?></p>
    <p class="mb-2"><strong>Nombre Paciente:</strong> <?php echo isset($factura_details['nombre_paciente']) ? $factura_details['nombre_paciente'] : ''; ?></p>
    <p class="mb-2"><strong>Correo:</strong> <?php echo isset($factura_details['correo_paciente']) ? $factura_details['correo_paciente'] : ''; ?></p>
    <p class="mb-2"><strong>Teléfono:</strong> <?php echo isset($factura_details['telefono']) ? $factura_details['telefono'] : ''; ?></p>
    <p class="mb-2"><strong>Monto:</strong> <?php echo isset($factura_details['monto']) ? $factura_details['monto'] : ''; ?></p>
    <p class="mb-2"><strong>Detalles:</strong> <?php echo isset($factura_details['detalles_factura']) ? $factura_details['detalles_factura'] : ''; ?></p>
    <p class="mb-2"><strong>Fecha de Creación:</strong> <?php echo isset($factura_details['fecha_creacion']) ? $factura_details['fecha_creacion'] : ''; ?></p>

    <div class="mt-4 text-center">
        <p class="text-green-600 text-lg"><?php echo isset($mensaje) ? $mensaje : ''; ?></p>
        <a href="./facturacion_cita.php" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-500 transition">Volver</a>
    </div>
</div>

</body>
</html>
