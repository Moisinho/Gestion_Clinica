// detalles_cita_medica.js
let idCita; // Variable global para almacenar el ID de la cita

document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const idCita = urlParams.get('id_cita');
  if (idCita) {
    obtenerDetallesCita(idCita); // Llama a la función para cargar los detalles de la cita
  } else {
    console.error("ID de cita no proporcionado en la URL.");
  }
});



// Función para obtener detalles de la cita
function obtenerDetallesCita(citaId) {
  idCita = citaId; // Almacena el ID de la cita en la variable global
  fetch(`../../controllers/CitaController.php?action=obtenerDetallesCita&id_cita=${idCita}`)
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

// Función para mostrar detalles de la cita
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

  // Attempt to find the form with the action for the history controller
  const expedienteForm = document.querySelector("form#verExpedienteForm");
  
  if (expedienteForm) {
      const inputPaciente = expedienteForm.querySelector("input[name='id_paciente']");
      if (inputPaciente) {
          inputPaciente.value = data.cedula; // Set the cedula value
      } else {
          console.error("Input 'id_paciente' no encontrado en el formulario.");
      }
  } else {
      console.error("Formulario 'verExpedienteForm' no encontrado.");
  }
}


document.getElementById("verExpedienteBtn").addEventListener("click", function() {
  const cedula = document.querySelector("input[name='id_paciente']").value;
  
  if (cedula) {
      // Redirect to the history page with the cedula as a query parameter
      window.location.href = `historial_clinico.php?id_paciente=${cedula}`;
  } else {
      console.error("ID del paciente no proporcionado.");
  }
});


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
        throw new Error("Error al actualizar la cita.");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Error al actualizar la cita.");
    });
}
