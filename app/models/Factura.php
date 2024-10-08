<?php
class Factura {
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
    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertarFactura($monto, $fecha_creacion, $detalles_factura, $id_cita, $nombre_paciente, $correo_paciente, $telefono, $metodo_pago) {
        // Aquí va tu consulta SQL para insertar la factura
        $sql = "INSERT INTO factura (monto, fecha_creacion, detalles_factura, id_cita, nombre_paciente, correo_paciente, telefono, metodo_pago) 
                VALUES (:monto, :fecha_creacion, :detalles_factura, :id_cita, :nombre_paciente, :correo_paciente, :telefono, :metodo_pago)";

        // Preparar la sentencia
        $stmt = $this->conn->prepare($sql);
        
        // Enlazar parámetros
        $stmt->bindValue(':monto', $monto, PDO::PARAM_STR);
        $stmt->bindValue(':fecha_creacion', $fecha_creacion, PDO::PARAM_STR);
        $stmt->bindValue(':detalles_factura', $detalles_factura, PDO::PARAM_STR);
        $stmt->bindValue(':id_cita', $id_cita, PDO::PARAM_INT);
        $stmt->bindValue(':nombre_paciente', $nombre_paciente, PDO::PARAM_STR);
        $stmt->bindValue(':correo_paciente', $correo_paciente, PDO::PARAM_STR);
        $stmt->bindValue(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindValue(':metodo_pago', $metodo_pago, PDO::PARAM_STR);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener el ID de la factura insertada
            return $this->conn->lastInsertId();
        } else {
            throw new Exception("Error al insertar la factura");
        }
    }
    
    public function obtenerDetallesFactura($id_factura) {
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
}
?>
