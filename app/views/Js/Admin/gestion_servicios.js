document.addEventListener("DOMContentLoaded", () => {
  loadServicios();

  document.getElementById("servicioForm").addEventListener("submit", saveServicio);
  document.getElementById("buscar").addEventListener("input", filterServicios);
});

function loadServicios() {
  fetch("../../controllers/ServicioController.php?action=obtenerTodos")
    .then((response) => response.json())
    .then((data) => {
      const tbody = document.getElementById("serviciosTbody");
      tbody.innerHTML = data
        .map(
          (servicio) => `
                <tr>
                    <td class="px-6 py-4 text-center">${servicio.id_servicio}</td>
                    <td class="px-6 py-4 text-center">${servicio.nombre_servicio}</td>
                    <td class="px-6 py-4 text-center">${servicio.descripcion}</td>
                    <td class="px-6 py-4 text-center">${servicio.costo}</td>
                    <td class="px-6 py-4 text-center">
                        <button class="text-blue-500 hover:underline" onclick="editServicio(${servicio.id_servicio})">Editar</button>
                        <button class="text-red-500 hover:underline" onclick="confirmDelete(${servicio.id_servicio})">Borrar</button>
                    </td>
                </tr>
            `
        )
        .join("");
    })
    .catch((error) => console.error("Error al cargar servicios:", error));
}

function saveServicio(event) {
  event.preventDefault();
  const formData = new FormData(document.getElementById("servicioForm"));
  // Log para verificar los datos del formulario

  const action = formData.get("id_servicio") ? "actualizar" : "agregar";
  console.log("accion: ", action);
  formData.append("action", action);

  fetch(`../../controllers/ServicioController.php?`, {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      console.log("Respuesta del servidor:", response);
      return response.json();
    })
    .then((data) => {
      console.log("Datos del servidor:", data); // Agrega esto para inspeccionar la respuesta
      if (data.success) {
        closeModal();
        loadServicios();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch((error) => console.error("Error al guardar servicio:", error));
}
// Confirmar eliminación de servicio
function confirmDelete(id) {
  // Almacena el ID del servicio que se va a eliminar
  servicioIdToDelete = id;
  openConfirmModal();
}

// Modal de confirmación para eliminar servicio
let servicioIdToDelete;

function openConfirmModal() {
  document.getElementById("confirmModal").classList.remove("hidden");
}

function closeConfirmModal() {
  document.getElementById("confirmModal").classList.add("hidden");
}

// Eliminar servicio
document.getElementById("confirmDelete").addEventListener("click", function () {
  const formData = new FormData();
  formData.append("action", "borrar");
  formData.append("id_servicio", servicioIdToDelete);

  fetch(`../../controllers/ServicioController.php`, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        loadServicios();
        closeConfirmModal();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch((error) => console.error("Error al eliminar servicio:", error));
});

function editServicio(id) {
  fetch(`../../controllers/ServicioController.php?action=obtenerPorId&id_servicio=${id}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Si la respuesta es exitosa, carga los datos en el formulario
        const servicio = data.data; // Obtenemos el servicio

        // Cambiar el título del modal a "Editar Servicio"

        openModal();
        document.getElementById("modalTitle").innerText = "Editar Servicio";
        // Cargar los datos en los inputs del formulario
        document.getElementById("id_servicio").value = servicio.id_servicio; // ID del servicio
        document.getElementById("nombre_servicio").value = servicio.nombre_servicio; // Nombre
        document.getElementById("descripcion").value = servicio.descripcion; // Descripción
        document.getElementById("costo").value = servicio.costo; // Costo
      } else {
        alert("Error al cargar el servicio: " + data.message);
      }
    })
    .catch((error) => console.error("Error al cargar servicio para edición:", error));
}

function filterServicios() {
  const searchTerm = document.getElementById("buscar").value.toLowerCase();
  Array.from(document.getElementById("serviciosTbody").rows).forEach((row) => {
    row.style.display = row.innerText.toLowerCase().includes(searchTerm) ? "" : "none";
  });
}

function openModal() {
  document.getElementById("modal").classList.remove("hidden");
  document.getElementById("servicioForm").reset();
  document.getElementById("modalTitle").innerText = "Añadir Servicio";
}

function closeModal() {
  document.getElementById("modal").classList.add("hidden");
}
