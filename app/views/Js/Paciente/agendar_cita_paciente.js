document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("reserva-cita-form");
  const servicioSelect = document.getElementById("servicio");

  // Cargar servicios y médicos al cargar la página
  cargarServicios();
  cargarMedico();

  // Evento para cargar médicos cuando se selecciona un servicio
  servicioSelect.addEventListener("change", function () {
    const idServicio = this.value; // Obtener el servicio seleccionado
    if (idServicio) {
      cargarMedicosPorServicio(idServicio); // Llamar a la función para cargar médicos
    } else {
      cargarMedico(); // Cargar todos los médicos si no se selecciona un servicio
    }
  });
});

function cargarServicios() {
  fetch("../../controllers/ServicioController.php?action=obtenerTodos")
    .then((response) => response.json())
    .then((data) => {
      const servicioSelect = document.getElementById("servicio");
      servicioSelect.innerHTML = `<option value="">Seleccione un servicio</option>`; // Opción por defecto

      if (data.length === 0) {
        servicioSelect.innerHTML += `<option value="">No hay servicios disponibles</option>`;
      } else {
        data.forEach((servicio) => {
          servicioSelect.innerHTML += `<option value="${servicio.id_servicio}">${servicio.nombre_servicio}</option>`;
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function cargarMedico() {
  fetch("../../controllers/MedicoController.php?action=obtenerTodos")
    .then((response) => response.json())
    .then((data) => {
      const medicoSelect = document.getElementById("medico");
      medicoSelect.innerHTML = "";

      if (data.length === 0) {
        medicoSelect.innerHTML = `<option value="">No hay médicos disponibles</option>`;
      } else {
        data.forEach((medico) => {
          medicoSelect.innerHTML += `<option value="${medico.id_medico}">${medico.nombre_medico}</option>`;
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function cargarMedicosPorServicio(idServicio) {
  fetch(
    `../../controllers/MedicoController.php?action=obtenerPorServicio&id_servicio=${idServicio}`
  )
    .then((response) => response.json())
    .then((data) => {
      const medicoSelect = document.getElementById("medico");
      medicoSelect.innerHTML = "";

      if (data.length === 0) {
        medicoSelect.innerHTML = `<option value="">No hay médicos disponibles para este servicio</option>`;
      } else {
        data.forEach((medico) => {
          medicoSelect.innerHTML += `<option value="${medico.id_medico}">${medico.nombre_medico}</option>`;
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
