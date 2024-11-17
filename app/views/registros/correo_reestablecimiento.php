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
    <div class="bg-white my-10 p-12 rounded-lg shadow-lg w-full max-w-lg h-auto">
        <h2 class="text-3xl font-semibold text-center mb-6">Restablecer tu Contraseña</h2>
        <p class="text-gray-700 text-center mb-6">
            Introduce tu dirección de correo electrónico y te enviaremos un enlace para que restablezcas la contraseña.
        </p>
        <form action="../../controllers/reset_passController.php" method="POST">
            <div class="mb-6">
                <label for="correo" class="block text-gray-700 font-semibold">Correo Electrónico <span class="text-red-500">*</span></label>
                <input type="email" id="correo" name="correo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" placeholder="ejemplo@correo.com" required>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-md font-semibold hover:bg-purple-800">
                    Enviar Enlace
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
