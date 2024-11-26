function buildCalendar() {
  const date = new Date();
  const month = date.getMonth();
  const year = date.getFullYear();
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const today = date.getDate();

  // Mostrar el mes y el año
  document.getElementById("monthYear").innerText = `${date.toLocaleString("es-ES", {
    month: "long",
  })} ${year}`;

  const calendarDays = document.getElementById("calendarDays");
  calendarDays.innerHTML = ""; // Limpiar días anteriores

  // Espacios en blanco para los días antes del inicio del mes
  for (let i = 0; i < firstDay; i++) {
    const emptyCell = document.createElement("div");
    calendarDays.appendChild(emptyCell);
  }

  // Días del mes
  for (let day = 1; day <= daysInMonth; day++) {
    const dayCell = document.createElement("div");
    dayCell.className = "text-center p-2 rounded-full bg-white hover:bg-gray-300 cursor-pointer";
    dayCell.innerText = day;

    // Agregar atributo data-date
    const formattedDate = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
    dayCell.setAttribute("data-date", formattedDate);

    if (day === today) {
      dayCell.classList.add("today");
    }

    // Evento para cargar citas al hacer clic en un día
    dayCell.addEventListener("click", () => {
      loadCitas(formattedDate);  // Cargar citas para el día seleccionado
    });

    calendarDays.appendChild(dayCell);
  }
}

// Función para cargar citas por día
function loadCitas(fechaFiltro = "") {
  console.log("Cargando citas para la fecha:", fechaFiltro); // Depuración
  const citasBody = document.getElementById("contenedorCitas");
  const url = '/Gestion_clinica/app/controllers/CitaController.php?action=obtenerPorPaciente';

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      console.log("Citas obtenidas:", data); // Verifica los datos
      citasBody.innerHTML = "";

      const citasFiltradas = fechaFiltro
        ? data.filter((cita) => {
            // Extraer solo la parte de la fecha (YYYY-MM-DD)
            const fechaCita = cita.fecha_cita.split(" ")[0];
            return fechaCita === fechaFiltro;
          })
        : data;

      console.log("Citas filtradas:", citasFiltradas); // Verifica las citas filtradas

      if (citasFiltradas.length === 0) {
        citasBody.innerHTML =
          "<tr><td colspan='5' class='p-3 text-center text-gray-500'>No hay citas para mostrar.</td></tr>";
      } else {
        citasFiltradas.forEach((cita) => {
          console.log("Cita:", cita); 
          const fila = document.createElement('tr');
          fila.className = 'border-b'; // Clase para el borde inferior de las filas

          // Crear celdas para cada campo
          const celdaMotivo = document.createElement('td');
          celdaMotivo.className = 'p-3'; // Clase para padding
          celdaMotivo.textContent = cita.motivo || "Sin motivo"; // Asignar el motivo

          const celdaFecha = document.createElement('td');
          celdaFecha.className = 'p-3';
          celdaFecha.textContent = cita.fecha_cita || "Sin fecha";

          const celdaHora = document.createElement('td');
          celdaHora.className = 'p-3';
          celdaHora.textContent = cita.hora_cita || "Sin horario";

          const celdaDoctor = document.createElement('td');
          celdaDoctor.className = 'p-3'; // Clase para padding
          celdaDoctor.textContent = cita.Doctor || "Sin doctor"; // Asignar el nombre del doctor

          const celdaEstado = document.createElement('td');
          celdaEstado.className = 'p-3'; // Clase para padding
          celdaEstado.textContent = cita.estado || "Sin estado"; // Asignar el estado

          // Agregar las celdas a la fila
          fila.appendChild(celdaMotivo);
          fila.appendChild(celdaFecha);
          fila.appendChild(celdaHora);
          fila.appendChild(celdaDoctor);
          fila.appendChild(celdaEstado);

          // Agregar la fila al contenedor
          citasBody.appendChild(fila);
        });
      }
    })
    .catch((error) => console.error("Error fetching citas:", error));
}

// Definir la función para ver los detalles de la cita
function verDetallesCita(idCita) {
  console.log("Detalles de la cita seleccionada:", idCita); // Depuración
  window.location.href = `/Gestion_clinica/cita_medica?id_cita=${idCita}`;
}

// Inicializar al cargar la página
window.onload = function () {
  buildCalendar();

  // Obtener la fecha actual en formato YYYY-MM-DD
  const date = new Date();
  const today = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;
  console.log("Cargando citas del día actual:", today); // Depuración

  // Cargar citas del día actual
  loadCitas(today);
};
