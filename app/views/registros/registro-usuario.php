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
    <div class="bg-white my-10 p-12 rounded-lg shadow-lg w-full max-w-xl h-[80vh] overflow-y-auto">
        <form id="formulario-1" action="/Gestion_clinica/registro_sig" method="POST" onsubmit="return validarContrasena()">
            <h2 class="text-center text-3xl font-semibold mb-6">Registrarse</h2>
            <div class="mb-4">
                <label for="correo" class="block text-gray-700 font-semibold">Correo:</label>
                <input type="email" id="correo" name="correo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                <p id="error-correo" class="text-red-500 mt-2 hidden">El correo debe ser de un dominio válido.</p>
            </div>
            <div class="mb-4">
                <label for="contrasenia" class="block text-gray-700 font-semibold">Contraseña:</label>
                <input type="password" id="contrasenia" name="contrasenia" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-10">
                <label for="confirmar_contrasenia" class="block text-gray-700 font-semibold">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasenia" name="confirmar_contrasenia" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                <p id="error-mensaje" class="text-red-500 mt-2 hidden">Las contraseñas no coinciden.</p>
            </div>
            <div class="flex justify-between">
                <button type="button" onclick="window.location.href='/Gestion_clinica/login'" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold hover:bg-purple-400 hover:text-white">Volver</button>
                <button id="btn-siguiente" type="submit" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold hover:bg-purple-800 disabled:opacity-50" disabled>Siguiente</button>
            </div>
        </form>
    </div>
</div>

<script>
    const correoInput = document.getElementById("correo");
    const errorCorreo = document.getElementById("error-correo");
    const btnSiguiente = document.getElementById("btn-siguiente");

    correoInput.addEventListener("input", function () {
        // Validar el dominio del correo
        const dominioValido = /@(gmail\.com|hotmail\.com|utp\.ac\.pa)$/i; // Agregar dominios válidos aquí
        if (dominioValido.test(correoInput.value)) {
            errorCorreo.classList.add("hidden"); // Ocultar mensaje de error
            btnSiguiente.disabled = false; // Habilitar el botón
        } else {
            errorCorreo.classList.remove("hidden"); // Mostrar mensaje de error
            btnSiguiente.disabled = true; // Deshabilitar el botón
        }
    });

    function validarContrasena() {
        var contrasenia = document.getElementById("contrasenia").value;
        var confirmarContrasenia = document.getElementById("confirmar_contrasenia").value;
        var errorMensaje = document.getElementById("error-mensaje");

        if (contrasenia !== confirmarContrasenia) {
            errorMensaje.classList.remove("hidden");
            return false;
        } else {
            errorMensaje.classList.add("hidden");
            return true;
        }
    }
</script>

</body>
</html>
