<?php
require_once '../../models/Medicamento.php';
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
    <title>Registro y Actualización de Medicamentos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col">
    <?php include('../../includes/header_farmacia.php'); ?>
    
    <div class="container mx-auto p-5 flex-grow">
        <div class="bg-purple-300 p-5 rounded-lg shadow-md mt-8">
            <h2 class="text-2xl font-bold mb-4 text-white">Registrar nuevos Medicamentos</h2>

            <!-- Formulario para agregar un nuevo medicamento -->
            <form method="POST" id="formularioMedicamento" class="bg-white p-5 rounded-lg shadow-md mb-8">
                <h3 class="text-xl font-semibold mb-4">Añadir Nuevo Medicamento</h3>
                <input type="hidden" name="accion" value="agregar">
                
                <label class="block mb-2">Nombre del Medicamento:</label>
                <input type="text" name="nombre" required class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg">
                
                <label class="block mb-2">Descripción:</label>
                <textarea name="descripcion" required class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                
                <label class="block mb-2">Cantidad en Stock:</label>
                <input type="number" name="cantidad" required class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg">
                
                <label class="block mb-2">Precio:</label>
                <input type="number" step="0.01" name="precio" required class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg">
                
                <button type="submit" class="bg-purple-600 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-purple-700">Guardar</button>
            </form>
            <h2 class="text-2xl font-bold mb-4 text-white">Editar información de Medicamentos</h2>
            <div class="bg-white p-5 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-4">Medicamentos Registrados</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Precio</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="lista-medicamentos" class="bg-white divide-y divide-gray-200"> 
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="updateModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative">
            <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-800" onclick="closeUpdateModal()">&times;</button>
            <h2 class="text-xl font-semibold mb-4">Actualizar Medicamento</h2>
            <form id="formulario-actualizar-medicamento">
                <input type="hidden" name="id" id="updateId">
                
                <label class="block mb-2">Nombre del Medicamento:</label>
                <input type="text" name="nombre" id="updateNombre" required class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg">
                
                <label class="block mb-2">Descripción:</label>
                <textarea name="descripcion" id="updateDescripcion" required class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                
                <label class="block mb-2">Cantidad en Stock:</label>
                <input type="number" name="cantidad" id="updateCantidad" required class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg">
                
                <label class="block mb-2">Precio:</label>
                <input type="number" step="0.01" name="precio" id="updatePrecio" required class="w-full mb-4 px-4 py-2 border border-gray-300 rounded-lg">
                
                <button type="button" class="bg-purple-600 text-white font-semibold px-4 py-2 mt-4 rounded-lg shadow hover:bg-purple-700" onclick="actualizarMedicamento()">Actualizar</button>
            </form>
        </div>
    </div>
    <script>
    fetch('../../controllers/MedicamentoController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // Cambia a text() para la depuración
        })
        .then(data => {
            console.log('Raw response:', data); // Log para ver la respuesta sin procesar
            try {
                const jsonData = JSON.parse(data); // Intentar analizar el JSON
                if (jsonData.error) {
                    throw new Error(jsonData.error); // Lanza un error si hay uno en la respuesta JSON
                }
                renderMedicamentos(jsonData);
            } catch (e) {
                console.error('Error al analizar JSON:', e);
                alert('Error al cargar medicamentos: ' + e.message);
            }
        })
        .catch(error => console.error('Error al cargar medicamentos:', error));

        function renderMedicamentos(medicamentos) {
        const listaMedicamentos = document.getElementById('lista-medicamentos'); // Asegúrate de que este ID coincida con tu HTML
        listaMedicamentos.innerHTML = ''; // Limpiar la lista

        medicamentos.forEach(medicamento => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-6 py-4 text-center">${medicamento.id_medicamento}</td>
                <td class="px-6 py-4 text-center">${medicamento.nombre}</td>
                <td class="px-6 py-4 text-center">${medicamento.descripcion}</td>
                <td class="px-6 py-4 text-center">${medicamento.cant_stock}</td>
                <td class="px-6 py-4 text-center">${medicamento.precio}</td>
                <td class="px-6 py-4 text-center">
                    <button class="text-blue-500" onclick="openUpdateModal(${medicamento.id_medicamento})">Editar</button>
                </td>
            `;
            listaMedicamentos.appendChild(row); // Cambiado de tbody a listaMedicamentos
        });
    }
    function openUpdateModal(id) {
        // Realiza una solicitud para obtener los detalles del medicamento
        fetch(`../../controllers/MedicamentoController.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data && !data.error) {
                    // Llenar el formulario con los datos del medicamento
                    document.getElementById('updateId').value = data.id_medicamento;
                    document.getElementById('updateNombre').value = data.nombre;
                    document.getElementById('updateDescripcion').value = data.descripcion;
                    document.getElementById('updateCantidad').value = data.cant_stock;
                    document.getElementById('updatePrecio').value = data.precio;

                    // Mostrar el modal
                    document.getElementById('updateModal').classList.remove('hidden');
                } else {
                    alert('Error al cargar los datos del medicamento.');
                }
            })
            .catch(error => {
                console.error('Error al obtener datos:', error);
                alert('Error al cargar medicamento.');
            });
    }

    function closeUpdateModal() {
        document.getElementById('updateModal').classList.add('hidden');
    }
    function actualizarMedicamento() {
        const formData = new FormData(document.getElementById("formulario-actualizar-medicamento"));
        formData.append("accion", "actualizar");

        fetch('../../controllers/MedicamentoController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(responseData => {
            if (responseData.message) {
                Swal.fire({
                    title: 'Éxito',
                    text: responseData.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    closeUpdateModal();  // Cerrar el modal después de la actualización
                    location.reload(); // Recargar la página para ver la actualización en la tabla
                });
            } else if (responseData.error) {
                Swal.fire({
                    title: 'Error',
                    text: responseData.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error al actualizar el medicamento:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al actualizar el medicamento.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
    document.getElementById("formularioMedicamento").addEventListener("submit", function(e) {
        e.preventDefault(); // Esto evita que el formulario recargue la página

        // Aquí va el código para enviar el formulario con fetch
        const formData = new FormData(this);

        fetch('../../controllers/MedicamentoController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta:", data); // Esto debería mostrar la respuesta del servidor
            if (data.message) {
                Swal.fire({
                    title: 'Éxito',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            } else if (data.error) {
                Swal.fire({
                    title: 'Error',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => console.error("Error:", error));
    });


    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
