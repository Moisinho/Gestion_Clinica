let idCita; // Variable global para almacenar el ID de la cita

document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  idCita = urlParams.get('id_cita'); // Obtén el id_cita de la URL
  if (idCita) {
    obtenerDetallesCita(idCita); // Llama a la función para cargar los detalles de la cita
  } else {
    console.error("ID de cita no proporcionado en la URL.");
  }
});

// Función para obtener detalles de la cita
function obtenerDetallesCita(citaId) {
  fetch(`/Gestion_clinica/app/controllers/CitaController.php?action=obtenerDetallesCita&id_cita=${citaId}`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error al obtener los detalles de la cita");
      }
      return response.json();
    })
    .then((data) => {
      mostrarDetallesCita(data);
      mostrarInformacionPaciente(data);
    })
    .catch((error) => {
      console.error("Error al obtener los detalles de la cita:", error);
      alert("No se pudieron obtener los detalles de la cita. Inténtalo más tarde.");
    });
}

function mostrarDetallesCita(data) {
  const citaInfo = document.getElementById("cita-info");
  citaInfo.innerHTML = `
    <p><strong>Motivo:</strong> ${data.motivo}</p>
    <p><strong>Fecha de Cita:</strong> ${data.fecha_cita}</p>
  `;
}

function mostrarInformacionPaciente(data) {
  const pacienteInfo = document.getElementById("paciente-info");
  pacienteInfo.innerHTML = `
    <p><strong>Nombre:</strong> ${data.nombre_paciente}</p>
    <p><strong>Cédula:</strong> ${data.cedula}</p>
    <p><strong>Teléfono:</strong> ${data.telefono}</p>
    <p><strong>Correo:</strong> ${data.correo_paciente}</p>
    <p><strong>Fecha de Nacimiento:</strong> ${new Date(data.fecha_nacimiento).toLocaleDateString()}</p>
    <p><strong>Edad:</strong> ${data.edad} años</p>
  `;

  // Asignar la cédula al input oculto para poder enviarlo con el formulario
  const expedienteForm = document.querySelector("form#verExpedienteForm");
  if (expedienteForm) {
    const inputPaciente = expedienteForm.querySelector("input[name='id_paciente']");
    if (inputPaciente) {
      inputPaciente.value = data.cedula; // Asigna la cédula al campo del formulario
    } else {
      console.error("Input 'id_paciente' no encontrado en el formulario.");
    }
  } else {
    console.error("Formulario 'verExpedienteForm' no encontrado.");
  }
}

document.getElementById("verExpedienteBtn").addEventListener("click", function () {
  const cedula = document.querySelector("input[name='id_paciente']").value;

  if (cedula) {
    console.log("Cédula del paciente:", cedula); // Verifica que se está obteniendo la cédula correctamente
    window.location.href = `/Gestion_clinica/historial_medico?id_paciente=${cedula}`;

  } else {
    console.error("ID del paciente no proporcionado.");
  }
});

// Función para obtener el historial médico por cédula
function obtenerHistorialPorCedula(cedula) {
  fetch(`/Gestion_clinica/app/controllers/HistorialController.php?action=obtenerPorCedula&cedula=${cedula}`)
    .then(response => response.json())
    .then(data => {
      if (Array.isArray(data)) {
        mostrarHistorialPaciente(data);
      } else {
        console.log(data.message || "No se encontraron registros para esta cédula.");
      }
    })
    .catch(error => console.error('Error:', error));
}
