// detalles_cita_medica
document.addEventListener("DOMContentLoaded", function () {
  const idCita = 1; // Cambia esto según cómo obtienes el ID
  obtenerDetallesCita(idCita);

  const btnFinalizarCita = document.getElementById("finalizar-cita-btn");
  const form = document.getElementById("actualizar-cita-form");

  // Manejar el evento de clic para finalizar la cita
  btnFinalizarCita.addEventListener("click", function () {
    const nuevoEstado = form.nuevo_estado.value; // El nuevo estado
    actualizarEstadoCita(idCita, nuevoEstado);
  });
});

// Función para obtener detalles de la cita
function obtenerDetallesCita(idCita) {
  fetch(`../../controllers/CitaController.php?action=obtenerDetallesCita&id_cita=${idCita}`)
    .then((response) => response.json())
    .then((data) => {
      mostrarDetallesCita(data);
      mostrarInformacionPaciente(data);
    })
    .catch((error) => {
      console.error("Error al obtener los detalles de la cita:", error);
    });
}

// Función para mostrar detalles de la cita
function mostrarDetallesCita(data) {
  const citaInfo = document.getElementById("cita-info");
  citaInfo.innerHTML = `
            <p><strong>Motivo:</strong> ${data.motivo}</p>
            <p><strong>Fecha de Cita:</strong> ${data.fecha_cita}</p>
        `;
}

// Función para mostrar información del paciente
function mostrarInformacionPaciente(data) {
  const pacienteInfo = document.getElementById("paciente-info");
  pacienteInfo.innerHTML = `
            <p><strong>Nombre:</strong> ${data.nombre_paciente}</p>
            <p><strong>Cédula:</strong> ${data.cedula}</p>
            <p><strong>Teléfono:</strong> ${data.telefono}</p>
            <p><strong>Correo:</strong> ${data.correo_paciente}</p>
            <p><strong>Fecha de Nacimiento:</strong> ${new Date(
              data.fecha_nacimiento
            ).toLocaleDateString()}</p>
            <p><strong>Edad:</strong> ${data.edad} años</p>
        `;
}

function actualizarEstadoCita(idCita, nuevoEstado) {
  // Verificar que se reciba el idCita correcto
  console.log("ID de Cita:", idCita);
  console.log("Nuevo Estado:", nuevoEstado);

  fetch("../../controllers/CitaController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=actualizar&id_cita=${idCita}&nuevo_estado=${nuevoEstado}`,
  })
    .then((response) => {
      if (response.ok) {
        // Redirige a la página de inicio si la actualización fue exitosa
        window.location.href = "../Doctor/medico_inicio.php";
      } else {
        alert("Error al actualizar la cita.");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Error al actualizar la cita.");
    });
}
