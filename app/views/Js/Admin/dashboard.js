// Llamada para obtener el resumen del dashboard
async function obtenerResumenDashboard() {
  try {
    const response = await fetch("../../controllers/AdminController.php?action=resumenDashboard");
    const data = await response.json();

    console.log("Datos: ", data);
    // Actualizar los valores en las tarjetas
    document.getElementById("cantidadCitas").textContent = data.cantidadCitas;
    document.getElementById("usuariosActivos").textContent = data.usuariosActivos;
    document.getElementById("ingresosRecientes").textContent = `$${data.ingresosRecientes}`;
  } catch (error) {
    console.error("Error al obtener los datos del dashboard:", error);
  }
}

// Llamada para obtener los datos de la gráfica
async function obtenerDatosGrafica() {
  try {
    const response = await fetch(
      "../../controllers/AdminController.php?action=obtenerDatosGrafica&periodo=mes"
    );
    const datosGrafica = await response.json();

    console.log("Datos de grafica: ", datosGrafica);

    // Actualizar la gráfica con los datos recibidos
    const fechas = datosGrafica.map((dato) => dato.fecha);
    const cantidades = datosGrafica.map((dato) => dato.cantidad);
    chartCitas.data.labels = fechas;
    chartCitas.data.datasets[0].data = cantidades;
    chartCitas.update();
  } catch (error) {
    console.error("Error al obtener los datos de la gráfica:", error);
  }
}

// Ejecutar las funciones para cargar los datos al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  obtenerResumenDashboard();
  obtenerDatosGrafica();
});
