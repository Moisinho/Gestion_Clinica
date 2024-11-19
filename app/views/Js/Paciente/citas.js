
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

// Función para cargar citas
function loadCitas() {
    fetch('/Gestion_clinica/app/controllers/CitaController.php?action=obtenerPorPaciente')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (Array.isArray(data)) {
                mostrarCitas(data);
            } else {
                console.error('La respuesta no es un array:', data);
            }
        })
        .catch(error => {
            console.error('Error fetching citas:', error);
        });
}

function mostrarCitas(citas) {
    const contenedorCitas = document.getElementById('contenedorCitas');
    contenedorCitas.innerHTML = ''; // Limpiar contenido previo

    citas.forEach(cita => {
        const fila = document.createElement('tr');
        fila.className = 'border-b'; // Clase para el borde inferior de las filas

        // Crear celdas para cada campo
        const celdaMotivo = document.createElement('td');
        celdaMotivo.className = 'p-3'; // Clase para padding
        celdaMotivo.textContent = cita.motivo; // Asignar el motivo

        const celdaFecha = document.createElement('td');
        celdaFecha.className = 'p-3'; // Clase para padding
        celdaFecha.textContent = cita.fecha_cita; // Asignar la fecha

        const celdaDoctor = document.createElement('td');
        celdaDoctor.className = 'p-3'; // Clase para padding
        celdaDoctor.textContent = cita.Doctor; // Asignar el nombre del doctor

        const celdaEstado = document.createElement('td');
        celdaEstado.className = 'p-3'; // Clase para padding
        celdaEstado.textContent = cita.estado; // Asignar el estado

        // Agregar las celdas a la fila
        fila.appendChild(celdaMotivo);
        fila.appendChild(celdaFecha);
        fila.appendChild(celdaDoctor);
        fila.appendChild(celdaEstado);

        // Agregar la fila al contenedor
        contenedorCitas.appendChild(fila);
    });
}

// Inicializar al cargar la página
window.onload = function () {
    buildCalendar();
    loadCitas(); // Asegúrate de que esta función se esté llamando
};
