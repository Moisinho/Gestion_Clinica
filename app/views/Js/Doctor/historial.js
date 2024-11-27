document.addEventListener("DOMContentLoaded", function () {
  // Obtener id_paciente desde la URL
  const urlParams = new URLSearchParams(window.location.search);
  const id_paciente = urlParams.get("id_paciente");

  if (!id_paciente) {
    document.getElementById("mensajeError").innerText = "ID del paciente no proporcionado.";
    return;
  }

  // Realizar la solicitud para obtener los datos del historial médico
  fetch(
    `/Gestion_clinica/app/controllers/HistorialController.php?action=obtenerPorCedula&cedula=${id_paciente}`
  )
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la respuesta del servidor");
      }
      return response.json();
    })
    .then((data) => {
      console.log(data); // Verificar la estructura
      if (data.success) {
        if (data.paciente) {
          mostrarDatosPersonales(data.paciente);
        } else {
          document.getElementById("mensajeError").innerText =
            "No se encontraron datos del paciente.";
        }

        if (data.historial && data.historial.length > 0) {
          mostrarCitasMedicas(data.historial);
        } else {
          document.getElementById("citasMedicas").innerHTML =
            "<p>No se encontraron citas médicas registradas para este paciente.</p>";
        }
      } else {
        document.getElementById("mensajeError").innerText =
          data.error || "No se encontraron registros.";
      }
    })
    .catch((error) => {
      console.error("Error al obtener el historial médico:", error);
      document.getElementById("mensajeError").innerText =
        "Ocurrió un error al cargar el historial clínico.";
    });
});

// Función para mostrar los datos personales del paciente
function mostrarDatosPersonales(data) {
  const datosPersonales = `
    <p><strong>Nombre del paciente:</strong> ${data.nombre_paciente || "N/A"}</p>
    <p><strong>Cédula:</strong> ${data.cedula || "N/A"}</p>
    <p><strong>Fecha de nacimiento:</strong> ${
      data.fecha_nacimiento ? new Date(data.fecha_nacimiento).toLocaleDateString() : "N/A"
    }</p>
    <p><strong>Teléfono:</strong> ${data.telefono || "N/A"}</p>
    <p><strong>Correo:</strong> ${data.correo_paciente || "N/A"}</p>
`;

  document.getElementById("datosPersonales").innerHTML = datosPersonales;
}
