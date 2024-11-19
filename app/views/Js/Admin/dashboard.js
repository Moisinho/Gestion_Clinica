// Declarar chartCitas como una variable global
let chartCitas;

document.addEventListener("DOMContentLoaded", () => {
  // Obtener elementos del DOM
  const ctxCitas = document.getElementById("chartCitas").getContext("2d");
  const periodoSelector = document.getElementById("periodo");

  // Configuración inicial del gráfico de citas
  crearGrafico(ctxCitas); // Pasar el contexto al gráfico
  obtenerDatosGrafica("semana"); // Llama con "semana" por defecto
  obtenerResumenDashboard();

  // Añadir evento para cambiar el gráfico según el periodo
  periodoSelector.addEventListener("change", (event) => {
    const periodo = event.target.value;
    obtenerDatosGrafica(periodo); // Llama a la función con el periodo seleccionado
  });
});

// Función para crear el gráfico
function crearGrafico(ctxCitas) {
  chartCitas = new Chart(ctxCitas, {
    type: "line",
    data: {
      labels: [], // Inicialmente vacío, se llenará con datos
      datasets: [
        {
          label: "Citas",
          data: [], // Inicialmente vacío, se llenará con datos
          borderColor: "rgba(91, 33, 182, 0.7)",
          backgroundColor: "rgba(91, 33, 182, 0.2)",
          fill: true,
        },
      ],
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: "top",
        },
      },
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}

// Llamada para obtener el resumen del dashboard
async function obtenerResumenDashboard() {
  try {
    const response = await fetch("/Gestion_clinica/app/controllers/AdminController.php?action=resumenDashboard");
    const data = await response.json();

    console.log("Datos para cards: ", data);
    // Actualizar los valores en las tarjetas
    document.getElementById("cantidadCitas").textContent = data.cantidadCitas;
    document.getElementById("usuariosActivos").textContent = data.usuariosActivos;
    document.getElementById("ingresosRecientes").textContent = `$${data.ingresosRecientes}`;
  } catch (error) {
    console.error("Error al obtener los datos del dashboard:", error);
  }
}

// Función para obtener los datos de la gráfica
async function obtenerDatosGrafica(periodo) {
  try {
    const response = await fetch(
      `/Gestion_clinica/app/controllers/AdminController.php?action=obtenerDatosGrafica&periodo=${periodo}`
    );
    const datosGrafica = await response.json();
    console.log("Datos de gráfica:", datosGrafica);

    // Asegúrate de que datosGrafica tenga la estructura esperada
    if (!Array.isArray(datosGrafica) || datosGrafica.length === 0) {
      throw new Error("No hay datos disponibles para la gráfica.");
    }

    const fechas = datosGrafica.map((dato) => dato.fecha);
    const cantidades = datosGrafica.map((dato) => dato.cantidad);
    chartCitas.data.labels = fechas;
    chartCitas.data.datasets[0].data = cantidades;
    chartCitas.update();
  } catch (error) {
    console.error("Error al obtener los datos de la gráfica:", error);
  }
}
