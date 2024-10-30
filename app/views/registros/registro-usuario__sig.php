<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Paciente - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 max-h-[100vh]">

<?php include '../../includes/header_sesion.php'; ?>

<?php
// Incluir el archivo de conexión a la base de datos
include '../../includes/Database.php';

// Crear una instancia de la clase Database y obtener la conexión
$db = new Database();
$conn = $db->getConnection();

// Realizar la consulta para obtener los nombres de aseguradoras
$query = "SELECT DISTINCT nombre_aseguradora FROM seguro"; // Cambia 'aseguradoras' según tu tabla

try {
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $aseguradoras = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todos los resultados
} catch(PDOException $exception) {
    echo "Error al ejecutar la consulta: " . $exception->getMessage();
}
?>

<!-- Form Section -->
<div class="flex justify-center items-center h-80%">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg h-[75vh] my-10 overflow-y-auto">
        <form action="../../models/registro.php" method="POST">
            <input type="hidden" name="correo" value="<?php echo $_POST['correo']; ?>">
            <input type="hidden" name="contrasenia" value="<?php echo $_POST['contrasenia']; ?>">
            <div class="mb-4">
                <label for="cedula" class="block text-gray-700">Cédula:</label>
                <input type="text" name="cedula" id="cedula" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700">Nombre completo:</label>
                <input type="text" name="nombre" id="nombre" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="fecha_nacimiento" class="block text-gray-700">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="direccion" class="block text-gray-700">Dirección:</label>
                <input type="text" name="direccion" id="direccion" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="telefono" class="block text-gray-700">Teléfono:</label>
                <input type="tel" name="telefono" id="telefono" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="sexo" class="block text-gray-700">Sexo:</label>
                <select name="sexo" id="sexo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="seguro" class="block text-gray-700">Seguro:</label>
                <select name="seguro" id="seguro" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <?php
                    // Llenar el select con las aseguradoras obtenidas
                    foreach ($aseguradoras as $aseguradora) {
                        echo '<option value="' . htmlspecialchars($aseguradora['nombre_aseguradora']) . '">' . htmlspecialchars($aseguradora['nombre_aseguradora']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="flex justify-between mt-6">
                <a href="./registro-usuario.php" class="w-full mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-md text-center hover:bg-gray-400">Volver</a>
                <button type="submit" class="w-full ml-2 px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-800">Registrar</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
