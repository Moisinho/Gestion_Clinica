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
    <title>Historial Clínico - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50 font-sans">
    <?php include '../../includes/header_doctor.php'; ?>
    <!-- Contenido principal -->
    <div class="container mx-auto p-5 h-screen">
        <div class="bg-white p-5 rounded-lg shadow-md">
            <div class="mt-5 text-center flex justify-between">
                <h2 class="text-2xl font-bold text-Moradote mb-4">Historial Clínico</h2>
                <button 
                    id="volverBtn" 
                    class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-Moradote-dark transition">
                    Volver
                </button>
                
            </div>
            <div id="historial-container"></div>

            <!-- Datos personales del paciente -->
            <div class="mb-5">
                <h3 class="text-xl font-bold text-Moradote">Datos personales</h3>
                <div id="datosPersonales" class="bg-blue-100 p-4 rounded-lg mt-2"></div>
            </div>

            <!-- Citas Médicas -->
            <div>
                <h3 class="text-xl font-bold text-Moradote">Citas Médicas</h3>
                <div id="citasMedicas"></div>
            </div>

            <!-- Mensaje de error -->
            <div id="mensajeError" class="text-red-500 mt-4"></div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>
    <script src="/Gestion_clinica/app/views/Js/Doctor/historial.js"></script>
    
    <script src="/Gestion_clinica/app/js/tailwind-config.js"></script>
    <script>
    document.getElementById("volverBtn").addEventListener("click", function() {
        window.history.back();
    });
</script>

</body>

</html>