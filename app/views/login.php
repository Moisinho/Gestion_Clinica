
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-100 max-h-[100vh]">

    <?php include '../includes/header_sesion.php'; ?>

    <div class="flex justify-center items-center h-80% w-80% mr-12 ml-12 mt-10">
        <section class="bg-white p-0 rounded-lg shadow-lg w-full h-[75vh]">
            <div class="flex w-full h-full rounded-lg overflow-hidden ">
                
                <div class="w-1/2 h-full flex justify-center items-center"> 
                <img src="/Gestion_clinica/app/views/media/login.jpg" alt="Imagen 1" class="w-full h-full object-cover">

                </div>
                <div class="w-1/2 h-full flex flex-col justify-center items-center"> 
                    <form action="/Gestion_clinica/app/controllers/AuthController.php" method="POST" class="bg-white p-6 rounded-lg w-4/5 flex flex-col"> 
                        <h2 class="text-center text-3xl font-semibold mb-6">Iniciar Sesión</h2>

                        <div class="mb-6">
                            <label for="correo" class="text-lg font-bold block text-gray-700">Correo:</label>
                            <input type="email" id="correo" name="correo" required class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="mb-6">
                            <label for="password" class="text-lg font-bold block text-gray-700">Contraseña:</label>
                            <input type="password" id="password" name="password" required class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="flex justify-center mt-5">
                            <button type="submit" class="font-bold text-lg w-full p-3 bg-purple-600 text-white rounded-md hover:bg-purple-800">Ingresar</button>
                        </div>
                        <!-- Mostrar mensaje de error -->
                        <?php if (isset($_GET['error'])): ?>
                            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mt-4 mb-4">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        <?php endif; ?>
                    </form>

                    <div class="flex justify-around w-full">
                        <a href="/Gestion_clinica/restablecer_contrasena" class="text-purple-600 hover:underline">¿Has olvidado tu contraseña?</a>
                        <a href="/Gestion_clinica/registro" class="text-purple-600 hover:underline">Registrarse →</a>
                    </div>
                </div>

            </div>
        </section>
    </div>
</body>

</html>
