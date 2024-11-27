<?php
class Factura
{
    private $conn; // Conexión a la base de datos
    private $table_name = "factura"; // Nombre de la tabla

    // Propiedades de la clase
    public $id_factura;
    public $monto;
    public $fecha_creacion;
    public $detalles_factura;
    public $id_cita;
    public $nombre_paciente;
    public $correo_paciente;
    public $telefono;
    public $metodo_pago;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function insertarFactura($monto, $fecha_creacion, $detalles_factura, $id_cita, $metodo_pago, $id_usuario)
    {
        // Obtener el id_recepcionista a partir del id_usuario
        $sql_recepcionista = "SELECT id_recepcionista FROM recepcionista WHERE id_usuario = :id_usuario";
        $stmt_recepcionista = $this->conn->prepare($sql_recepcionista);
        $stmt_recepcionista->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt_recepcionista->execute();

        if ($stmt_recepcionista->rowCount() > 0) {
            $id_recepcionista = $stmt_recepcionista->fetch(PDO::FETCH_ASSOC)['id_recepcionista'];
        } else {
            throw new Exception("No se encontró el recepcionista para el ID de usuario proporcionado.");
        }

        // Obtener la cédula del paciente a partir del id_cita
        $sql_cita = "SELECT cedula FROM cita WHERE id_cita = :id_cita";
        $stmt_cita = $this->conn->prepare($sql_cita);
        $stmt_cita->bindValue(':id_cita', $id_cita, PDO::PARAM_INT);
        $stmt_cita->execute();

        if ($stmt_cita->rowCount() > 0) {
            $cedula = $stmt_cita->fetch(PDO::FETCH_ASSOC)['cedula'];

            // Buscar datos del paciente
            $sql_paciente = "SELECT nombre_paciente, correo_paciente, telefono FROM paciente WHERE cedula = :cedula";
            $stmt_paciente = $this->conn->prepare($sql_paciente);
            $stmt_paciente->bindValue(':cedula', $cedula, PDO::PARAM_STR);
            $stmt_paciente->execute();

            if ($stmt_paciente->rowCount() > 0) {
                $paciente = $stmt_paciente->fetch(PDO::FETCH_ASSOC);
                $nombre_paciente = $paciente['nombre_paciente'];
                $correo_paciente = $paciente['correo_paciente'];
                $telefono = $paciente['telefono'];
            } else {
                throw new Exception("No se encontró el paciente con esa cédula.");
            }
        } else {
            throw new Exception("No se encontró la cita con ese ID.");
        }

        // Insertar la factura
        $sql_factura = "INSERT INTO factura (monto, fecha_creacion, detalles_factura, nombre_paciente, correo_paciente, telefono, metodo_pago, id_cita, id_recepcionista) 
                        VALUES (:monto, :fecha_creacion, :detalles_factura, :nombre_paciente, :correo_paciente, :telefono, :metodo_pago, :id_cita, :id_recepcionista)";
        $stmt_factura = $this->conn->prepare($sql_factura);
        $stmt_factura->bindValue(':monto', $monto, PDO::PARAM_STR);
        $stmt_factura->bindValue(':fecha_creacion', $fecha_creacion, PDO::PARAM_STR);
        $stmt_factura->bindValue(':detalles_factura', $detalles_factura, PDO::PARAM_STR);
        $stmt_factura->bindValue(':nombre_paciente', $nombre_paciente, PDO::PARAM_STR);
        $stmt_factura->bindValue(':correo_paciente', $correo_paciente, PDO::PARAM_STR);
        $stmt_factura->bindValue(':telefono', $telefono, PDO::PARAM_STR);
        $stmt_factura->bindValue(':metodo_pago', $metodo_pago, PDO::PARAM_STR);
        $stmt_factura->bindValue(':id_cita', $id_cita, PDO::PARAM_STR);
        $stmt_factura->bindValue(':id_recepcionista', $id_recepcionista, PDO::PARAM_STR);

        // Ejecutar la sentencia
        if ($stmt_factura->execute()) {
            // Obtener el ID de la factura recién insertada
            $factura_id = $this->conn->lastInsertId();

            $this->enviarCorreoFactura($factura_id);

            return $factura_id; // Devuelve al final después de enviar el correo
        } else {
            throw new Exception("Error al insertar la factura");
        }
    }

    public function obtenerDetallesFactura($id_factura)
    {
        // Recuperar la factura para mostrarla
        $sql_factura_details = "SELECT * FROM factura WHERE id_factura = :id_factura";
        $stmt_factura_details = $this->conn->prepare($sql_factura_details);

        // Usar bindValue en lugar de bind_param
        $stmt_factura_details->bindValue(':id_factura', $id_factura, PDO::PARAM_INT);
        $stmt_factura_details->execute();

        $result_factura = $stmt_factura_details->fetchAll(PDO::FETCH_ASSOC); // Cambiar a fetchAll para obtener los resultados

        if (count($result_factura) > 0) {
            return $result_factura[0]; // Retornar los detalles de la factura
        } else {
            throw new Exception("No se encontró la factura con ID: $id_factura");
        }
    }

    public function obtenerIngresosRecientes()
    {
        $query = "SELECT SUM(monto) as ingresos_recientes 
              FROM factura 
              WHERE fecha_creacion >= CURDATE() - INTERVAL 20 DAY";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['ingresos_recientes'] ?? 0;
    }

    public function enviarCorreoFactura($id_factura)
    {
        $infoFactura = $this->obtenerDetallesFactura($id_factura);

        if (!$infoFactura) {
            echo "<script>alert('No se pudo obtener la información de la factura.');</script>";
            return false;
        }

        $asunto = 'Factura de su Ultima Cita';

        // Mensaje HTML estilizado
        $mensaje = "
        <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto;'>
            <h1 style='text-align: center; color: #4c1d95;'>Detalles de la Factura</h1>
            <p style='font-size: 16px;'>Estimado(a) <strong>{$infoFactura['nombre_paciente']}</strong>,</p>
            <p>Gracias por confiar en nuestros servicios. A continuación, encontrará los detalles de su factura:</p>
            <div style='background-color: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);'>
                <p><strong>ID Factura:</strong> {$infoFactura['id_factura']}</p>
                <p><strong>Nombre del Paciente:</strong> {$infoFactura['nombre_paciente']}</p>
                <p><strong>Correo:</strong> {$infoFactura['correo_paciente']}</p>
                <p><strong>Teléfono:</strong> {$infoFactura['telefono']}</p>
                <p><strong>Fecha:</strong> {$infoFactura['fecha_creacion']}</p>
                <p><strong>Monto:</strong> {$infoFactura['monto']}</p>
                <p><strong>Método de Pago:</strong> {$infoFactura['metodo_pago']}</p>
                <p><strong>Detalles:</strong> {$infoFactura['detalles_factura']}</p>
            </div>
            <p style='font-size: 16px;'>Por favor, no dude en contactarnos si tiene alguna pregunta o necesita más información.</p>
            <p style='text-align: center; font-size: 14px; color: #888;'>Este correo se generó automáticamente. Por favor, no responda a este mensaje.</p>
        </div>
        ";

        require_once '../helpers/correo.php';

        return enviarCorreoSMTP($infoFactura['correo_paciente'], $asunto, $mensaje);
    }
}
