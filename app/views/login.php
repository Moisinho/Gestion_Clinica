<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function mostrarSegundoFormulario(event) {
            event.preventDefault(); // Evita el envío del formulario
            const formulario1 = document.getElementById('formulario-1');

            if (formulario1.checkValidity()) { // Verifica la validez del primer formulario
                // Oculta el primer formulario
                formulario1.style.display = 'none'; 
                // Muestra el segundo formulario
                document.getElementById('formulario-2').style.display = 'block'; 
            } else {
                formulario1.reportValidity(); // Muestra errores de validación si los hay
            }
        }

        function enviarFormulario(event) {
            event.preventDefault(); // Evita el envío del formulario

            const formulario1 = document.getElementById('formulario-1');
            const formulario2 = document.getElementById('formulario-2');

            if (formulario1.checkValidity() && formulario2.checkValidity()) {
                // Crea un objeto FormData para combinar ambos formularios
                const formData = new FormData(formulario1);
                const formData2 = new FormData(formulario2);

                // Combina los datos del segundo formulario
                formData2.forEach((value, key) => {
                    formData.append(key, value);
                });

                // Envía los datos al servidor
                fetch(formulario2.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        // Maneja la respuesta del servidor
                        alert('Registro completado con éxito.');
                        window.location.href = '../agendar_cita.php';
                    } else {
                        alert('Error al registrar, intenta nuevamente.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                formulario1.reportValidity(); // Muestra errores de validación del primer formulario
                formulario2.reportValidity(); // Muestra errores de validación del segundo formulario
            }
        }
    </script>
</head>


<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-purple-400 p-4 flex justify-between items-center">
    <div class="text-white text-lg font-bold">Clínica Condado Real</div>
    <ul class="flex space-x-4 text-white font-semibold">
        <li><a href="#" class="hover:underline">RESERVAS</a></li>
    </ul>
</nav>

<div class="flex justify-center items-center h-80% w-80% mr-12 ml-12 mt-10">
<section class="bg-white p-0 rounded-lg shadow-lg w-full h-[600px]">
    <div class="flex w-full h-full rounded-lg overflow-hidden "> <!-- Añadir rounded-lg y overflow-hidden -->
        <!-- Primera Imagen -->
        <div class="w-1/2 h-full flex justify-center items-center"> 
            <img src="/proyectos/Gestion_Clinica/app/views/media/Perron.png" alt="Imagen 1" class="w-full h-full object-cover">
        </div>
        
        <!-- Segunda Imagen con Formulario de Login -->
        <div class="w-1/2 h-full flex flex-col justify-center items-center"> 
        <form action="/proyectos/Gestion_Clinica/app/models/login.php" method="POST" class="bg-white p-6 rounded-lg shadow-lg w-4/5 max-w-sm flex flex-col"> 
            <h2 class="text-center text-lg font-semibold mb-4">Iniciar Sesión</h2>
            <div class="mb-4">
                <label for="correo" class="block text-gray-700">Correo:</label> <!-- Cambiado de "username" a "correo" -->
                <input type="email" id="correo" name="correo" required class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md"> <!-- Cambiado de "username" a "correo" -->
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Contraseña:</label>
                <input type="password" id="password" name="password" required class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md">
            </div>
            <div class="flex justify-center mt-5">
                <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md">Iniciar Sesión</button>
            </div>
        </form>

            <!-- Botón de Registrarse fuera del formulario -->
            <div class="flex justify-center mt-4 ml-64">
                <a href="/proyectos/Gestion_Clinica/app/views/registros/registro-usuario.php" class="text-purple-600 hover:underline">Registrarse →</a>
            </div>
        </div>
    </div>
</section>






</div>




</body>

</html>
