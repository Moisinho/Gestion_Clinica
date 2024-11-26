<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Exitoso</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-green-600">¡Registro Exitoso!</h1>
        <p class="mt-4 text-gray-700">Bienvenido, <span class="font-semibold text-purple-600"><?php echo htmlspecialchars($_GET['nombre']); ?></span>.</p>
        <p class="mt-2">Serás redirigido a tu panel en unos segundos.</p>
        <div class="mt-6">
            <a href="<?php echo htmlspecialchars($_GET['destino']); ?>" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-800">
                Ir al Panel
            </a>
        </div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = "<?php echo htmlspecialchars($_GET['destino']); ?>";
        }, 5000);
    </script>
</body>
</html>
