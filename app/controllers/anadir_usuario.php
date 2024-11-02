<?php
require_once '../includes/Database.php';
require_once '../models/registro.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_usuario = $_POST['tipo_usuario'];

    $database = new Database();
    $conn = $database->getConnection();
    $registro = new Registro($conn);

    try {
        if ($tipo_usuario === 'medico') {
            $nombre_medico = $_POST['nombre_medico'];
            $correo_medico = $_POST['correo_medico'];
            $contrasena_medico = $_POST['contrasena_medico'];
            $horario = $_POST['horario'];
            $departamento = $_POST['departamento'];

            if($horario === '08:00 - 12:00'){
                $id_hora = 1;
            }
            else if($horario === '13:00 - 17:00'){
                $id_hora = 2;
            }
            else if($horario === '09:00 - 14:00'){
                $id_hora = 3;
            }

            $query = "SELECT id_departamento FROM departamento WHERE nombre_departamento = :departamento";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':departamento', $departamento);
            $stmt->execute();
            
            $id_departamento = $stmt->fetch(PDO::FETCH_ASSOC)['id_departamento'];            

            

            $registro->registrarMedico($nombre_medico, $correo_medico, $contrasena_medico, $id_hora, $id_departamento);


        } elseif ($tipo_usuario === 'paciente') {
            $cedula = $_POST['cedula'];
            $nombre_paciente = $_POST['nombre'];
            $correo = $_POST['correo'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $direccion_paciente = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $sexo = $_POST['sexo'];
            $seguro = $_POST['seguro'];
            $contrasena = $_POST['contrasenia'];
            $source = $_POST['source'];

            $registro->registrarPaciente($cedula, $nombre_paciente, $correo, $fecha_nacimiento, $direccion_paciente, $telefono, $sexo, $seguro, $contrasena, $source);

        } elseif ($tipo_usuario === 'recepcionista') {
            $nombre_recepcionista = $_POST['nombre_recepcionista'];
            $correo_recepcionista = $_POST['correo_recepcionista'];
            $contrasena_recepcionista = $_POST['contrasena_recepcionista'];

            $registro->registrarRecepcionista($nombre_recepcionista, $correo_recepcionista, $contrasena_recepcionista);

        } elseif ($tipo_usuario === 'administrador') {
            $nombre_administrador = $_POST['nombre_administrador'];
            $correo_administrador = $_POST['correo_administrador'];
            $contrasena_administrador = $_POST['contrasena_administrador'];

            $registro->registrarAdministrador($nombre_administrador, $correo_administrador, $contrasena_administrador);
        }
        
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
