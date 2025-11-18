
document.addEventListener("DOMContentLoaded", function() {
    
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Previene la navegación
            
            if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                // Si confirma, redirige al enlace de borrado
                window.location.href = this.href;
            }
        });
    });


    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.getElementById('toggle-sidebar-btn');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            // Añadimos una clase que la muestra
            sidebar.classList.toggle('active'); 
        });
        
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    }

    const form = document.getElementById('denuncia-form');
    if (!form) {
        return; 
    }

    const rules = {
        'titulo': {
            required: true, min: 5, max: 100,
            message: 'Debe tener entre 5 y 100 caracteres.'
        },
        'ciudadano': {
            required: true, pattern: /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/,
            message: 'Solo se permiten letras y espacios.'
        },
        'telefono_ciudadano': {
            required: true, pattern: /^[0-9]{9}$/,
            message: 'Debe tener 9 dígitos numéricos.'
        },
        'ubicacion': {
            required: true, min: 5, max: 150,
            message: 'Debe tener entre 5 y 150 caracteres.'
        },
        'descripcion': {
            required: true, min: 10, max: 255,
            message: 'Debe tener entre 10 y 255 caracteres.'
        },
        'estado': {
            required: true,
            message: 'Debe seleccionar un estado.'
        },
        'fecha_registro': {
            required: true,
            message: 'La fecha y hora son obligatorias.'
        }
    };

    function validateField(input) {
        const name = input.name;
        if (!rules[name]) return true; 

        const rule = rules[name];
        const value = input.value.trim();
        let isValid = true;
        let errorMessage = rule.message;

        input.classList.remove('is-invalid', 'is-valid');
        const errorDiv = document.getElementById('error-' + input.id);

        if (rule.required && !value) {
            isValid = false;
            errorMessage = 'Este campo es obligatorio.';
        } else if (rule.min && value.length < rule.min) {
            isValid = false;
        } else if (rule.max && value.length > rule.max) {
            isValid = false;
        } else if (rule.pattern && !rule.pattern.test(value)) {
            isValid = false;
        }

        if (isValid) {
            input.classList.add('is-valid');
            if(errorDiv) errorDiv.textContent = ''; 
        } else {
            input.classList.add('is-invalid');
            if(errorDiv) errorDiv.textContent = errorMessage; 
        }
        return isValid;
    }

    function validateForm(e) {
        let isFormValid = true;
        
        for (const ruleName in rules) {
            const input = form.querySelector(`[name="${ruleName}"]`);
            if (input) {
                if (!validateField(input)) {
                    isFormValid = false; 
                }
            }
        }
        
        if (!isFormValid) {
            e.preventDefault(); // Detiene el envío del formulario
            e.stopPropagation();
        }
    }
    
    form.addEventListener('submit', validateForm);


    for (const ruleName in rules) {
        const input = form.querySelector(`[name="${ruleName}"]`);
        if (input) {
            const eventType = (input.tagName === 'SELECT' || input.type === 'datetime-local') ? 'change' : 'input';
            
            input.addEventListener(eventType, () => validateField(input));
            input.addEventListener('blur', () => validateField(input));
        }
    }
    form.setAttribute('novalidate', '');

    const btnBuscar = document.getElementById("btnBuscar");
    const formFiltro = document.getElementById("filtro-form"); // Asegúrate que tu form en listar.php tenga id="filtro-form"

    if (btnBuscar && formFiltro) {
        btnBuscar.addEventListener("click", function () {
            formFiltro.submit();
        });
    }

});