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

    <!-- Form Section -->
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <!-- Primer Formulario -->
            <form id="formulario-1" method="POST" onsubmit="mostrarSegundoFormulario(event)">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-semibold">Nombre completo:</label>
                    <input type="text" id="nombre" name="nombre" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="cedula" class="block text-gray-700 font-semibold">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="telefono" class="block text-gray-700 font-semibold">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="correo" class="block text-gray-700 font-semibold">Correo:</label>
                    <input type="email" id="correo" name="correo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="flex justify-between">
                    <button type="reset" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold">Cancelar</button>
                    <button type="button" onclick="mostrarSegundoFormulario(event)" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold">Siguiente</button>
                </div>
            </form>

            <!-- Segundo Formulario -->
            <form id="formulario-2" action="../../models/registro.php" method="POST" style="display: none;" onsubmit="enviarFormulario(event)">
                <div class="mb-4">
                    <label for="fecha_nacimiento" class="block text-gray-700 font-semibold">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="direccion" class="block text-gray-700 font-semibold">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="sexo" class="block text-gray-700 font-semibold">Sexo:</label>
                    <input type="text" id="sexo" name="sexo" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="seguro" class="block text-gray-700 font-semibold">Seguro:</label>
                    <input type="text" id="seguro" name="seguro" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="flex justify-between">
                    <button type="reset" class="w-32 px-4 py-2 bg-purple-200 text-purple-600 rounded-md font-semibold">Cancelar</button>
                    <button type="submit" class="w-32 px-4 py-2 bg-purple-600 text-white rounded-md font-semibold">Registrar</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
