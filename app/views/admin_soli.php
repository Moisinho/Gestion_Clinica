<?php
include '../includes/Database.php';

$db = new Database();
$conn = $db->getConnection();

$query_horario = "CALL ObtenerHorarios()";
$query_departamento = "SELECT DISTINCT nombre_departamento from departamento";
$query_seguro = "SELECT DISTINCT nombre_aseguradora FROM seguro";

try {
    $stmt = $conn->prepare($query_horario);
    $stmt->execute();
    $horarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener horarios

    $stmt = $conn->prepare($query_departamento);
    $stmt->execute();
    $departamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);//Obtener departamentos

    $stmt = $conn->prepare($query_seguro);
    $stmt->execute();
    $aseguradoras = $stmt->fetchAll(PDO::FETCH_ASSOC); //Obtener aseguradoras

    $tipo_usuario = isset($_GET['tipo_usuario']) ? $_GET['tipo_usuario'] : ''; 
    $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

    $columnNames = [];

    if ($tipo_usuario) {
        // Selecciona la tabla según el tipo de usuario
        switch ($tipo_usuario) {
            case 'paciente':
                $query = "SELECT * FROM paciente WHERE nombre_paciente LIKE :buscar LIMIT 1";
                break;
            case 'medico':
                $query = "SELECT * FROM medico WHERE nombre_medico LIKE :buscar LIMIT 1";
                break;
            case 'recepcionista':
                $query = "SELECT * FROM recepcionista WHERE nombre_recepcionista LIKE :buscar LIMIT 1";
                break;
            case 'administrador':
                $query = "SELECT * FROM administrador WHERE nombre_admin LIKE :buscar LIMIT 1";
                break;
            default:
                $query = "";
                break;
        }

        // Obtener los encabezados de columna
        if ($query) {
            $stmt = $conn->prepare($query);
            $buscar_param = "%" . $buscar . "%";
            $stmt->bindParam(':buscar', $buscar_param, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $columnNames = array_keys($stmt->fetch(PDO::FETCH_ASSOC)); // Obtiene los nombres de columnas
            }
        }
    }

} catch(PDOException $exception) {
    echo "Error al ejecutar la consulta: " . $exception->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Clínico - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col">

<?php include 'C:\xampp\htdocs\Gestion_Clinica\app\includes\header_sesion.php'; ?>

    <!-- Contenido principal -->
    <div class="container mx-auto p-5 flex-grow">
        <div class="bg-purple-300 p-5 rounded-lg shadow-md mt-8">
            <!-- Barra de búsqueda y botón de añadir -->
            <form method="GET" action="">
                <div class="flex items-center space-x-3">
                    <input type="text" name="buscar" placeholder="Buscar..." class="ml-5 w-full max-w-4xl px-4 py-2 rounded-lg border border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    
                    <select name="tipo_usuario" id="tipo_usuario" class="w-32 border border-gray-300 rounded shadow-md p-2" onchange="this.form.submit();">
                        <option value="">Selecciona...</option>     
                        <option value="paciente" <?php echo (isset($_GET['tipo_usuario']) && $_GET['tipo_usuario'] == 'paciente') ? 'selected' : ''; ?>>Pacientes</option>
                        <option value="medico" <?php echo (isset($_GET['tipo_usuario']) && $_GET['tipo_usuario'] == 'medico') ? 'selected' : ''; ?>>Médicos</option>
                        <option value="recepcionista" <?php echo (isset($_GET['tipo_usuario']) && $_GET['tipo_usuario'] == 'recepcionista') ? 'selected' : ''; ?>>Recepcionistas</option>
                        <option value="administrador" <?php echo (isset($_GET['tipo_usuario']) && $_GET['tipo_usuario'] == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                    </select>

                    <!-- Botón de añadir -->
                    <button type="button" class="bg-purple-600 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-purple-700" onclick="openModal()">
                        Añadir
                    </button>
                </div>
            </form>

            <div class="bg-white p-5 rounded-lg shadow-md mr-4 ml-4 mt-4 overflow-y-auto h-[50vh]">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                        <?php
                            // Mostrar los encabezados dinámicamente
                            foreach ($columnNames as $column) {
                                echo "<th class='px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider'>{$column}</th>";
                            }
                        ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                        // Ejecutar la consulta completa para obtener los datos de la tabla seleccionada
                        if ($tipo_usuario) {
                            $query = str_replace("LIMIT 1", "", $query); // Elimina el LIMIT 1 para obtener todos los resultados
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':buscar', $buscar_param, PDO::PARAM_STR);

                            if ($stmt->execute()) {
                                // Mostrar los datos en la tabla
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    foreach ($columnNames as $column) {
                                        echo "<td class='px-6 text-center py-4 whitespace-nowrap text-sm text-gray-900'>{$row[$column]}</td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='".count($columnNames)."' class='text-center text-red-500'>Error en la ejecución de la consulta.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>Selecciona un tipo de usuario para ver los datos.</td></tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white h-3/4 p-6 rounded-lg shadow-lg max-w-md w-full relative overflow-y-auto">
            <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="closeModal()">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Añadir nuevo usuario</h2>
            
           <!-- Formulario dentro del modal -->
                
                <label class="block mb-2">Tipo de Usuario: </label>
                <select name="select_opcion" onchange="formOption()" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="" disabled selected>Seleccione un usuario</option>
                    <option id="op_paciente" value="paciente">Paciente</option>
                    <option id="op_medico" value="medico">Médico</option>
                    <option id="op_recepcionista" value="recepcionista">Recepcionista</option>
                    <option id="op_administrador" value="administrador">Administrador</option>
                </select>

            <form action="http://localhost/Gestion_Clinica/app/controllers/anadir_usuario.php" method="POST">
                <input type="hidden" name="tipo_usuario" id="tipo_usuario_hidden" value="paciente">
                <input type="hidden" name="source" value="registro_admin"><!--Identificador para el método registrarPaciente-->
                <!-- Formulario para paciente -->
                <div id="form_paciente" class="modal hidden">
                    <label class="block mb-2">Correo:</label>
                    <input type="email" name="correo" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el correo" required>

                    <label class="block mb-2">Contraseña:</label>
                    <input type="password" name="contrasena" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa la contraseña" required>

                    <label class="block mb-2">Cédula:</label>
                    <input type="text" name="cedula" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa la cédula" required>

                    <label class="block mb-2">Nombre Completo:</label>
                    <input type="text" name="nombre" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el nombre" required>

                    <label class="block mb-2">Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nacimiento" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa la fecha de nacimiento" required>

                    <label class="block mb-2">Dirección:</label>
                    <input type="text" name="direccion" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa la dirección" required>

                    <label class="block mb-2">Teléfono:</label>
                    <input type="number" name="telefono" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa su telefono" required>

                    <label for="sexo" class="block mb-2">Sexo:</label>
                    <select name="sexo" id="sexo" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                    </select>

                    <label for="seguro" class="block mb-2">Seguro:</label>
                    <select name="seguro" id="seguro" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <?php
                    // Llenar el select con las aseguradoras obtenidas
                    foreach ($aseguradoras as $aseguradora) {
                        echo '<option value="' . htmlspecialchars($aseguradora['nombre_aseguradora']) . '">' . htmlspecialchars($aseguradora['nombre_aseguradora']) . '</option>';
                    }
                    ?>
                </select>
                    <button type="submit" class="bg-purple-600 text-white font-semibold px-4 py-2 mt-8 rounded-lg shadow hover:bg-purple-700">Guardar</button>
                </div>
            </form>


                <!-- Formulario para médico -->
            <form action="http://localhost/Gestion_Clinica/app/controllers/anadir_usuario.php" method="POST">
                <input type="hidden" name="tipo_usuario" id="tipo_usuario_hidden" value="medico">
                <div id="form_medico" class="modal hidden">
                    <label class="block mb-2">Nombre del Médico:</label>
                    <input type="text" name="nombre_medico" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el nombre del médico" required>

                    <label class="block mb-2">Correo del Médico:</label>
                    <input type="email" name="correo_medico" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el correo del médico" required>

                    <label class="block mb-2">Contraseña:</label>
                    <input type="password" name="contrasena_medico" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa la contraseña para el médico" required>

                    <label class="block mb-2">Horario: </label>
                    <select name="horario" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="" disabled selected>Seleccione un horario</option>
                        <?php
                        // Llenar el select con los horarios obtenidos
                        foreach ($horarios as $horario) {
                            echo '<option value="' . htmlspecialchars($horario['Horario']) . '">' . htmlspecialchars($horario['Horario']) . '</option>';
                        }
                        ?>
                    </select>

                    <label class="block mb-2">Departamento:</label>
                    <select name="departamento" id="departamento" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                        <option value="" disabled selected>Seleccione un departamento</option>
                        <?php
                        // Llenar el select con las aseguradoras obtenidas
                        foreach ($departamentos as $departamento) {
                            echo '<option value="' . htmlspecialchars($departamento['nombre_departamento']) . '">' . htmlspecialchars($departamento['nombre_departamento']) . '</option>';
                        }
                        ?>
                    </select>
                    <button type="submit" class="bg-purple-600 text-white font-semibold px-4 py-2 mt-8 rounded-lg shadow hover:bg-purple-700">Guardar</button>
                </div>
            </form>

                <!-- Formulario para recepcionista -->
            <form action="http://localhost/Gestion_Clinica/app/controllers/anadir_usuario.php" method="POST">
                <input type="hidden" name="tipo_usuario" id="tipo_usuario_hidden" value="recepcionista">
                <div id="form_recepcionista" class="modal hidden">
                    <label class="block mb-2">Nombre:</label>
                    <input type="text" name="nombre_recepcionista" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el nombre" required>

                    <label class="block mb-2">Correo:</label>
                    <input type="email" name="correo_recepcionista" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el correo" required>

                    <label class="block mb-2">Contraseña:</label>
                    <input type="password" name="contrasena_recepcionista" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa la contraseña" required>

                    <button type="submit" class="bg-purple-600 text-white font-semibold px-4 py-2 mt-8 rounded-lg shadow hover:bg-purple-700">Guardar</button>
                </div>
            </form>
            <form action="http://localhost/Gestion_Clinica/app/controllers/anadir_usuario.php" method="POST">
                <input type="hidden" name="tipo_usuario" id="tipo_usuario_hidden" value="administrador">
                <!-- Formulario para Administrador -->
                <div id="form_administrador" class="modal hidden">
                    <label class="block mb-2">Nombre:</label>
                    <input type="text" name="nombre_administrador" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el nombre" required>

                    <label class="block mb-2">Correo:</label>
                    <input type="email" name="correo_administrador" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el correo" required>

                    <label class="block mb-2">Contraseña:</label>
                    <input type="password" name="contrasena_administrador" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa la contraseña" required>

                    <button type="submit" class="bg-purple-600 text-white font-semibold px-4 py-2 mt-8 rounded-lg shadow hover:bg-purple-700">Guardar</button>
                </div>
            </form>
        </div>
    </div>


    <?php include '../includes/footer.php'; ?>

    <script>
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    function formOption() {
    const tipoUsuario = document.querySelector('select[name="select_opcion"]').value;
    const forms = ['form_paciente', 'form_medico', 'form_recepcionista', 'form_administrador'];

    // Oculta todos los formularios
    forms.forEach(form => {
        document.getElementById(form).classList.add('hidden');
    });

    // Muestra el formulario correspondiente
    if (tipoUsuario) {
        document.getElementById(`form_${tipoUsuario}`).classList.remove('hidden');
        document.getElementById('tipo_usuario_hidden').value = tipoUsuario; // Guarda el tipo de usuario en un campo oculto
    }
}

</script>

</body>
</html>
