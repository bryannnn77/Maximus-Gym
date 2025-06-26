document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            validarLogin();
        });
    }
});

function validarLogin() {
    const login = document.getElementById('login')?.value.trim();
    const senha = document.getElementById('senha')?.value.trim();
    const errorElement = document.getElementById('login-error');
    
    if (!errorElement) return;
    
    errorElement.textContent = '';
    
    if (!login || !senha) {
        errorElement.textContent = 'Por favor, preencha todos os campos';
        return;
    }
    
    const usuariosValidos = {
        'admin': 'admin',
        'usuario': 'senha123',
        'teste': 'teste123'  
    };
    
    if (usuariosValidos[login] && usuariosValidos[login] === senha) {
        const submitBtn = document.querySelector('.submit-btn');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Entrando...</span>';
            submitBtn.disabled = true;
        }
        
        setTimeout(() => {
            window.location.href = "pages/2Page Home/home.html";
            // Alternativa: window.location.replace("pages/2Page Home/home.html");
        }, 1000);
    } else {
        errorElement.textContent = 'Credenciais inválidas. Tente novamente.';
        
        document.getElementById('login')?.classList.add('error');
        document.getElementById('senha')?.classList.add('error');
        
        setTimeout(() => {
            document.getElementById('login')?.classList.remove('error');
            document.getElementById('senha')?.classList.remove('error');
        }, 2000);
    }
}