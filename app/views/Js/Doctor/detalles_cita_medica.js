let idCita; // Variable global para almacenar el ID de la cita

document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  idCita = urlParams.get("id_cita");

  if (idCita) {
    obtenerDetallesCita(idCita); // Llama a la función para cargar los detalles de la cita
  } else {
    console.error("ID de cita no proporcionado en la URL.");
  }

  cargarServicios();
});

function cargarServicios() {
  fetch("../../controllers/DepartamentoController.php?action=obtenerTodos")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      if (data) {
        const selectServicios = document.getElementById("selectServicios");

        data.forEach((servicio) => {
          const option = document.createElement("option");
          option.value = servicio.id_departamento;
          option.textContent = servicio.nombre_departamento;
          selectServicios.appendChild(option);
        });
      } else {
        console.error("No se encontraron servicios en la respuesta");
      }
    })
    .catch((error) => {
      console.error("Error al cargar servicios:", error);
    });
}

// Función para obtener detalles de la cita
function obtenerDetallesCita(citaId) {
  idCita = citaId;
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
      <p><strong>Fecha de Nacimiento:</strong> ${new Date(
        data.fecha_nacimiento
      ).toLocaleDateString()}</p>
      <p><strong>Edad:</strong> ${data.edad} años</p>
  `;

  const expedienteForm = document.querySelector("form#verExpedienteForm");
  if (expedienteForm) {
    const inputPaciente = expedienteForm.querySelector("input[name='id_paciente']");
    if (inputPaciente) {
      inputPaciente.value = data.cedula;
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
    window.location.href = `historial_clinico.php?id_paciente=${cedula}`;
  } else {
    console.error("ID del paciente no proporcionado.");
  }
});

function actualizarEstadoCita(idCita, nuevoEstado) {
  fetch("../../controllers/CitaController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=actualizar&id_cita=${idCita}&nuevo_estado=${nuevoEstado}`,
  })
    .then((response) => {
      if (response.ok) {
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

// Función para guardar historial médico y actualizar estado de cita
function guardarHistorialMedico() {
  const data = {
    action: "agregar",
    cedula: document.querySelector("input[name='cedula']").value,
    id_cita: idCita,
    id_medico: document.querySelector("input[name='id_medico']").value,
    peso: document.querySelector("input[name='peso']").value,
    altura: document.querySelector("input[name='altura']").value,
    presion_arterial: document.querySelector("input[name='presion_arterial']").value,
    frecuencia_cardiaca: document.querySelector("input[name='frecuencia_cardiaca']").value,
    tipo_sangre: document.querySelector("input[name='tipo_sangre']").value,
    antecedentes_patologicos: Array.from(
      document.querySelectorAll("input[name='antecedentes_patologicos']:checked")
    ).map((input) => input.value),
    otros_antecedentes_patologicos: document.querySelector(
      "input[name='otros_antecedentes_patologicos']"
    ).value,
    antecedentes_no_patologicos: Array.from(
      document.querySelectorAll("input[name='antecedentes_no_patologicos']:checked")
    ).map((input) => input.value),
    otros_antecedentes_no_patologicos: document.querySelector(
      "input[name='otros_antecedentes_no_patologicos']"
    ).value,
    condicion_general: document.querySelector("textarea[name='condicion_general']").value,
    examenes_sangre: document.querySelector("textarea[name='examenes_sangre']").value,
    laboratorios: document.querySelector("textarea[name='laboratorios']").value,
    diagnostico: document.querySelector("textarea[name='diagnostico']").value,
    recomendaciones: document.querySelector("textarea[name='recomendaciones']").value,
    tratamiento: document.querySelector("textarea[name='tratamiento']").value,
    id_departamento_referencia: document.querySelector("select[name='id_departamento_referencia']")
      .value,
  };

  fetch("../../controllers/HistorialController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams(data),
  })
    .then((response) => response.json())
    .then((result) => {
      if (result.success) {
        actualizarEstadoCita(idCita, "Atendida");
        alert(result.message);
      } else {
        alert(result.message);
      }
    })
    .catch((error) => {
      console.error("Error al guardar el historial médico:", error);
      alert("Hubo un error al guardar el historial médico.");
    });
}

document.getElementById("guardarInformacionBtn").addEventListener("click", guardarHistorialMedico);
