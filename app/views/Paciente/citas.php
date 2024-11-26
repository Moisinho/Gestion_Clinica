<?php
// Iniciar la sesión
session_start();

// Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
if (!isset($_SESSION['id_usuario'])) {
    header('Location: /Gestion_clinica/index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <style>
        .today {
            color: blue;
            font-weight: bold;
            border-radius: 50%;
        }
        .table-container {
            height: 500px;
            overflow-y: auto;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <?php include '../../includes/header.php'; ?>

    <main class="flex flex-col md:flex-row mt-8 mx-4 md:mx-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 md:w-2/3 lg:w-3/4 mb-6 md:mb-0 overflow-y-auto table-container">
            <h2 class="text-2xl font-semibold text-purple-700 mb-4">Mis Citas</h2>
            <table class="w-full border-collapse">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="p-3 text-left">Motivo</th>
                        <th class="p-3 text-left">Fecha</th>
                        <th class="p-3 text-left">Hora</th>
                        <th class="p-3 text-left">Doctor</th>
                        <th class="p-3 text-left">Estado</th>
                    </tr>
                </thead>
                <tbody  id="contenedorCitas">
               
                </tbody>


            </table>
        </div>

        <div class="w-full md:w-1/3 lg:w-1/4 bg-gray-200 rounded-lg shadow-md p-6 ml-0 md:ml-4">
            <h3 class="font-bold text-lg text-purple-700 mb-4 text-center" id="monthYear"></h3>
            <div class="grid grid-cols-7 gap-2 text-center">
                <div class="font-bold">Dom</div>
                <div class="font-bold">Lun</div>
                <div class="font-bold">Mar</div>
                <div class="font-bold">Mié</div>
                <div class="font-bold">Jue</div>
                <div class="font-bold">Vie</div>
                <div class="font-bold">Sáb</div>
                <div id="calendarDays" class="col-span-7 grid grid-cols-7 gap-2"></div>
            </div>
        </div>
    </main>

    <?php include '../../includes/footer.php'; ?>
    <script>
        const idUsuario = <?php echo json_encode($id_usuario); ?>;
    </script>
    <script src="/Gestion_clinica/app/views/Js/Paciente/citas.js"></script>
</body>
</html>
