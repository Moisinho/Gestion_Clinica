<?php

class Registro {
    private $conn;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para registrar un nuevo usuario PD: Esto es para que lo redirija a la página de usuario
    public function registrarPaciente($cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $sexo, $seguro, $contrasenia, $source) {
        // Calcular la edad
        $fecha_actual = new DateTime();
        $fecha_nac = new DateTime($fecha_nacimiento);
        $edad = $fecha_actual->diff($fecha_nac)->y;


        try {
            // Iniciar una transacción
            $this->conn->beginTransaction();

            // Hashear la contraseña
            $contraseniaHashed = password_hash($contrasenia, PASSWORD_DEFAULT);

            // Insertar en la tabla usuario
            $sqlUsuario = "INSERT INTO usuario (correo, tipo_usuario, contrasenia) VALUES (?, 'Paciente', ?)";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$correo, $contraseniaHashed]);
            $id_usuario = $this->conn->lastInsertId(); // Obtener el ID del usuario insertado

            // Obtener el id_seguro a partir del nombre de la aseguradora
            $sqlSeguro = "SELECT id_seguro FROM seguro WHERE nombre_aseguradora = ?";
            $stmtSeguro = $this->conn->prepare($sqlSeguro);
            $stmtSeguro->execute([$seguro]);
            $resultadoSeguro = $stmtSeguro->fetch(PDO::FETCH_ASSOC);

            if (!$resultadoSeguro) {
                throw new Exception("No se encontró el seguro seleccionado.");
            }
            $id_seguro = $resultadoSeguro['id_seguro']; // Obtener el id_seguro

            // Preparar la consulta para insertar en paciente
            $sqlPaciente = "INSERT INTO paciente (cedula, nombre_paciente, correo_paciente, fecha_nacimiento, direccion_paciente, telefono, edad, id_usuario, sexo, id_seguro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaciente = $this->conn->prepare($sqlPaciente);
            $stmtPaciente->execute([$cedula, $nombre, $correo, $fecha_nacimiento, $direccion, $telefono, $edad, $id_usuario, $sexo, $id_seguro]);



            // Confirmar la transacción
            $this->conn->commit();

            if($source === 'registro_principal'){
                // Iniciar sesión y almacenar información del usuario
                session_start(); // Llamar a session_start() aquí, después del éxito del registro
                $_SESSION['id_usuario'] = $id_usuario; // Almacena el ID del usuario
                $_SESSION['nombre'] = $nombre; // Almacena el nombre del usuario

                $destino = "/Gestion_clinica/home_paciente";
                header("Location: /Gestion_clinica/exito?nombre=" . urlencode($nombre) . "&destino=" . urlencode($destino));
                exit();
            }
            else if($source === 'registro_admin'){
                echo "<script>alert('Registro exitoso del paciente: $nombre.');
                window.location.href = '/Gestion_clinica/gestion_usuarios';</script>";
            }
        } catch (Exception $e) {
            // Revertir la transacción si ocurre un error
            $this->conn->rollBack();
            echo "Error en el registro: " . $e->getMessage();
        }
    }

    public function registrarMedico($nombre_medico, $correo_medico, $contrasena_medico, $id_hora, $id_departamento) {
        try {
            // Iniciar una transacción
            $this->conn->beginTransaction();

            // Hashear la contraseña
            $contraseniaHashed = password_hash($contrasena_medico, PASSWORD_DEFAULT);

            // Insertar en la tabla usuario
            $sqlUsuario = "INSERT INTO usuario (correo, tipo_usuario, contrasenia) VALUES (?, 'Médico', ?)";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$correo_medico, $contraseniaHashed]);
            $id_usuario = $this->conn->lastInsertId(); // Obtener el ID del usuario insertado

            // Preparar la consulta para insertar en medico
            $sqlMedico = "INSERT INTO medico (nombre_medico, correo_medico, id_hora, id_departamento, id_usuario) VALUES (?, ?, ?, ?, ?)";
            $stmtMedico = $this->conn->prepare($sqlMedico);
            $stmtMedico->execute([$nombre_medico, $correo_medico, $id_hora, $id_departamento, $id_usuario]);

            // Confirmar la transacción
            $this->conn->commit();

            echo "<script>alert('Registro exitoso del medico: $nombre_medico.');
            window.location.href = '/Gestion_clinica/gestion_usuarios';</script>";

        } catch (Exception $e) {
            // Revertir la transacción si ocurre un error
            $this->conn->rollBack();
            echo "Error en el registro: " . $e->getMessage();
        }
    }

    public function registrarRecepcionista($nombre_recepcionista, $correo_recepcionista, $contrasena_recepcionista) {
        try {
            // Iniciar una transacción
            $this->conn->beginTransaction();

            // Hashear la contraseña
            $contraseniaHashed = password_hash($contrasena_recepcionista, PASSWORD_DEFAULT);

            // Insertar en la tabla usuario
            $sqlUsuario = "INSERT INTO usuario (correo, tipo_usuario, contrasenia) VALUES (?, 'Recepcionista', ?)";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$correo_recepcionista, $contraseniaHashed]);
            $id_usuario = $this->conn->lastInsertId(); // Obtener el ID del usuario insertado

            // Preparar la consulta para insertar en medico
            $sqlRecepcionista = "INSERT INTO recepcionista (nombre_recepcionista, correo_recepcionista, id_usuario) VALUES (?, ?, ?)";
            $stmtRecepcionista = $this->conn->prepare($sqlRecepcionista);
            $stmtRecepcionista->execute([$nombre_recepcionista, $correo_recepcionista, $id_usuario]);

            // Confirmar la transacción
            $this->conn->commit();

            echo "<script>alert('Registro exitoso del recepcionista: $nombre_recepcionista.');
            window.location.href = '/Gestion_clinica/gestion_usuarios';</script>";

        } catch (Exception $e) {
            // Revertir la transacción si ocurre un error
            $this->conn->rollBack();
            echo "Error en el registro: " . $e->getMessage();
        }
    }

    public function registrarAdministrador($nombre_administrador, $correo_administrador, $contrasena_administrador) {
        try {
            // Iniciar una transacción
            $this->conn->beginTransaction();

            // Hashear la contraseña
            $contraseniaHashed = password_hash($contrasena_administrador, PASSWORD_DEFAULT);

            // Insertar en la tabla usuario
            $sqlUsuario = "INSERT INTO usuario (correo, tipo_usuario, contrasenia) VALUES (?, 'Administrador', ?)";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$correo_administrador, $contraseniaHashed]);
            $id_usuario = $this->conn->lastInsertId(); // Obtener el ID del usuario insertado


            $sqlAdministrador = "INSERT INTO administrador (nombre_admin, correo_admin, id_usuario) VALUES (?, ?, ?)";
            $stmtAdministrador = $this->conn->prepare($sqlAdministrador);
            $stmtAdministrador->execute([$nombre_administrador, $correo_administrador, $id_usuario]);

            // Confirmar la transacción
            $this->conn->commit();

            echo "<script>alert('Registro exitoso del administrador: $nombre_administrador.');
            window.location.href = '/Gestion_clinica/gestion_usuarios';</script>";

        } catch (Exception $e) {
            // Revertir la transacción si ocurre un error
            $this->conn->rollBack();
            echo "Error en el registro: " . $e->getMessage();
        }
    }
    public function registrarFarmaceutico($nombre_farmaceutico, $correo_farmaceutico, $contrasena_farmaceutico) {
        try {
            // Iniciar una transacción
            $this->conn->beginTransaction();

            // Hashear la contraseña
            $contraseniaHashed = password_hash($contrasena_farmaceutico, PASSWORD_DEFAULT);

            // Insertar en la tabla usuario
            $sqlUsuario = "INSERT INTO usuario (correo, tipo_usuario, contrasenia) VALUES (?, 'Farmaceutico', ?)";
            $stmtUsuario = $this->conn->prepare($sqlUsuario);
            $stmtUsuario->execute([$correo_farmaceutico, $contraseniaHashed]);
            $id_usuario = $this->conn->lastInsertId(); // Obtener el ID del usuario insertado


            $sqlFarmaceutico = "INSERT INTO farmaceutico (nombre_farmaceutico, correo_farmaceutico, id_usuario) VALUES (?, ?, ?)";
            $stmtFarmaceutico = $this->conn->prepare($sqlFarmaceutico);
            $stmtFarmaceutico->execute([$nombre_farmaceutico, $correo_farmaceutico, $id_usuario]);

            // Confirmar la transacción
            $this->conn->commit();

            echo "<script>alert('Registro exitoso del Farmaceutico: $nombre_farmaceutico.');
            window.location.href = '/Gestion_clinica/gestion_usuarios';</script>";

        } catch (Exception $e) {
            // Revertir la transacción si ocurre un error
            $this->conn->rollBack();
            echo "Error en el registro: " . $e->getMessage();
        }
    }
}
?>
