document.addEventListener("DOMContentLoaded", function () {
    // Obtener id_paciente desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const id_paciente = urlParams.get("id_paciente");

    if (!id_paciente) {
        document.getElementById("mensajeError").innerText = "ID del paciente no proporcionado.";
        return;
    }

    // Realizar la solicitud para obtener los datos del historial médico
    fetch(`/Gestion_clinica/app/controllers/HistorialController.php?action=obtenerPorCedula&cedula=${id_paciente}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                mostrarDatosPersonales(data.data[0]); // Suponiendo que el primer elemento contiene los datos personales
                mostrarCitasMedicas(data.data); // Mostrar todas las citas médicas
            } else {
                document.getElementById("mensajeError").innerText =
                    data.message || "No se encontraron registros.";
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
        <p><strong>Nombre del paciente:</strong> ${data.nombre_paciente}</p>
        <p><strong>Cédula:</strong> ${data.cedula}</p>
        <p><strong>Fecha de nacimiento:</strong> ${new Date(data.fecha_nacimiento).toLocaleDateString()}</p>
        <p><strong>Teléfono:</strong> ${data.telefono}</p>
        <p><strong>Correo:</strong> ${data.correo_paciente}</p>
    `;
    document.getElementById("datosPersonales").innerHTML = datosPersonales;
}

// Función para mostrar las citas médicas del paciente
function mostrarCitasMedicas(citas) {
    const citasContainer = document.getElementById("citasMedicas");

    citasContainer.innerHTML = citas
        .map(
            (entry) => `
            <div class="bg-blue-100 p-4 rounded-lg mt-2">
                <p><strong>Médico asignado:</strong> ${entry.medico}</p>
                <p><strong>Fecha de la cita:</strong> ${new Date(entry.fecha_cita).toLocaleDateString()}</p>
                <p><strong>Diagnóstico:</strong> ${entry.diagnostico}</p>
                <p><strong>Tratamiento:</strong> ${entry.tratamiento}</p>
                <p><strong>Receta:</strong> ${entry.receta}</p>
                <p><strong>Exámenes:</strong> ${entry.examenes}</p>
                <p><strong>Observaciones:</strong> ${entry.recomendaciones}</p>
            </div>
        `
        )
        .join("");
}
