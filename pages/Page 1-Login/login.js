document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        validarLogin();
    });
    
    const inputs = document.querySelectorAll('.input-group input');
    inputs.forEach(input => {
        input.addEventListener('mouseenter', function() {
            this.style.borderColor = '#ff416c';
        });
        
        input.addEventListener('mouseleave', function() {
            if (!this.classList.contains('error') && !this === document.activeElement) {
                this.style.borderColor = '#ddd';
            }
        });
    });
});

function validarLogin() {
    const login = document.getElementById('login').value;
    const senha = document.getElementById('senha').value;
    const errorElement = document.getElementById('login-error');
    
    errorElement.textContent = '';
    
    if (login === '' || senha === '') {
        errorElement.textContent = 'Por favor, preencha todos os campos';
        return;
    }
    
    if ((login === 'admin' && senha === 'admin') || 
        (login === 'usuario' && senha === 'senha123')) {
    
        const submitBtn = document.querySelector('.submit-btn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Entrando...</span>';
        submitBtn.disabled = true;
        
        setTimeout(function() {
            window.location.href = "home.html";
        }, 1500);
    } else {
        errorElement.textContent = 'Credenciais inválidas. Tente novamente.';
    
        const inputs = document.querySelectorAll('.input-group input');
        inputs.forEach(input => {
            input.classList.add('error');
            setTimeout(() => {
                input.classList.remove('error');
            }, 2000);
        });
    }
}