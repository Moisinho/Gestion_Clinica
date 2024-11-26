let idCita; // Variable global para almacenar el ID de la cita
let cedulaPaciente;
let idMedico;
document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM CARGADO");
  console.log("ID USUARIO: ", id_usuario);
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
        console.log("ID MEDICO: ", idMedico);
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
    console.log("Cédula del paciente:", cedula); // Verifica que se está obteniendo la cédula correctamente
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
        console.log("Departamentos cargados");
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

  const medicamentos = [];
  const dosis = [];
  const frecuencias = [];
  const duraciones = [];

  filas.forEach((fila) => {
    const selectMedicamento = fila.querySelector("select[name='medicamento[]']");
    const medicamento = selectMedicamento.selectedOptions[0]?.text.trim(); // Captura el nombre visible
    const dosisInput = fila.querySelector("input[name='dosis[]']").value;
    const frecuenciaInput = fila.querySelector("input[name='frecuencia[]']").value;
    const duracionInput = fila.querySelector("input[name='duracion[]']").value;

    if (medicamento && medicamento !== "Seleccione un medicamento") {
      medicamentos.push(medicamento); // Captura el nombre
      dosis.push(dosisInput || "--");
      frecuencias.push(frecuenciaInput || "--");
      duraciones.push(duracionInput || "--");
    }
  });

  return { medicamentos, dosis, frecuencias, duraciones };
}

function guardarHistorialMedico() {
  // Asignar "--" a los textareas vacíos
  document.querySelectorAll("textarea").forEach((textarea) => {
    if (textarea.value.trim() === "") {
      textarea.value = "Sin especificar"; // Valor por defecto
    }
  });

  const { medicamentos, dosis, frecuencias, duraciones } = obtenerMedicamentos();

  // Recoger los datos del formulario
  const data = {
    action: "agregar",
    cedula: cedulaPaciente,
    id_cita: idCita,
    id_medico: idMedico,
    peso: document.querySelector("input[name='peso']").value,
    altura: document.querySelector("input[name='altura']").value,
    presion_arterial: document.querySelector("input[name='presion_arterial']").value,
    frecuencia_cardiaca: document.querySelector("input[name='frecuencia_cardiaca']").value,
    tipo_sangre: document.getElementById("tipo_sangre").value,

    antecedentes_patologicos:
      Array.from(document.querySelectorAll("input[name='antecedentes_patologicos[]']:checked")).map(
        (input) => input.value
      ) || [],

    otros_antecedentes_patologicos: document.getElementById("otros_antecedentes_patologicos").value,

    antecedentes_no_patologicos:
      Array.from(
        document.querySelectorAll("input[name='antecedentes_no_patologicos[]']:checked")
      ).map((input) => input.value) || [],

    otros_antecedentes_no_patologicos: document.getElementById("otros_antecedentes_no_patologicos")
      .value,

    condicion_general: document.querySelector("textarea[name='condicion_general']").value,
    examenes_sangre: document.querySelector("textarea[name='examenes_sangre']").value,
    laboratorios: document.querySelector("textarea[name='laboratorios']").value,
    diagnostico: document.querySelector("textarea[name='diagnostico']").value,
    tratamiento: document.querySelector("textarea[name='tratamiento']").value,
    id_departamento_referencia: document.getElementById("selectServicios").value,

    medicamento: medicamentos,
    dosis: dosis,
    frecuencia: frecuencias,
    duracion: duraciones,
  };

  console.log("Info: ", data); // Para depuración
  alert("DATOS");
  // Enviar los datos mediante fetch
  fetch("app/controllers/GestionController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json", // Cambiar a application/json
    },
    body: JSON.stringify(data), // Convertir datos a JSON
  })
    .then((response) => response.text()) // Usar .text() en lugar de .json() para ver el contenido crudo
    .then((text) => {
      console.log("Respuesta del servidor:", text);
      try {
        const responseData = JSON.parse(text); // Intenta analizar la respuesta
        console.log("Respuesta JSON:", responseData);
      } catch (e) {
        console.error("Error al analizar la respuesta:", e);
      }
    })
    .catch((error) => {
      console.error("Error al guardar el historial médico:", error);
      alert("Hubo un error al guardar el historial médico.");
    });
}
