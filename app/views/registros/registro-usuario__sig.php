<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Completo - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<?php include '../../includes/header_sesion.php'; ?>

    <!-- Form Section -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <form action="../models/registro-final.php" method="POST">
                <div class="mb-4">
                    <label for="fecha_nacimiento" class="block text-gray-700 font-semibold">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="direccion" class="block text-gray-700 font-semibold">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="sexo" class="block text-gray-700 font-semibold">Sexo:</label>
                    <select id="sexo" name="sexo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                        <option disabled selected value="">Seleccione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="seguro" class="block text-gray-700 font-semibold">Seguro:</label>
                    <select id="seguro" name="seguro" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                        <option disabled selected value="">Seleccione</option>
                        <?php
                            // Conexión a la base de datos
                            include '../../includes/Database.php'; // Asegúrate de que este archivo existe y está correctamente configurado

                            // Crear una instancia de la clase Database
                            $database = new Database();
                            $conexion = $database->getConnection(); // Obtener la conexión

                            // Comprobación de la conexión
                            if (!$conexion) {
                                echo '<div class="mb-4 text-red-500">Error: No se pudo establecer la conexión a la base de datos.</div>';
                            } else {
                                echo '<div class="mb-4 text-green-500">Conexión a la base de datos establecida correctamente.</div>';
                                
                                // Consulta para obtener las aseguradoras
                                $query = "SELECT DISTINCT nombre_aseguradora FROM seguro";
                                $resultado = $conexion->query($query);

                                // Verificar si hay resultados y llenar el select
                                if ($resultado->rowCount() > 0) {
                                    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . htmlspecialchars($row['nombre_aseguradora']) . '">' . htmlspecialchars($row['nombre_aseguradora']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No hay aseguradoras disponibles</option>';
                                }
                            }
                            ?>
                    </select>
                </div>
                <div class="flex justify-between">
                    <button type="reset" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold">Cancelar</button>
                    <button type="submit" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <?php include('../../includes/footer.php'); ?>

</body>
</html>
