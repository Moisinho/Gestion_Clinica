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

        // Redirigir a la página de éxito o resumen
        header("Location: pagina_exito.php"); // Cambia 'pagina_exito.php' por la URL de la página de destino
        exit(); // Asegúrate de detener el script después de la redirección

    } catch (Exception $e) {
        echo $e->getMessage(); // Manejo de errores
    }
} else {
    echo "No se encontraron datos del paciente para el id_cita: " . $id_cita;
}

// No necesitas cerrar $stmt
$conn = null; // Esto cerrará la conexión si es necesario
?>