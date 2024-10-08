<?php
// Incluir la clase Database y Factura
require_once '../includes/Database.php';
require_once '../models/Factura.php';
require_once '../models/Cita.php';

// Crear instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

// Crear la instancia de Factura y Cita
$factura = new Factura($conn);
$cita = new Cita($conn);

// Recoger datos del formulario
$id_cita = $_POST['id_cita'];

// Validar el método de pago y seleccionar el monto adecuado
if (isset($_POST['metodo_pago'])) {
    $metodo_pago = $_POST['metodo_pago'];

    // Verificar qué monto usar según el método de pago
    if ($metodo_pago === 'tarjeta') {
        $monto = $_POST['monto_tarjeta'];
        $detalles_factura = $_POST['detalles_tarjeta'];
    } elseif ($metodo_pago === 'efectivo') {
        $monto = $_POST['monto_efectivo'];
        $detalles_factura = $_POST['detalles_efectivo'];
    } else {
        die("Método de pago no válido.");
    }

    // Validar que el monto sea un número y no esté vacío
    if (empty($monto) || !is_numeric($monto) || $monto <= 0) {
        die("Error: El monto no puede estar vacío, ser menor o igual a cero, y debe ser un número válido.");
    }
} else {
    die("Error: El método de pago no ha sido seleccionado.");
}

// Definir la fecha de creación de la factura
$fecha_creacion = date('Y-m-d H:i:s');

// Obtener datos del paciente según el id_cita
$sql_paciente = "
    SELECT p.nombre_paciente, p.correo_paciente, p.telefono 
    FROM paciente p
    JOIN cita c ON p.cedula = c.cedula
    WHERE c.id_cita = :id_cita";

$stmt = $conn->prepare($sql_paciente);
$stmt->bindValue(':id_cita', $id_cita, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($result) > 0) {
    // Obtener los datos del paciente
    $row = $result[0];
    $nombre_paciente = $row['nombre_paciente'];
    $correo_paciente = $row['correo_paciente'];
    $telefono = $row['telefono'];

    try {
        // Insertar la factura
        $id_factura = $factura->insertarFactura($monto, $fecha_creacion, $detalles_factura, $id_cita, $nombre_paciente, $correo_paciente, $telefono, $metodo_pago);
        
        // Actualizar el estado de la cita a 'Pagada'
        $cita_actualizada = $cita->actualizarEstado($id_cita, 'Pagada');
        
        // Redirigir a menu_factura.php pasando el id_factura en la URL
        header("Location: ../views/facturacion/menu_factura.php?id_factura=$id_factura");
        exit(); // Asegúrate de detener el script después de la redirección

    } catch (Exception $e) {
        echo $e->getMessage(); // Manejo de errores
    }
} else {
    echo "No se encontraron datos del paciente para el id_cita: " . $id_cita;
}

$conn = null; // Esto cerrará la conexión si es necesario
?>
