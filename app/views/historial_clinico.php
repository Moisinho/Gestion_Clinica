<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Clínico - Clínica Condado Real</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>

</head>

<body class="bg-gray-50 font-sans">
    <!-- Encabezado -->
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


    <!-- Contenido principal -->
    <div class="container mx-auto p-5">
        <div class="bg-white p-5 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-Moradote mb-4">Historial Clínico</h2>
            
            <!-- Datos personales del paciente -->
            <div class="mb-5">
                <h3 class="text-xl font-bold text-Moradote">Datos personales</h3>
                <div class="bg-blue-100 p-4 rounded-lg mt-2">
                    <div class="grid grid-cols-3 gap-4">
                        <p><strong>Nombre del paciente:</strong> Juan Pérez</p>
                        <p><strong>Cédula:</strong> 00-00-0000</p>
                        <p><strong>Sexo:</strong> Masculino</p>
                        <p><strong>Fecha de nacimiento:</strong> 01/01/1985</p>
                        <p><strong>Teléfono:</strong> 123456789</p>
                        <p><strong>Correo:</strong> juan.perez@email.com</p>
                    </div>
                </div>
            </div>
            
            

            <!-- Citas Médicas -->
            <div>
                <h3 class="text-xl font-bold text-Moradote">Citas Médicas</h3>
                <div class="bg-blue-100 p-4 rounded-lg mt-2">
                    <p><strong>Médico asignado:</strong> Dr. Carlos Ramírez</p>
                    <p><strong>Fecha de la cita:</strong> 10/10/2024</p>
                    <p><strong>Diagnóstico:</strong> Hipertensión leve</p>
                    <p><strong>Tratamiento:</strong> Medicamento XYZ</p>
                    <p><strong>Receta:</strong> 1 comprimido diario durante 30 días</p>
                    <p><strong>Exámenes:</strong> Exámenes de sangre y electrocardiograma</p>
                    <p><strong>Observaciones:</strong> Programar revisión dentro de 1 mes.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="bg-purple-300 text-Moradote font-bold text-center py-4 mt-5">
        <p>&copy; 2024 Clínica Condado Real. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
