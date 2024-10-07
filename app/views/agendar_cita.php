<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Reservas de Citas Médicas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Encabezado -->
    <header class="bg-Moradito py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-purple-900">Clínica Condado Real</h1>
            <nav>
                <ul class="flex space-x-4 text-purple-900">
                    <li><a href="#" class="hover:text-purple-600">Inicio</a></li>
                    <li><a href="#" class="hover:text-purple-600">Nosotros</a></li>
                    <li><a href="#" class="hover:text-purple-600">Contactos</a></li>
                    <li><a href="#" class="hover:text-purple-600">Reservas</a></li>
                    <li><a href="#" class="hover:text-purple-600">Atención Virtual</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Título Principal -->
    <section class="my-8">
        <h2 class="text-3xl font-bold text-center text-purple-700">Registro de Reservas de Citas Médicas</h2>
        <hr class="mt-2 border-t-2 border-purple-700 w-1/2 mx-auto">
    </section>

    <!-- Contenido Principal -->
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Formulario de Reserva de Cita -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-purple-700 mb-4">Datos de la Reserva de Cita</h3>
            <form>
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name</label>
                    <input type="text" id="name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-4">
                    <label for="last_name" class="block text-gray-700">Last name</label>
                    <input type="text" id="last_name"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-4">
                    <label for="cedula" class="block text-gray-700">Cédula</label>
                    <input type="text" id="cedula"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-4">
                    <label for="medico" class="block text-gray-700">Médico de atención</label>
                    <input type="text" id="medico"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-4">
                    <label for="telefono" class="block text-gray-700">Teléfono</label>
                    <input type="tel" id="telefono"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-4">
                    <label for="fecha" class="block text-gray-700">Fecha de cita</label>
                    <input type="date" id="fecha"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex justify-between">
                    <button type="submit"
                        class="bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-500">Agendar</button>
                    <button type="button"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Borrar reserva</button>
                </div>
            </form>
        </div>

        <!-- Tabla de Citas Programadas -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-purple-700 mb-4">Citas Programadas</h3>
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600">Tipo de cita</th>
                        <th class="px-4 py-2 text-left text-gray-600">Fecha</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-2">Sesión de terapias</td>
                        <td class="px-4 py-2">27/11/2022 - 01:00pm</td>
                        <td class="px-4 py-2"><button
                                class="bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-500">Detalles</button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">Terapia psicológica</td>
                        <td class="px-4 py-2">28/11/2022 - 01:00pm</td>
                        <td class="px-4 py-2"><button
                                class="bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-500">Detalles</button>
                        </td>
                    </tr>
                    <!-- Agregar más filas según sea necesario -->
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>