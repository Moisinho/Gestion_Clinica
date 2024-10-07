<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-purple-400 p-4 flex justify-between items-center">
        <div class="text-white text-lg font-bold">Clínica Condado Real</div>
        <ul class="flex space-x-4 text-white font-semibold">
            <li><a href="#" class="hover:underline">RESERVAS</a></li>
            <li><a href="#" class="hover:underline">ATENCION VIRTUAL</a></li>
        </ul>
    </nav>

    <!-- Form Section -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <form action="#" method="POST">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-semibold">Nombre completo:</label>
                    <input type="text" id="nombre" name="nombre" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="cedula" class="block text-gray-700 font-semibold">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="telefono" class="block text-gray-700 font-semibold">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="correo" class="block text-gray-700 font-semibold">Correo:</label>
                    <input type="email" id="correo" name="correo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="flex justify-between">
                    <button type="reset" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold">Cancelar</button>
                    <button type="submit" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold"> <a href="/Gestion_clinica/app/registros/registro-usuario__sig.php">Siguiente</a></button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
