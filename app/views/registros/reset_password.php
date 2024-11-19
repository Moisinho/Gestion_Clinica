<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 max-h-[100vh]">

<?php include '../../includes/header_sesion.php'; ?>

<div class="flex justify-center items-center h-screen">
    <div class="bg-white my-10 p-12 rounded-lg shadow-lg w-full max-w-xl h-auto">
        <form id="formulario-reset" action="/Gestion_clinica/app/helpers/procesar_restablecimiento_contrasenia.php?token=<?php echo htmlspecialchars($_GET['token']); ?>" method="POST" onsubmit="return validarContrasena()">
            <h2 class="text-center text-3xl font-semibold mb-6">Restablecer Contraseña</h2>
            <div class="mb-4">
                <label for="nueva_contrasenia" class="block text-gray-700 font-semibold">Nueva Contraseña:</label>
                <input type="password" id="nueva_contrasenia" name="nueva_contrasenia" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" placeholder="Nueva contraseña" required>
            </div>
            <div class="mb-4">
                <label for="confirmar_contrasenia" class="block text-gray-700 font-semibold">Confirmar Contraseña:</label>
                <input type="password" id="confirmar_contrasenia" name="confirmar_contrasenia" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" placeholder="Confirma tu contraseña" required>
                <p id="error-mensaje" class="text-red-500 mt-2 hidden">Las contraseñas no coinciden.</p>
            </div>
            <div class="flex justify-between">
                <button type="button" onclick="window.location.href='/Gestion_clinica/index.php'" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold hover:bg-purple-400 hover:text-white">Cancelar</button>
                <button type="submit" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold hover:bg-purple-800">Restablecer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function validarContrasena() {
        var nuevaContrasenia = document.getElementById("nueva_contrasenia").value;
        var confirmarContrasenia = document.getElementById("confirmar_contrasenia").value;
        var errorMensaje = document.getElementById("error-mensaje");

        if (nuevaContrasenia !== confirmarContrasenia) {
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
