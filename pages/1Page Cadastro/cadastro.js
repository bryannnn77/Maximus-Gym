document.addEventListener('DOMContentLoaded', function() {
    const cadastroForm = document.getElementById('cadastroForm');
    
    cadastroForm.addEventListener('submit', function(event) {
        event.preventDefault();
        validarFormulario();
    });
});

function validarFormulario() {
    document.getElementById('senha-error').textContent = '';
    document.getElementById('email-error').textContent = '';
    document.getElementById('telefone-error').textContent = '';
    
    const senha = document.getElementById('senha').value;
    const email = document.getElementById('Email').value;
    const telefone = document.getElementById('telefone').value;
    
    let valido = true;
    
    if (senha.length < 8) {
        document.getElementById('senha-error').textContent = 'A senha deve ter no mínimo 8 caracteres';
        valido = false;
    }
    
    if (!email.includes('@')) {
        document.getElementById('email-error').textContent = 'Por favor, insira um email válido';
        valido = false;
    }
    
    if (!/^\d+$/.test(telefone)) {
        document.getElementById('telefone-error').textContent = 'O telefone deve conter apenas números';
        valido = false;
    }
    
    if (valido) {
        realizarCadastro();
    }
}

function realizarCadastro() {
    alert('Cadastro realizado com sucesso!');
    window.location.href = "../../index.html";
}

function irParaLogin() {
    window.location.href = "../2Page Home/home.html";
}
