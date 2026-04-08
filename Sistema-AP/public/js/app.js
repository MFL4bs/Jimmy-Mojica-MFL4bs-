function inscribirse(cursoId) {
    Swal.fire({
        title: '¿Inscribirse al curso?',
        text: '¿Deseas inscribirte en este curso?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, inscribirme',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('inscripcion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({curso_id: cursoId})
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire('¡Éxito!', 'Inscripción exitosa', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error', 'Error en la inscripción', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error de conexión', 'error');
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Validación de formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required]');
            let valid = true;
            
            inputs.forEach(input => {
                if(!input.value.trim()) {
                    valid = false;
                    input.style.borderColor = '#ff6b6b';
                } else {
                    input.style.borderColor = '#ddd';
                }
            });
            
            if(!valid) {
                e.preventDefault();
                Swal.fire('Campos requeridos', 'Por favor completa todos los campos requeridos', 'warning');
            }
        });
    });
});