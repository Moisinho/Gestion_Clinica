<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /Gestion_clinica/');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Clínica</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <?php include '../../includes/header.php'; ?>

    <main class="bg-purple-50 text-center py-12">
        <section class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-purple-700 mb-6">Contáctanos</h1>
            <p class="text-lg text-gray-600 mb-8">¿Tienes preguntas o necesitas más información? Estamos aquí para ayudarte.</p>

            <div class="bg-purple-300 shadow-lg rounded-lg p-6 text-center flex flex-col items-center">
                <h2 class="text-2xl font-semibold text-purple-700 mb-4">Información de Contacto</h2>
                <h3 class="text-xl font-semibold text-white mb-4">Clínica Pacoren</h3>
                <!-- Clase para centrar la imagen -->
                <img src="/Gestion_clinica/app/views/media/image0_0-removebg-preview.png" alt="" class="w-32 h-32 mb-4">
                <p class="text-gray-600 mb-2"><strong>Teléfono:</strong> 0000-0000</p>
                <p class="text-gray-600 mb-2"><strong>Correo Electrónico:</strong> proyectoclinicads7@gmail.com</p>
            </div>

            
        </section>
    </main>

    <?php include '../../includes/footer.php'; ?>
</body>
</html>
