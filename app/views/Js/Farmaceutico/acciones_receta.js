document.addEventListener('DOMContentLoaded', () => {
    // Referencias al modal y sus botones
    const modal = document.getElementById('modalConfirmacion');
    const btnCancelar = document.getElementById('btnCancelar');
    const btnRechazar = document.getElementById('btnRechazar');
    const btnConfirmar = document.getElementById('btnConfirmar');
    
    let recetaSeleccionada = null;

    // Funciones para el modal
    window.mostrarModal = function(receta) {
        recetaSeleccionada = receta;
        document.getElementById('modalTitle').textContent = `Confirmar Receta ${receta.id_receta}`;
        document.getElementById('modalContent').innerHTML = `
            <p><strong>Paciente:</strong> ${receta.nombre_paciente}</p>
            <p><strong>Medicamento:</strong> ${receta.nombre_medicamento}</p>
            <p><strong>Médico:</strong> ${receta.nombre_medico}</p>
            <p><strong>Fecha:</strong> ${new Date(receta.fecha).toLocaleDateString()}</p>
        `;
        modal.classList.remove('hidden');
    }

    function ocultarModal() {
        modal.classList.add('hidden');
        recetaSeleccionada = null;
    }

    // Event listeners para los botones del modal
    btnCancelar.addEventListener('click', ocultarModal);
    btnRechazar.addEventListener('click', () => actualizarEstadoReceta('Rechazada'));
    btnConfirmar.addEventListener('click', () => actualizarEstadoReceta('Confirmada'));

    async function actualizarEstadoReceta(nuevoEstado) {
        if (!recetaSeleccionada) return;
    
        try {
            const response = await fetch('Gestion_Clinica/app/controllers/FarmaciaController.php?action=actualizar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id_receta: recetaSeleccionada.id_receta,
                    estado: nuevoEstado
                })
            });
    
            // Verifica el tipo de contenido de la respuesta
            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                const text = await response.text(); // Obtener la respuesta como texto
                throw new Error(`Respuesta no es JSON: ${text}`);
            }
    
            const resultado = await response.json();
            if (resultado.success) {
                ocultarModal();
                window.location.reload();
            }
        } catch (error) {
            console.error('Error al actualizar estado:', error);
        }
    }
    
});

