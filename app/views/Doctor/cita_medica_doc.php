<?php
session_start();

//Verificar si el id_usuario está en la sesión; si no, redirigir al usuario a la página de login
//if (!isset($_SESSION['id_usuario'])) {
//   header('Location: ../../../index.php');
//    exit();
//}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_cita'])) {
        $idCita = $_POST['id_cita'];
        // Aquí puedes incluir la lógica para obtener los detalles de la cita usando $idCita
        // Ejemplo: $detallesCita = obtenerDetallesCita($idCita);
    } else {
        // Manejar el caso en que no se recibe el id_cita
        echo "ID de cita no recibido.";
    }
}
?>


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

    <?php include '../../includes/header_doctor.php'; ?>


    <div class="container mx-auto p-5">
        <div class="bg-white p-5 rounded-lg shadow-md mb-5">
            <h2 class="text-lg font-bold text-Moradote">Información de cita</h2>
            <div id="cita-info"></div>
            <div class="mt-4">
                <!-- Formulario para actualizar el estado de la cita -->
                <form id="actualizar-cita-form" method="POST" action="../../controllers/actualizar_cita.php" class="inline">
                    <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($id_cita); ?>">
                    <input type="hidden" name="nuevo_estado" value="Confirmada"> <!-- Estado que desees actualizar -->
                    <button type="submit" class="bg-purple-300 text-purple-900 font-bold py-2 px-4 rounded hover:bg-purple-400">Finalizar Cita</button>
                </form>
                <form id="verExpedienteForm" class="inline ml-2">
                    <input type="hidden" name="id_paciente" value="">
                    <button type="button" id="verExpedienteBtn" class="bg-purple-300 text-purple-900 font-bold py-2 px-4 rounded hover:bg-purple-400">Ver Expediente</button>
                </form>








            </div>
        </div>


        <div class="mt-5">
            <h3 class="text-lg font-bold text-Moradote">Información del Paciente</h3>
            <div id="paciente-info"></div>

        </div>

        <form id="guardar_historial_form">
            <h3 class="text-lg font-bold text-Moradote mt-5">Datos Médicos del Paciente</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Campos para datos médicos -->
                <div><label class="block font-bold">Peso (kg)</label><input type="number" name="peso" placeholder="Ej. 70" class="border border-gray-300 rounded p-2 w-full"></div>
                <div><label class="block font-bold">Altura (cm)</label><input type="number" name="altura" placeholder="Ej. 170" class="border border-gray-300 rounded p-2 w-full"></div>
                <div><label class="block font-bold">Presión Arterial</label><input type="text" name="presion_arterial" placeholder="Ej. 120/80" class="border border-gray-300 rounded p-2 w-full"></div>
                <div><label class="block font-bold">Frecuencia Cardíaca</label><input type="text" name="frecuencia_cardiaca" placeholder="Ej. 75" class="border border-gray-300 rounded p-2 w-full"></div>
                <div>
                    <label class="block font-bold">Tipo de Sangre</label>
                    <select name="tipo_sangre" class="border border-gray-300 rounded p-2 w-full">
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
            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Antecedentes Personales Patológicos</h3>
                <div class="flex flex-wrap gap-2 mb-3">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_patologicos[]" value="Cardiovasculares" class="mr-2">
                        Cardiovasculares
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_patologicos[]" value="Pulmonares" class="mr-2">
                        Pulmonares
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_patologicos[]" value="Digestivos" class="mr-2">
                        Digestivos
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_patologicos[]" value="Diabetes" class="mr-2">
                        Diabetes
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_patologicos[]" value="Renales" class="mr-2">
                        Renales
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_patologicos[]" value="Quirúrgicos" class="mr-2">
                        Quirúrgicos
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_patologicos[]" value="Transfusiones" class="mr-2">
                        Transfusiones
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_patologicos[]" value="Medicamentos" class="mr-2">
                        Medicamentos
                    </label>
                </div>
                <label for="otros_antecedentes_patologicos" class="block font-bold">Otros Antecedentes Patológicos</label>
                <textarea name="otros_antecedentes_patologicos" id="otros_antecedentes_patologicos" placeholder="Especifique otros antecedentes patológicos"
                    class="border border-gray-300 rounded p-2 w-full h-24"></textarea>
            </div>
            <!-- Antecedentes Personales no Patológicos -->

            <!-- Antecedentes Personales no Patológicos -->
            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Antecedentes Personales no Patológicos</h3>
                <div class="flex flex-wrap gap-2 mb-3">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_no_patologicos[]" value="Alcohol" class="mr-2"> Alcohol
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_no_patologicos[]" value="Tabaquismo" class="mr-2"> Tabaquismo
                    </label>

                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_no_patologicos[]" value="Drogas" class="mr-2"> Drogas
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="antecedentes_no_patologicos[]" value="Inmunizaciones" class="mr-2"> Inmunizaciones
                    </label>
                </div>
                <label for="otros_antecedentes_no_patologicos" class="block font-bold">Otros Antecedentes</label>
                <textarea name="otros_antecedentes_no_patologicos" id="otros_antecedentes_no_patologicos" placeholder="Especifique otros antecedentes" class="border border-gray-300 rounded p-2 w-full h-24"></textarea>
            </div>

            <!-- Exámenes y Estudios -->
            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradito">Exámenes y Estudios</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="condicion_general" class="block font-bold">Condición General</label>
                        <textarea name="condicion_general" id="condicion_general" class="border border-gray-300 rounded p-2 w-full h-24" placeholder="Describa la condición general"></textarea>
                    </div>
                    <div>
                        <label for="examenes_sangre" class="block font-bold">Exámenes de Sangre</label>
                        <textarea name="examenes_sangre" id="examenes_sangre" class="border border-gray-300 rounded p-2 w-full h-24" placeholder="Resultados de exámenes de sangre"></textarea>
                    </div>
                    <div>
                        <label for="laboratorios" class="block font-bold">Laboratorios y Estudios Complementarios</label>
                        <textarea name="laboratorios" id="laboratorios" class="border border-gray-300 rounded p-2 w-full h-24" placeholder="Describa los estudios de laboratorio"></textarea>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Receta</h3>
                <table class="w-full border-collapse mt-2">
                    <thead>
                        <tr class="bg-purple-300">
                            <th class="border px-2 py-1">Medicamento</th>
                            <th class="border px-2 py-1">Dosis</th>
                            <th class="border px-2 py-1">Frecuencia</th>
                            <th class="border px-2 py-1">Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border"><input type="text" name="medicamento[]" placeholder="Medicamento" class="w-full p-1"></td>
                            <td class="border"><input type="text" name="dosis[]" placeholder="Dosis" class="w-full p-1"></td>
                            <td class="border"><input type="text" name="frecuencia[]" placeholder="Frecuencia" class="w-full p-1"></td>
                            <td class="border"><input type="text" name="duracion[]" placeholder="Duración" class="w-full p-1"></td>
                        </tr>
                        <tr>
                            <td class="border"><input type="text" name="medicamento[]" placeholder="Medicamento" class="w-full p-1"></td>
                            <td class="border"><input type="text" name="dosis[]" placeholder="Dosis" class="w-full p-1"></td>
                            <td class="border"><input type="text" name="frecuencia[]" placeholder="Frecuencia" class="w-full p-1"></td>
                            <td class="border"><input type="text" name="duracion[]" placeholder="Duración" class="w-full p-1"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Diagnostico</h3>
                <textarea name="diagnostico" id="diagnostico" class="border border-gray-300 rounded p-2 w-full h-24" placeholder="Especifique las recomendaciones..."></textarea>
            </div>

            <div class="mt-5">
                <h3 class="text-lg font-bold text-Moradote">Tratamiento</h3>
                <textarea name="tratamiento" id="tratamiento" class="border border-gray-300 rounded p-2 w-full h-24" placeholder="Especifique observaciones adicionales..."></textarea>
            </div>

            <div class="mt-5">
                <label class="block font-bold">Referencia</label>
                <select name="referencia" id="selectServicios" class="border border-gray-300 rounded p-2 w-full">
                    <option value="">Sin referencia</option>
                    <!-- Los servicios se llenarán dinámicamente con JavaScript -->
                </select>
            </div>

            <div class="mt-5">
                <button type="submit" id="guardarHistorialBtn" class="bg-purple-500 text-white py-2 px-4 rounded">Guardar Información</button>
            </div>
    </div>
    </form>
    </div>

    <?php include '../../includes/footer.php'; ?>
    <script src="../Js/Doctor/detalles_cita_medica.js" defer></script>
</body>

</html>