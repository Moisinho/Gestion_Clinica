<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Completo - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <?php include('../includes/header.php'); ?>

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
                    <input type="text" id="sexo" name="sexo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="seguro" class="block text-gray-700 font-semibold">Seguro:</label>
                    <input type="text" id="seguro" name="seguro" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="flex justify-between">
                    <button type="reset" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold">Cancelar</button>
                    <button type="submit" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

</body>
</html>
