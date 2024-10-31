<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Clínico - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Encabezado -->
    <header class="bg-purple-300 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-purple-900">Clínica Condado Real</h1>
            <nav>
                <ul class="flex space-x-4 text-purple-900">
                    <li><a href="#" class="hover:text-purple-600">Inicio</a></li>
                    <li><a href="#" class="hover:text-purple-600">Gestión de Citas</a></li>
                    <li><a href="#" class="hover:text-purple-600">Pacientes</a></li>
                    <li><a href="#" class="hover:text-purple-600">Datos personales</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Contenido principal -->
    <div class="container mx-auto p-5">
        <div class="bg-purple-300 p-5 rounded-lg shadow-md mt-8">
            <!-- Barra de búsqueda y botón de añadir -->
            <form method="GET" action="">
                <div class="flex items-center space-x-3">
                    <input type="text" name="buscar" placeholder="Buscar..." class="ml-5 w-full max-w-4xl px-4 py-2 rounded-lg border border-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    
                    <select name="tipo_usuario" id="tipo_usuario" class="w-32 border border-gray-300 rounded shadow-md p-2" onchange="this.form.submit();">
                        <option value="">Selecciona...</option>     
                        <option value="paciente" <?php echo (isset($_GET['tipo_usuario']) && $_GET['tipo_usuario'] == 'paciente') ? 'selected' : ''; ?>>Pacientes</option>
                        <option value="medico" <?php echo (isset($_GET['tipo_usuario']) && $_GET['tipo_usuario'] == 'medico') ? 'selected' : ''; ?>>Médicos</option>
                    </select>

                    <!-- Botón de añadir -->
                    <button type="button" class="bg-purple-600 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-purple-700" onclick="openModal()">
                        Añadir
                    </button>
                </div>
            </form>

            <div class="bg-white p-5 rounded-lg shadow-md mr-4 ml-4 mt-4">
                <!-- Tabla de resultados -->
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider" id="dynamic-header">Departamento/Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        require_once '../includes/Database.php';

                        // Crear instancia de la conexión
                        $database = new Database();
                        $conn = $database->getConnection();

                        // Inicializar variables
                        $tipo_usuario = isset($_GET['tipo_usuario']) ? $_GET['tipo_usuario'] : ''; 
                        $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

                        // Verificar si se ha seleccionado un tipo de usuario
                        if ($tipo_usuario) {
                            // Preparar la consulta
                            if ($tipo_usuario == 'paciente') {
                                $query = "SELECT cedula AS id, nombre_paciente AS nombre, correo_paciente AS correo, telefono FROM paciente WHERE nombre_paciente LIKE :buscar";
                                echo "<script>document.getElementById('dynamic-header').innerText = 'Teléfono';</script>";
                            } else if ($tipo_usuario == 'medico') {
                                $query = "SELECT id_medico AS id, nombre_medico AS nombre, correo_medico AS correo, (SELECT nombre_departamento FROM departamento WHERE id_departamento = medico.id_departamento) AS departamento FROM medico WHERE nombre_medico LIKE :buscar";
                                echo "<script>document.getElementById('dynamic-header').innerText = 'Departamento/Estado';</script>";
                            }

                            $stmt = $conn->prepare($query);
                            $buscar_param = "%" . $buscar . "%"; 
                            $stmt->bindParam(':buscar', $buscar_param, PDO::PARAM_STR);
                            
                            if (!$stmt->execute()) {
                                echo "Error en la ejecución de la consulta: " . implode(":", $stmt->errorInfo());
                            } else {
                                // Mapear resultados
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td class='px-6 text-center py-4 whitespace-nowrap text-sm text-gray-900'>{$row['id']}</td>";
                                    echo "<td class='px-6 text-center py-4  whitespace-nowrap text-sm text-gray-900'>{$row['nombre']}</td>";
                                    echo "<td class='px-6 text-center py-4  whitespace-nowrap text-sm text-gray-900'>{$row['correo']}</td>";
                                    echo "<td class='px-6 text-center py-4  whitespace-nowrap text-sm text-gray-900'>" . ($tipo_usuario == 'medico' ? $row['departamento'] : $row['telefono']) . "</td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="bg-purple-300 text-Moradote font-bold text-center py-4 mt-5">
        <p>&copy; 2024 Clínica Condado Real. Todos los derechos reservados.</p>
    </footer>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="closeModal()">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Añadir nuevo médico</h2>
            
           <!-- Formulario dentro del modal -->
            <form action="/proyectos/Gestion_Clinica/app/controllers/anadir_medico.php" method="POST">
                <label class="block mb-2">Cédula:</label>
                <input type="text" name="cedula" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa la cédula" required>

                <label class="block mb-2">Nombre del Médico:</label>
                <input type="text" name="nombre_medico" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el nombre del médico" required>

                <label class="block mb-2">Correo del Médico:</label>
                <input type="email" name="correo_medico" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" placeholder="Ingresa el correo del médico" required>

                <label class="block mb-2">Hora:</label>
                <select name="id_hora" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="1">08:00</option> <!-- 08:00:00 = 1 -->
                    <option value="2">09:00</option> <!-- 09:00:00 = 2 -->
                    <option value="3">13:00</option> <!-- 13:00:00 = 3 -->
                </select>

                <label class="block mb-2">Departamento:</label>
                <select name="id_departamento" class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="1">Pediatría</option> <!-- Pediatría = 1 -->
                    <option value="2">Cardiología</option> <!-- Cardiología = 2 -->
                    <option value="3">Oncología</option> <!-- Oncología = 3 -->
                </select>

                <button type="submit" class="bg-purple-600 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-purple-700">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Scripts para abrir y cerrar el modal -->
    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</body>
</html>
