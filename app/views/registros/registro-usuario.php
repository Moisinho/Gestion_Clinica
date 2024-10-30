<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 max-h-[100vh]">

<?php include '../../includes/header_sesion.php'; ?>

<!-- Form Section -->
<div class="flex justify-center items-center h-80%">
    <div class="bg-white my-10 p-12 rounded-lg shadow-lg w-full max-w-xl  h-[80vh] overflow-y-auto">
        <!-- Primer Formulario -->
        <form id="formulario-1" action="./registro-usuario__sig.php" method="POST">
            <h2 class="text-center text-3xl font-semibold mb-6">Registrarse</h2>
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
            <div class="mb-4">
                <label for="contrasenia" class="block text-gray-700 font-semibold">Contraseña:</label>
                <input type="password" id="contrasenia" name="contrasenia" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-10">
                <label for="confirmar_contrasenia" class="block text-gray-700 font-semibold">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasenia" name="confirmar_contrasenia" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="flex justify-between">
                <button onclick="window.location.href='../login.php'" type="button" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold hover:bg-purple-400 hover:text-white">Volver</button>
                <button type="submit" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold hover:bg-purple-800">Siguiente</button>
            </div>
        </form>

        <!-- Segundo Formulario -->
        <form id="formulario-2" action="../../models/registro.php" method="POST" style="display: none;" onsubmit="enviarFormulario(event)">
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
                    <option value="" disabled selected>Seleccione</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="seguro" class="block text-gray-700 font-semibold">Seguro:</label>
                <select id="seguro" name="seguro" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                    <option value="" disabled selected>Seleccione</option>
                    <option value="publico">Público</option>
                    <option value="privado">Privado</option>
                    <option value="ninguno">Ninguno</option>
                </select>
            </div>
            
            <div class="flex justify-between">
                <button type="reset" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold">Cancelar</button>
                <button type="submit" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold">Registrar</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
