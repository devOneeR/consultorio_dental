
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado completamente');
    
    const formRegistro = document.getElementById('formRegistro');
    
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(e) {

            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();
            const cedula = document.getElementById('cedula').value.trim();
            const edad = document.getElementById('edad').value.trim();
            const motivoVisita = document.getElementById('motivo_visita').value.trim();
            
            if (nombre === '' || apellido === '' || cedula === '' || edad === '' || motivoVisita === '') {
                e.preventDefault();
                
                const mensajeError = document.createElement('div');
                mensajeError.className = 'alert alert-danger';
                mensajeError.textContent = 'Todos los campos son obligatorios';
                
                formRegistro.parentNode.insertBefore(mensajeError, formRegistro);
                
                setTimeout(() => {
                    mensajeError.remove();
                }, 3000);
                
                return false;
            }
            
            // Validamos que la edad sea un número positivo
            if (isNaN(edad) || parseInt(edad) <= 0) {
                e.preventDefault();
                
                const mensajeError = document.createElement('div');
                mensajeError.className = 'alert alert-danger';
                mensajeError.textContent = 'La edad debe ser un número positivo';
                
                formRegistro.parentNode.insertBefore(mensajeError, formRegistro);
                
                setTimeout(() => {
                    mensajeError.remove();
                }, 3000);
                
                return false;
            }
            
        });
    }
    
    const alertas = document.querySelectorAll('.alert');
    
    if (alertas.length > 0) {
        alertas.forEach(alerta => {
            setTimeout(() => {
                alerta.style.opacity = '0';
                setTimeout(() => {
                    alerta.remove();
                }, 500);
            }, 5000);
        });
    }
});