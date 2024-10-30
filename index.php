<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
<?php include 'app/includes/header_inicio.php'; ?>
<main class="text-center bg-purple-50">
    
    <section class="py-12 bg-cover bg-center relative" style="background-image: url('app/views/media/historia-clinica.jpg');">
    <!-- Superposición oscura para mejorar la legibilidad -->
    <div class="absolute inset-0 bg-purple-800 opacity-50"></div>

    <!-- Contenido principal -->
    <div class="relative z-10 text-center mb-8 px-4">
        <h2 class="text-3xl font-bold text-white">Brindando el Mejor Cuidado Médico</h2>
        <p class="text-white mt-2 text-xl">La salud y el bienestar de nuestros pacientes y de nuestro equipo médico siempre serán nuestra prioridad.</p>
    </div>

    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 px-4">
        <!-- Tarjeta 1 -->
        <div class="bg-white bg-opacity-90 shadow-lg rounded-lg p-6">
            <div class="flex justify-center mb-4">
                <img src="app/views/media/cardiologia.png" alt="" class="w-20 h-20">
            </div>
            <h3 class="text-lg font-semibold text-gray-800 text-center">Pediatría</h3>
            <p class="text-gray-600 text-center mt-2">Departamento encargado del cuidado de niños y adolescentes.</p>
            <form action="" method="get" class="mt-4 text-center">
                <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded">Agendar Cita</button>
            </form>
        </div>

        <!-- Tarjeta 2 -->
        <div class="bg-white bg-opacity-90 shadow-lg rounded-lg p-6">
            <div class="flex justify-center mb-4">
                <img src="app/views/media/pediatria.png" alt="" class="w-20 h-20">
            </div>
            <h3 class="text-lg font-semibold text-gray-800 text-center">Cardiología</h3>
            <p class="text-gray-600 text-center mt-2">Departamento especializado en el diagnóstico y tratamiento de enfermedades del corazón.</p>
            <form action="app/views/agendar_cita.php" method="get" class="mt-4 text-center">
                <input type="hidden" name="servicio" value="Cardiología">
                <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded">Agendar Cita</button>
            </form>
        </div>

        <!-- Tarjeta 3 -->
        <div class="bg-white bg-opacity-90 shadow-lg rounded-lg p-6">
            <div class="flex justify-center mb-4">
                <img src="app/views/media/oncologia.png" alt="" class="w-20 h-20">
            </div>
            <h3 class="text-lg font-semibold text-gray-800 text-center">Oncología</h3>
            <p class="text-gray-600 text-center mt-2">Departamento dedicado al diagnóstico y tratamiento del cáncer.</p>
            <form action="agendar_cita.php" method="get" class="mt-4 text-center">
                <input type="hidden" name="servicio" value="Oncología">
                <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded">Agendar Cita</button>
            </form>
        </div>
    </div>
</section>


</main>
<section class="flex justify-around py-12 bg-purple-100">
    <div class="text-center max-w-xs">
        <h2 class="text-xl font-bold text-purple-700">Casos de Emergencia</h2>
        <p class="mt-2 text-gray-600">No dudes en contactar a nuestro personal de recepción amigable con cualquier consulta médica general.</p>
    </div>
    <div class="text-center max-w-xs">
        <h2 class="text-xl font-bold text-purple-700">Horario de Doctores</h2>
        <p class="mt-2 text-gray-600">Doctores calificados disponibles seis días a la semana.</p>
    </div>
    <div class="text-center max-w-xs">
        <h2 class="text-xl font-bold text-purple-700">Horas de Apertura</h2>
        <p class="mt-2 text-gray-600">Lunes - Viernes: 8:00 - 19:00<br>Sábado: 9:00 - 20:00</p>
    </div>
</section>
<?php include 'app/includes/footer.php'; ?>
</body>
</html>

