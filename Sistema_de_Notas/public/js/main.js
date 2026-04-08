// JavaScript para el Sistema de Notas

document.addEventListener('DOMContentLoaded', function() {
    // Validación de formularios Bootstrap
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
    
    // Confirmación para eliminaciones
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('¿Está seguro de que desea eliminar este registro?')) {
                e.preventDefault();
            }
        });
    });
    
    // Validación personalizada para notas
    const notaInput = document.getElementById('nota');
    if (notaInput) {
        notaInput.addEventListener('input', function() {
            const valor = parseFloat(this.value);
            if (valor < 0 || valor > 5) {
                this.setCustomValidity('La nota debe estar entre 0.0 y 5.0');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});