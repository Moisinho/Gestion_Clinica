<?php

$id_cita = isset($_POST['id_cita']) ? $_POST['id_cita'] : 'No se recibió id_cita';

        

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Cobro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Ocultar todos los campos de pago inicialmente
        $("#campos-tarjeta, #campo-efectivo").hide();

        // Desactivar los campos inicialmente
        $('#campos-tarjeta input, #campos-tarjeta select').prop('required', false);
        $('#campo-efectivo input, #campo-efectivo select').prop('required', false);

        // Mostrar campos según el método de pago seleccionado y ajustar los atributos required
        $('input[name="metodo_pago"]').change(function() {
            if ($(this).val() === 'tarjeta') {
                // Mostrar los campos de tarjeta y activar required
                $("#campos-tarjeta").show();
                $("#campo-efectivo").hide();
                
                // Activar los campos de tarjeta y desactivar los de efectivo
                $('#campos-tarjeta input, #campos-tarjeta select').prop('required', true);
                $('#campo-efectivo input, #campo-efectivo select').prop('required', false);
            } else if ($(this).val() === 'efectivo') {
                // Mostrar los campos de efectivo y activar required
                $("#campo-efectivo").show();
                $("#campos-tarjeta").hide();

                // Activar los campos de efectivo y desactivar los de tarjeta
                $('#campo-efectivo input, #campo-efectivo select').prop('required', true);
                $('#campos-tarjeta input, #campos-tarjeta select').prop('required', false);
            }
        });
    });
</script>

</head>
<body class="flex h-[100vh] font-serif justify-center items-center bg-[#A9A1D4]">
    <div class="flex flex-col bg-white p-4 w-[75vh] h-[85vh] rounded-md shadow-xl border border-black-600 text-center overflow-y-auto">
        <h2 class="text-2xl font-bold mb-4">Registrar Cobro</h2>
        <form action="../../controllers/procesar_factura.php" method="post" id="form-cobro">
            <input type="hidden" id="id_cita" name="id_cita" value="<?php echo htmlspecialchars($id_cita);?>">
                <!-- Método de pago -->
                <div class="mx-16 mb-4">
                    <h3 class="text-left text-lg font-semibold mb-2">Método de Pago:</h3>
                    <div class="flex items-center">
                        <input type="radio" id="tarjeta" name="metodo_pago" value="tarjeta" class="mr-2" required>
                        <label for="tarjeta" class="text-md">Tarjeta</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="efectivo" name="metodo_pago" value="efectivo" class="mr-2" required>
                        <label for="efectivo" class="text-md">Efectivo</label>
                    </div>
                </div>

                <!-- Campos para Tarjeta -->
                <div id="campos-tarjeta" class="mx-16 mb-4">
                    
                    <label class="mb-2 mt-8 block text-left text-md font-bold" for="monto_tarjeta">Monto:</label>
                    <input class="bg-[#E5E8ED] p-2 w-full mb-2" type="number" id="monto_tarjeta" name="monto_tarjeta" placeholder="Ingrese monto" required>

                    <label class="mb-2 block text-left text-md font-bold" for="detalles_tarjeta">Detalles:</label>
                    <select class="bg-[#E5E8ED] p-2 w-full mb-2" id="detalles_tarjeta" name="detalles_tarjeta" required>
                        <option value="">Seleccione un diagnóstico</option>
                        <?php
                            require_once '../../includes/Database.php'; // Incluir la conexión a la base de datos

                            // Crear una instancia de la clase Database y obtener la conexión
                            $database = new Database();
                            $conn = $database->getConnection();

                            // Consulta para obtener todas las marcas
                            $stmt = $conn->prepare("SELECT DISTINCT diagnostico FROM cita");
                            $stmt->execute();

                            // Generar las opciones del combobox de marcas
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . htmlspecialchars($row['diagnostico']) . "'>" . htmlspecialchars($row['diagnostico']) . "</option>";
                            }
                        ?>
                    </select>

                    <label class="mb-2  block text-left text-md font-bold" for="numero_tarjeta">Número de Tarjeta:</label>
                    <input class="bg-[#E5E8ED] p-2 w-full mb-2" type="text" id="numero_tarjeta" name="numero_tarjeta" placeholder="Ingrese número de tarjeta" required>

                    <label class="mb-2 block text-left text-md font-bold" for="nombre_propietario">Nombre del Propietario:</label>
                    <input class="bg-[#E5E8ED] p-2 w-full mb-2" type="text" id="nombre_propietario" name="nombre_propietario" placeholder="Ingrese nombre del propietario" required>

                    <label class="mb-2 block text-left text-md font-bold" for="fecha_vencimiento">Fecha de Vencimiento:</label>
                    <input class="bg-[#E5E8ED] p-2 w-full mb-2" type="month" id="fecha_vencimiento" name="fecha_vencimiento" required>

                    <label class="mb-2 block text-left text-md font-bold" for="cvv">CVV:</label>
                    <input class="bg-[#E5E8ED] p-2 w-full mb-2" maxlength="3" type="text" id="cvv" name="cvv" placeholder="Ingrese CVV" required>

                </div>

                <!-- Campo para Efectivo -->
                <div id="campo-efectivo" class="mx-16 mb-4">
                    <label class="mb-2 mt-8 block text-left text-md font-bold" for="monto_efectivo">Monto:</label>
                    <input class="bg-[#E5E8ED] p-2 w-full mb-12" type="number" id="monto_efectivo" name="monto_efectivo" placeholder="Ingrese monto" required>

                    <label class="mb-2 block text-left text-md font-bold" for="detalles_efectivo">Detalles:</label>
                    <select class="bg-[#E5E8ED] p-2 w-full mb-2" id="detalles_efectivo" name="detalles_efectivo" required>
                    <option value="">Seleccione un diagnóstico</option>
                        <?php
                            require_once '../../includes/Database.php'; // Incluir la conexión a la base de datos

                            // Crear una instancia de la clase Database y obtener la conexión
                            $database = new Database();
                            $conn = $database->getConnection();

                            // Consulta para obtener todas las marcas
                            $stmt = $conn->prepare("SELECT DISTINCT diagnostico FROM cita");
                            $stmt->execute();

                            // Generar las opciones del combobox de marcas
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . htmlspecialchars($row['diagnostico']) . "'>" . htmlspecialchars($row['diagnostico']) . "</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="mx-32">
                    <input class="bg-[#6A62D2] text-white p-2 w-full hover:cursor-pointer hover:bg-[#5852A7]" type="submit" id="registrar" value="Registrar">
                </div>
        </form>
    </div>
</body>
</html>
