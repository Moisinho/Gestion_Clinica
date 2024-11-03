<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
<?php include '../../includes/header.php'; ?>
<main class="text-center bg-purple-50">
    
<section class="py-12 bg-cover bg-center relative" style="background-image: url('../media/historia-clinica.jpg');">
    <!-- Superposición oscura para mejorar la legibilidad -->
    <div class="absolute inset-0 bg-purple-800 opacity-50"></div>

    <!-- Contenido principal -->
    <div class="relative z-10 text-center mb-8 px-4">
        <h2 class="text-3xl font-bold text-white">Brindando el Mejor Cuidado Médico</h2>
        <p class="text-white mt-2 text-xl">La salud y el bienestar de nuestros pacientes y de nuestro equipo médico siempre serán nuestra prioridad.</p>
    </div>

    <h2 class="text-3xl font-bold text-black mb-5">Servicios más populares</h2>
    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 px-4">
        <!-- Tarjeta 1 -->
        <div class="bg-white bg-opacity-90 shadow-lg rounded-lg p-6">
            <div class="flex justify-center mb-4">
                <img src="../media/pediatria.png" alt="" class="w-20 h-20">
            </div>
            <h3 class="text-lg font-semibold text-gray-800 text-center">Pediatría</h3>
            <p class="text-gray-600 text-center mt-2">Departamento encargado del cuidado de niños y adolescentes.</p>
        </div>

        <!-- Tarjeta 2 -->
        <div class="bg-white bg-opacity-90 shadow-lg rounded-lg p-6">
            <div class="flex justify-center mb-4">
                <img src="../media/cardiologia.png" alt="" class="w-20 h-20">
            </div>
            <h3 class="text-lg font-semibold text-gray-800 text-center">Cardiología</h3>
            <p class="text-gray-600 text-center mt-2">Departamento especializado en el diagnóstico y tratamiento de enfermedades del corazón.</p>
        </div>

        <!-- Tarjeta 3 -->
        <div class="bg-white bg-opacity-90 shadow-lg rounded-lg p-6">
            <div class="flex justify-center mb-4">
                <img src="../media/oncologia.png" alt="" class="w-20 h-20">
            </div>
            <h3 class="text-lg font-semibold text-gray-800 text-center">Oncología</h3>
            <p class="text-gray-600 text-center mt-2">Departamento dedicado al diagnóstico y tratamiento del cáncer.</p>
        </div>
    </div>
    
    <!-- Botón Agendar Cita -->
    <div class="relative z-20 mt-10 text-center flex justify-center">
        <form action="agendar_cita.php" method="get">
            <button type="submit" class="bg-purple-700 text-white px-4 py-2 rounded">Agendar Cita</button>
            
        </form>
        <button id="verMasServicios" class="bg-purple-700 text-white px-4 py-2 rounded relative z-20 ml-5">Ver más servicios</button>
        
    </div>
</section>

<section id="contenedorServicios" class="py-12 bg-cover bg-center relative hidden" style="background-image: url('../media/1000_F_972809743_Tyxew3qEga43WMblXper8EqJq0wX9qwA.jpg'); z-index: 20;">
    
    <div class="absolute inset-0 bg-purple-800 opacity-50" style="z-index: 10;"></div>
    <!-- Contenedor para la lista de servicios adicionales -->
    <div id="listaServicios" class="mt-4 container mx-auto px-6 relative z-30">
        <!-- Los servicios adicionales se cargarán aquí -->
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
<?php include '../../includes/footer.php'; ?>

    <script>
        $(document).ready(function() {
    // Mostrar los servicios adicionales al hacer clic en "Ver más servicios"
    $('#verMasServicios').on('click', function() {
        $.ajax({
            url: '../../controllers/citaController.php',
            type: 'GET',
            data: { action: 'obtenerServicios' },
            dataType: 'json',
            success: function(servicios) {
                // Crear el contenido dinámico de los servicios
                let contenido = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">';
                servicios.forEach(function(servicio) {
                    contenido += `
                        <div class="bg-white bg-opacity-90 shadow-lg rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800">${servicio.nombre_servicio}</h3>
                            <p class="text-gray-600 mt-2">${servicio.descripcion}</p>
                        </div>`;
                });
                contenido += '</div>';
                contenido += '<div class="text-center mt-4"><button id="cerrarServicios" class="bg-white text-purple px-4 py-2 rounded">Cerrar</button></div>';
                
                // Agregar el contenido a `#listaServicios`
                $('#listaServicios').html(contenido);
                
                // Mostrar el contenedor `#contenedorServicios` que contiene `#listaServicios`
                $('#contenedorServicios').removeClass('hidden');
            },
            error: function() {
                alert("Error al cargar los servicios.");
            }
        });
    });

    // Ocultar los servicios adicionales al hacer clic en "Cerrar"
    $(document).on('click', '#cerrarServicios', function() {
        $('#contenedorServicios').addClass('hidden');
        $('#listaServicios').empty(); // Limpiar el contenido si se desea
    });
});

    </script>

</body>
</html>
