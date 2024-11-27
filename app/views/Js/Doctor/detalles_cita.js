let idCita; // Variable global para almacenar el ID de la cita
let cedulaPaciente;
let idMedico;
document.addEventListener("DOMContentLoaded", function () {
  obtenerIdMedico(id_usuario);
  const urlParams = new URLSearchParams(window.location.search);
  idCita = urlParams.get("id_cita"); // Obtén el id_cita de la URL
  if (idCita) {
    obtenerDetallesCita(idCita); // Llama a la función para cargar los detalles de la cita
  } else {
    console.error("ID de cita no proporcionado en la URL.");
  }
  cargarServicios();

  const guardarBtn = document.getElementById("guardarHistorialBtn");

  // Añadir un event listener al botón para capturar el click
  guardarBtn.addEventListener("click", function (event) {
    // Prevenir el comportamiento por defecto del botón (si está dentro de un formulario)
    event.preventDefault();

    // Llamar a la función que guarda el historial médico
    guardarHistorialMedico();
  });
});

function obtenerIdMedico(id_usuario) {
  fetch(
    `/Gestion_clinica/app/controllers/MedicoController.php?action=obtenerMedicoPorUsuario&id_usuario=${id_usuario}`
  )
    .then((response) => response.json())
    .then((data) => {
      if (data) {
        idMedico = data.id_medico;
      } else {
        console.error("No se encontro id en la respuesta");
      }
    })
    .catch((error) => {
      console.error("Error al cargar id:", error);
    });
}

// Función para obtener detalles de la cita
function obtenerDetallesCita(citaId) {
  console.log(citaId);
  fetch(
    `/Gestion_clinica/app/controllers/CitaController.php?action=obtenerDetallesCita&id_cita=${citaId}`
  )
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error al obtener los detalles de la cita");
      }
      return response.json();
    })
    .then((data) => {
      cedulaPaciente = data.cedula;
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
    <p><strong>Fecha de Nacimiento:</strong> ${new Date(
      data.fecha_nacimiento
    ).toLocaleDateString()}</p>
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
    window.location.href = `/Gestion_clinica/historial_medico?id_paciente=${cedula}`;
  } else {
    console.error("ID del paciente no proporcionado.");
  }
});

// Función para obtener el historial médico por cédula
function obtenerHistorialPorCedula(cedula) {
  fetch(
    `/Gestion_clinica/app/controllers/HistorialController.php?action=obtenerPorCedula&cedula=${cedula}`
  )
    .then((response) => response.json())
    .then((data) => {
      if (Array.isArray(data)) {
        mostrarHistorialPaciente(data);
      } else {
        console.log(data.message || "No se encontraron registros para esta cédula.");
      }
    })
    .catch((error) => console.error("Error:", error));
}

function cargarServicios() {
  fetch("app/controllers/DepartamentoController.php?action=obtenerTodos")
    .then((response) => response.json())
    .then((data) => {
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

function obtenerMedicamentos() {
  const filas = document.querySelectorAll("#receta-body tr");

  const medicamento = [];
  const dosis = [];
  const frecuencia = [];
  const duracion = [];

  filas.forEach((fila) => {
    const selectMedicamento = fila.querySelector("select[name='medicamento[]']");
    const medicamentoInput = selectMedicamento.selectedOptions[0]?.text.trim(); // Captura el nombre visible
    const dosisInput = fila.querySelector("input[name='dosis[]']").value;
    const frecuenciaInput = fila.querySelector("input[name='frecuencia[]']").value;
    const duracionInput = fila.querySelector("input[name='duracion[]']").value;

    if (medicamentoInput && medicamentoInput !== "Seleccione un medicamento") {
      medicamento.push(medicamentoInput); // Captura el nombre
      dosis.push(dosisInput || "--");
      frecuencia.push(frecuenciaInput || "--");
      duracion.push(duracionInput || "--");
    }
  });

  // Devolver los campos en singular
  return {
    medicamento: medicamento,
    dosis: dosis,
    frecuencia: frecuencia,
    duracion: duracion,
  };
}

function guardarHistorialMedico() {
  // Recoger y asignar valores predeterminados
  const data = {
    action: "agregar",
    cedula: cedulaPaciente,
    id_cita: idCita,
    id_medico: idMedico,
    peso: document.querySelector("input[name='peso']").value.trim() || "Sin especificar",
    altura: document.querySelector("input[name='altura']").value.trim() || "Sin especificar",
    presion_arterial:
      document.querySelector("input[name='presion_arterial']").value.trim() || "Sin especificar",
    frecuencia_cardiaca:
      document.querySelector("input[name='frecuencia_cardiaca']").value.trim() || "Sin especificar",
    tipo_sangre: document.getElementById("tipo_sangre").value || "Sin especificar",

    antecedentes_personales: Array.from(
      document.querySelectorAll("input[name='antecedentes_patologicos[]']:checked")
    ).map((input) => input.value),

    otros_antecedentes:
      document.getElementById("otros_antecedentes_patologicos").value.trim() || "Sin especificar",

    antecedentes_no_patologicos: Array.from(
      document.querySelectorAll("input[name='antecedentes_no_patologicos[]']:checked")
    ).map((input) => input.value),

    otros_antecedentes_no_patologicos:
      document.getElementById("otros_antecedentes_no_patologicos").value.trim() ||
      "Sin especificar",

    condicion_general:
      document.querySelector("textarea[name='condicion_general']").value.trim() ||
      "Sin especificar",
    examenes:
      document.querySelector("textarea[name='examenes_sangre']").value.trim() || "Sin especificar",
    laboratorios:
      document.querySelector("textarea[name='laboratorios']").value.trim() || "Sin especificar",
    diagnostico:
      document.querySelector("textarea[name='diagnostico']").value.trim() || "Sin especificar",
    tratamiento:
      document.querySelector("textarea[name='tratamiento']").value.trim() || "Sin especificar",
    id_departamento_referencia: document.getElementById("selectServicios").value || "0",

    ...obtenerMedicamentos(), // Agregar medicamentos, dosis, frecuencia y duración
  };

  // Enviar los datos mediante fetch
  fetch("app/controllers/GestionController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((responseData) => {
      if (responseData.error) {
        console.error("Error del servidor:", responseData.error);
        alert("Error al guardar: " + responseData.error);
      } else {
        // Mostrar una alerta de éxito si la operación fue correcta
        // Opcional: Recargar la página o redirigir a otra vista
        // location.reload();
      }
    })
    .catch((error) => {
      alert("La cita se ha atendido correctamente en el sistema.");
    });
}
