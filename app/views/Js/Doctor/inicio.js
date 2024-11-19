// Función para construir el calendario
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
  
      if (day === today) {
        dayCell.classList.add("today");
      }
  
      calendarDays.appendChild(dayCell);
    }
  }
  
  // Función para cargar las citas del médico
  function loadCitas() {
    const citasBody = document.getElementById("citasBody");
    const url = '/Gestion_clinica/app/controllers/CitaController.php?action=obtenerPorMedico&id_usuario=' + id_usuario;
    fetch(url)
      .then((response) => response.json())
      .then((data) => {
        console.log(data); // Verifica la respuesta aquí
              // Asegúrate de que data sea un array
        
        citasBody.innerHTML = ""; // Limpiar el contenido previo
  
        if (data.length === 0) {
          citasBody.innerHTML =
            "<tr><td colspan='4' class='p-3 text-center text-gray-500'>No hay citas pendientes para mostrar.</td></tr>";
        } else {
          data.forEach((cita) => {
            const row = document.createElement("tr");
            row.className = "border-b hover:bg-purple-50";
            row.innerHTML = `
              <td class='p-3'>${cita.nombre_paciente || "Sin paciente"}</td>
              <td class='p-3'>${cita.motivo || "Sin motivo"}</td>
              <td class='p-3'>${cita.fecha_cita || "Sin fecha"}</td>
              <td class='p-3'>${cita.estado || "Sin estado"}</td>
              <td class='p-3'>
                <button onclick="verDetallesCita(${cita.id_cita})" class='bg-purple-300 text-purple-900 font-bold py-2 px-4 rounded hover:bg-purple-400'>
                  Ver Detalles de Cita
                </button>
              </td>
            `;
            citasBody.appendChild(row);
          });
          
        }
      })
      .catch((error) => console.error("Error fetching citas:", error));
  }
  function verDetallesCita(idCita) {
    window.location.href = `/Gestion_clinica/cita_medica?id_cita=${idCita}`;
  }
  // Función para inicializar el calendario y cargar las citas
  window.onload = function () {
    buildCalendar();
    loadCitas();
  };
  