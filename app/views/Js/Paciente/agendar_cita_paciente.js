document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("reserva-cita-form");

  cargarMedico();
});

function cargarMedico() {
  fetch("../../controllers/MedicoController.php?action=obtenerTodos")
    .then((response) => response.json())
    .then((data) => {
      const medicoSelect = document.getElementById("medico");
      console.log(data);
      medicoSelect.innerHTML = "";

      if (data.length === 0) {
        medicoSelect.innerHTML = `<option value="">No hay médicos disponibles</option>`;
      } else {
        data.forEach((data) => {
          medicoSelect.innerHTML += `<option value="${data.id_medico}">${data.nombre_medico}</option>`;
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
