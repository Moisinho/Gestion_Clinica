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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
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
                <form id="actualizar-cita-form" method="POST" action="Gestion_clinica/app/controllers/actualizar_cita.php" class="inline">
                    <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($id_cita); ?>">
                    <input type="hidden" name="nuevo_estado" value="Confirmada"> <!-- Estado que desees actualizar -->
                    <button type="submit" class="bg-purple-300 text-purple-900 font-bold py-2 px-4 rounded hover:bg-purple-400">Finalizar Cita</button>
                </form>

                <form id="verExpedienteForm" class="inline ml-2">
                    <input type="hidden" name="id_paciente" value="<?php echo $id_paciente; ?>">

                    <button type="button" id="verExpedienteBtn" class="bg-purple-300 text-purple-900 font-bold py-2 px-4 rounded hover:bg-purple-400">Ver Expediente</button>
                </form>
                <button id="volverBtn" class="bg-purple-300 text-purple-900 font-bold py-2 px-4 rounded hover:bg-purple-400 ml-2">Volver</button>

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
                <?php
                require_once '../../includes/Database.php';
                require_once '../../models/Receta.php';

                $medicamentoModel = new Medicamento();

                $medicamentos = $medicamentoModel->obtenermeds();

                // Verificar si los medicamentos fueron cargados correctamente
                if (!empty($medicamentos)) {
                    echo "Medicamentos cargados correctamente";
                } else {
                    echo "No se encontraron medicamentos";
                }
                ?>

                <!-- Tu HTML con el formulario -->
                <div class="mt-5">
    <h3 class="text-lg font-bold text-Moradote">Receta</h3>
    <!-- Contenedor de la tabla -->
    <table id="receta-table" class="w-full border-collapse mt-2 receta-table">
        <thead>
            <tr class="bg-purple-300">
                <th class="border px-2 py-1">Medicamento</th>
                <th class="border px-2 py-1">Dosis</th>
                <th class="border px-2 py-1">Frecuencia</th>
                <th class="border px-2 py-1">Duración</th>
                <th class="border px-2 py-1">Stock</th>
            </tr>
        </thead>
        <tbody id="receta-body">
            <!-- Fila inicial -->
            <tr>
                <td class="border">
                    <select name="medicamento[]" class="rounded-md focus:outline-none hover:bg-transparent" onchange="mostrarStock(this)">
                        <option disabled selected value="">Seleccione un medicamento</option>
                        <?php if (!empty($medicamentos)): ?>
                            <?php foreach ($medicamentos as $medicamento): ?>
                                <option value="<?= $medicamento['id_medicamento'] ?>" data-stock="<?= $medicamento['cant_stock'] ?>">
                                    <?= htmlspecialchars($medicamento['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No hay medicamentos disponibles</option>
                        <?php endif; ?>
                    </select>
                </td>
                <td class="border"><input type="text" name="dosis[]" placeholder="Dosis" class="w-full p-1"></td>
                <td class="border"><input type="text" name="frecuencia[]" placeholder="Frecuencia" class="w-full p-1"></td>
                <td class="border"><input type="text" name="duracion[]" placeholder="Duración" class="w-full p-1"></td>
                <td class="border">
                    <input type="text" name="stock[]" readonly class="w-full p-1" placeholder="Stock">
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Botón para agregar una fila -->
    <button type="button" onclick="agregarFila()" class="mt-3 bg-purple-500 text-white p-2 rounded-md">Agregar receta</button>
    <button onclick="generarPDF()" class="mt-3 bg-blue-500 text-white p-2 rounded-md">Generar PDF</button>

</div>
<script>
    function generarPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();

        doc.setFontSize(16);
        doc.setFont("helvetica", "bold");
        doc.text("Receta Médica", pageWidth / 2, 20, { align: "center" });

        doc.setFontSize(12);
        doc.text("Paciente: Juan Pérez", 20, 40);
        doc.text("Fecha: " + new Date().toLocaleDateString(), 150, 40);
        doc.text("Médico: Dr. María López", 20, 50);
        doc.text("Especialidad: Cardiología", 150, 50);

        doc.setLineWidth(0.5);
        doc.line(20, 60, pageWidth - 20, 60);

        const table = document.getElementById("receta-table");
        const rows = table.querySelectorAll("tbody tr");

   
        const headers = ["Medicamento", "Dosis", "Frecuencia", "Duración", "Stock"];

        
        let y = 70;
        doc.setFontSize(10);
        doc.text(headers[0], 20, y);
        doc.text(headers[1], 60, y);
        doc.text(headers[2], 100, y);
        doc.text(headers[3], 140, y);
        doc.text(headers[4], 180, y);

        y += 10;
        rows.forEach((row, index) => {
            const medicamento = row.querySelector('select[name="medicamento[]"] option:checked').textContent.trim();
            const dosis = row.querySelector('input[name="dosis[]"]').value.trim();
            const frecuencia = row.querySelector('input[name="frecuencia[]"]').value.trim();
            const duracion = row.querySelector('input[name="duracion[]"]').value.trim();
            const stock = row.querySelector('input[name="stock[]"]').value.trim();

            doc.text(medicamento, 20, y + 10);
            doc.text(dosis, 60, y + 10);
            doc.text(frecuencia, 100, y + 10);
            doc.text(duracion, 140, y + 10);
            doc.text(stock, 180, y + 10);
            y += 10;
        });

        y += 10;  

        doc.line(20, y, pageWidth - 20, y);
        y += 10; 

        doc.setFontSize(8);
        doc.text("Dirección: Calle Ejemplo 123 | Tel: (123) 456-7890", 20, y);
        doc.text("www.clinicasalud.com", pageWidth - 80, y, { align: "right" });

        doc.save("Receta_Medica.pdf");
    }
</script>

<script>
    function mostrarStock(selectElement) {
        const stockInput = selectElement.closest('tr').querySelector('input[name="stock[]"]');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock');
        stockInput.value = stock || '';
    }

    // Función para agregar una nueva fila al tbody
    function agregarFila() {
        // Seleccionar el tbody
        const tbody = document.getElementById('receta-body');

        // Crear una nueva fila
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="border">
                <select name="medicamento[]" class="rounded-md focus:outline-none hover:bg-transparent" onchange="mostrarStock(this)">
                    <option disabled selected value="">Seleccione un medicamento</option>
                    <?php if (!empty($medicamentos)): ?>
                        <?php foreach ($medicamentos as $medicamento): ?>
                            <option value="<?= $medicamento['id_medicamento'] ?>" data-stock="<?= $medicamento['cant_stock'] ?>">
                                <?= htmlspecialchars($medicamento['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">No hay medicamentos disponibles</option>
                    <?php endif; ?>
                </select>
            </td>
            <td class="border"><input type="text" name="dosis[]" placeholder="Dosis" class="w-full p-1"></td>
            <td class="border"><input type="text" name="frecuencia[]" placeholder="Frecuencia" class="w-full p-1"></td>
            <td class="border"><input type="text" name="duracion[]" placeholder="Duración" class="w-full p-1"></td>
            <td class="border">
                <input type="text" name="stock[]" readonly class="w-full p-1" placeholder="Stock">
            </td>
        `;

        // Agregar la fila al tbody
        tbody.appendChild(newRow);
    }
</script>



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
    <script src="/Gestion_clinica/app/views/Js/Doctor/historial.js"></script>
    <script src="/Gestion_clinica/detalles_cita_js"></script>
    <script>
    document.getElementById("volverBtn").addEventListener("click", function() {
        window.location.href = "/Gestion_clinica/home_medico";
    });
</script>

</body>

</html>