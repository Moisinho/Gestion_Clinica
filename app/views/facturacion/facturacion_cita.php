<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturar Citas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Encabezado -->
    <div class="bg-[#6A5492] text-white p-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <form method="POST">
                <select name="criterio" class="p-2 bg-white text-black rounded-md">
                    <option value="estado">Estado</option>
                    <option value="diagnostico">Diagnóstico</option>
                    <option value="tratamiento">Tratamiento</option>
                </select>
                <input type="text" name="busqueda" class="p-2 rounded-md" placeholder="Ingrese criterio de búsqueda">
                <button type="submit" class="p-2 bg-white text-purple-600 rounded-md">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 2a8 8 0 106.32 3.16l4.92 4.92-1.41 1.41-4.92-4.92A8 8 0 0010 2z"></path>
                    </svg>
                </button>
            </form>
        </div>
        <button class="bg-gray-200 text-purple-600 p-2 rounded-md">Buscar</button>
    </div>

    <!-- Contenido principal -->
    <div class="flex">
        <div class="flex flex-col mt-4 mx-8">
            <!-- Tabla de citas -->
            <h2 class="flex text-xl font-bold text-gray-700 p-4">CITAS SIN COBRAR</h2>
            <div class="flex-1 bg-white shadow-md rounded-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-purple-600 text-white">
                        <tr>
                            <th class="p-2">Nombre</th>
                            <th class="p-2">Teléfono</th>
                            <th class="p-2">Dirección</th>
                            <th class="p-2">E-mail</th>
                            <th class="p-2">DNI</th>
                            <th class="p-2">Fecha de reserva</th>
                            <th class="p-2">Estado</th>
                            <th class="p-2">Atención</th>
                            <th class="p-2">NHC</th>
                            <th class="p-2">Más</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $database = new Database;
                            

                            // Crear la conexión
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Verificar la conexión
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }

                            // Variables del formulario
                            $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

                            // Procedimiento almacenado
                            $sql = "CALL BuscarCitas('$busqueda')";
                            $result = $conn->query($sql);

                            // Verificar si se obtuvieron resultados
                            if ($result->num_rows > 0) {
                                // Recorrer los resultados
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr class='border-b'>";
                                    echo "<td class='p-2'>" . $row['nombre'] . "</td>";
                                    echo "<td class='p-2'>" . $row['telefono'] . "</td>";
                                    echo "<td class='p-2'>" . $row['direccion'] . "</td>";
                                    echo "<td class='p-2'>" . $row['email'] . "</td>";
                                    echo "<td class='p-2'>" . $row['dni'] . "</td>";
                                    echo "<td class='p-2'>" . $row['fecha_reserva'] . "</td>";
                                    echo "<td class='p-2 text-green-500'>" . $row['estado'] . "</td>";
                                    echo "<td class='p-2'>" . $row['atencion'] . "</td>";
                                    echo "<td class='p-2'>" . $row['nhc'] . "</td>";
                                    echo "<td class='p-2'><button class='bg-blue-500 text-white p-2 rounded-md'>COBRAR</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10' class='p-2 text-center'>No se encontraron registros</td></tr>";
                            }

                            // Cerrar la conexión
                            $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Publicidad -->
        <div class="w-64 bg-gray-200 ml-4 rounded-lg shadow-md p-4 text-center">
            <p class="text-xl font-bold">Publicidad o foto fina</p>
        </div>
    </div>
</body>
</html>
