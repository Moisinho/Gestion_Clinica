<?php
session_start(); // Iniciar la sesión para obtener el ID del recepcionista

require_once '../includes/Database.php';
require_once '../models/Factura.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$database = new Database();
$conn = $database->getConnection();

$factura = new Factura($conn);

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'hacerCobro') {
        $monto = $_POST['monto'] ?? null;
        $detalles = $_POST['detalles'] ?? null;
        $idCita = $_POST['id_cita'] ?? null;
        $idUsuario = $_POST['id_usuario'] ?? null;
        $metodo_pago = $_POST['metodo_pago'] ?? null;
        $fecha_creacion = date('Y-m-d H:i:s');

        try {
            // Llamar a la función insertarFactura
            $facturaId = $factura->insertarFactura($monto, $fecha_creacion, $detalles, $idCita, $metodo_pago, $idUsuario);

            // Si la factura se insertó correctamente, responder con éxito
            echo json_encode(['status' => 'success', 'message' => 'Factura generada con éxito', 'id_factura' => $facturaId]);

        } catch (Exception $e) {
            // Si ocurre algún error, responder con el mensaje de error
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
} 
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] == 'facturaPorId' && isset($_GET['id_factura'])) {

        try {
            $factura_details = $factura->obtenerDetallesFactura($_GET['id_factura']);
            // Si se encuentran detalles de la factura, devolverlos en formato JSON
            echo json_encode(['status' => 'success', 'factura_details' => $factura_details]);
        } catch (Exception $e) {
            // Si ocurre algún error, devolver un mensaje de error
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Falta el parámetro id_factura']);
    }
} else {
    // Si la petición no es POST ni GET
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
?>