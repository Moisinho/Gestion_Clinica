<?php
require_once '../includes/Database.php';
require_once '../models/registro.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Identify user type
    $tipo_usuario = $_POST['tipo_usuario']; // This will be either 'medico' or 'paciente'
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena']; // Assuming password is submitted as well

    $registro = new Registro();

    $database = new Database();
    $conn = $database->getConnection();

    try {
    /************** DEBEMOS CREAR LA FUNCION PARA REGISTRAR MEDICO, RECEPCIONISTA 
     * Y ADMIN EN EL MODELO REGISTRO PARA TENER UN ORDEN, HASTA AHORA TENEMOS PACIENTE ****************/
        if ($tipo_usuario === 'medico') {
            // Insert into medico table
            $nombre_medico = $_POST['nombre_medico'];
            $id_hora = $_POST['id_hora'];
            $id_departamento = $_POST['id_departamento'];

            $queryMedico = "INSERT INTO medico (nombre_medico, correo_medico, id_hora, id_departamento, id_usuario) 
                            VALUES (:nombre_medico, :correo, :id_hora, :id_departamento, :id_usuario)";
            $stmtMedico = $conn->prepare($queryMedico);
            $stmtMedico->bindParam(':nombre_medico', $nombre_medico);
            $stmtMedico->bindParam(':correo', $correo);
            $stmtMedico->bindParam(':id_hora', $id_hora);
            $stmtMedico->bindParam(':id_departamento', $id_departamento);
            $stmtMedico->bindParam(':id_usuario', $id_usuario);
            $stmtMedico->execute();

        } elseif ($tipo_usuario === 'paciente') {
            //Ya existe una función para registrar paciente en el modelo registro.php, asi que la reutilizamos

            $cedula = $_POST['cedula'];
            $nombre_paciente = $_POST['nombre'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $direccion_paciente = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $sexo = $_POST['sexo'];
            $seguro = $_POST['seguro'];
            $seguro = $_POST['contrasenia'];

            $registro->registrarPaciente($cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $sexo, $seguro, $contrasenia);

        }

        // Commit transaction
        $conn->commit();
        echo "<script>alert('Usuario añadido exitosamente.'); window.location.href='/proyectos/Gestion_Clinica/app/views/admin_soli.php';</script>";
    } catch (PDOException $e) {
        // Rollback transaction in case of error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
