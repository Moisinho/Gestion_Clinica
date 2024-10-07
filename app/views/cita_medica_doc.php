<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Condado Real - Gestión de Citas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
</head>

<body class="bg-gray-50 font-sans">

    <!-- Menú de navegación -->
    <header class="bg-purple-300 py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-purple-900">Clínica Condado Real</h1>
            <nav>
                <ul class="flex space-x-4 text-purple-900">
                    <li><a href="#" class="hover:text-purple-600">Inicio</a></li>
                    <li><a href="#" class="hover:text-purple-600">Gestión de Citas</a></li>
                    <li><a href="#" class="hover:text-purple-600">Pacientes</a></li>
                    <li><a href="#" class="hover:text-purple-600">Datos personales</a></li>
                    
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto p-5">
        <div class="bg-white p-5 rounded-lg shadow-md mb-5">
            <h2 class="text-lg font-bold text-Moradote">Información de cita</h2>
            <p>Fecha: día/mes/año 00:00</p>
            <p>Motivo: Descripción del motivo del paciente para acudir a la clínica</p>
            <div class="mt-4">
                <button class="bg-Moradote text-white py-2 px-4 rounded hover:bg-Moradito">Finalizar Cita</button>
                <button class="bg-Moradote text-white py-2 px-4 rounded hover:bg-Moradito">Ver Expediente</button>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-md">

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Información del Paciente</h3>
                <p><strong>Nombre:</strong> Juan Pérez</p>
                <p><strong>Cédula:</strong> 00-00-0000</p>
                <p><strong>Teléfono:</strong> 123456789</p>
                <p><strong>Correo:</strong> juan.perez@email.com</p>
                <p><strong>Fecha de Nacimiento:</strong> 01/01/1985</p>
                <p><strong>Edad:</strong> <span id="edad"></span> años</p>
            </div>

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Datos Médicos del Paciente</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block font-bold">Peso (kg)</label>
                        <input type="number" id="peso" placeholder="Ej. 70" class="border border-gray-300 rounded p-2 w-full">
                    </div>
                    <div>
                        <label class="block font-bold">Altura (cm)</label>
                        <input type="number" id="altura" placeholder="Ej. 170" class="border border-gray-300 rounded p-2 w-full">
                    </div>
                    <div>
                        <label class="block font-bold">Presión Arterial</label>
                        <input type="text" id="presion_arterial" placeholder="Ej. 120/80" class="border border-gray-300 rounded p-2 w-full">
                    </div>
                    <div>
                        <label class="block font-bold">Frecuencia Cardíaca</label>
                        <input type="text" id="frecuencia_cardiaca" placeholder="Ej. 75" class="border border-gray-300 rounded p-2 w-full">
                    </div>
                    <div>
                        <label class="block font-bold">Tipo de Sangre</label>
                        <select id="tipo_sangre" class="border border-gray-300 rounded p-2 w-full">
                            <option value="">Seleccione</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                </div>
            </div>
            

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Antecedentes Personales Patológicos</h3>
                <div class="flex flex-wrap gap-2 mb-3">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Cardiovasculares
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Pulmonares
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Digestivos
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Diabetes
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Renales
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Quirúrgicos
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Transfusiones
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Medicamentos
                    </label>
                </div>
                <label for="otros_antecedentes" class="block font-bold">Otros Antecedentes</label>
                <textarea id="otros_antecedentes" placeholder="Especifique otros antecedentes"
                    class="border border-gray-300 rounded p-2 w-full h-24"></textarea>
            </div>

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Antecedentes Personales no Patológicos</h3>
                <div class="flex flex-wrap gap-2 mb-3">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Alcohol
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Tabaquismo
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Digestivos
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Drogas
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="mr-2">
                        Inmunizaciones
                    </label>
                    
                </div>
                <label for="otros_antecedentes" class="block font-bold">Otros Antecedentes</label>
                <textarea id="otros_antecedentes" placeholder="Especifique otros antecedentes"
                    class="border border-gray-300 rounded p-2 w-full h-24"></textarea>
            </div>

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Exámenes y Estudios</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="condicion_general" class="block font-bold">Condición General</label>
                        <textarea id="condicion_general" class="border border-gray-300 rounded p-2 w-full h-24"
                            placeholder="Describa la condición general"></textarea>
                    </div>
                    <div>
                        <label for="examenes_sangre" class="block font-bold">Exámenes de Sangre</label>
                        <textarea id="examenes_sangre" class="border border-gray-300 rounded p-2 w-full h-24"
                            placeholder="Resultados de exámenes de sangre"></textarea>
                    </div>
                    <div>
                        <label for="laboratorios" class="block font-bold">Laboratorios y Estudios Complementarios</label>
                        <textarea id="laboratorios" class="border border-gray-300 rounded p-2 w-full h-24"
                            placeholder="Describa los estudios de laboratorio"></textarea>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Receta</h3>
                <table class="w-full border-collapse mt-2">
                    <thead>
                        <tr class="bg-Moradito">
                            <th class="border px-2 py-1">Medicamento</th>
                            <th class="border px-2 py-1">Dosis</th>
                            <th class="border px-2 py-1">Frecuencia</th>
                            <th class="border px-2 py-1">Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border"><input type="text" placeholder="Medicamento" class="w-full p-1"></td>
                            <td class="border"><input type="text" placeholder="Dosis" class="w-full p-1"></td>
                            <td class="border"><input type="text" placeholder="Frecuencia" class="w-full p-1"></td>
                            <td class="border"><input type="text" placeholder="Duración" class="w-full p-1"></td>
                        </tr>
                        <tr>
                            <td class="border"><input type="text" placeholder="Medicamento" class="w-full p-1"></td>
                            <td class="border"><input type="text" placeholder="Dosis" class="w-full p-1"></td>
                            <td class="border"><input type="text" placeholder="Frecuencia" class="w-full p-1"></td>
                            <td class="border"><input type="text" placeholder="Duración" class="w-full p-1"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Recomendaciones</h3>
                <textarea id="recomendaciones" placeholder="Escriba recomendaciones aquí"
                    class="border border-gray-300 rounded p-2 w-full h-24"></textarea>
            </div>

            <div class="mt-5 text-center">
                <button class="bg-Moradote text-white py-2 px-4 rounded hover:bg-purple-500">Guardar</button>
                <button class="bg-Moradote text-white py-2 px-4 rounded hover:bg-purple-500">Cancelar</button>
            </div>
        </div>
    </div>

    <footer class="bg-purple-300 text-Moradote font-bold text-center py-4 mt-5">
        <p>&copy; 2024 Clínica Condado Real. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
