function irParaLogin() {
        window.location.href = "login.html";
    }

    function validarFormulario(event) {
        event.preventDefault();
        
        // Limpar mensagens de erro anteriores
        document.getElementById('senha-error').textContent = '';
        document.getElementById('email-error').textContent = '';
        document.getElementById('telefone-error').textContent = '';
        
        // Obter valores dos campos
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
            cadastrar();
        }
    }

    function cadastrar(){
        var login = document.getElementById('login').value;
        var senha = document.getElementById('senha').value;
        var Email = document.getElementById('Email').value;
        var telefone = document.getElementById('telefone').value;

        alert('Cadastro realizado com sucesso!.');
        
        setTimeout(function() {
            window.location.href = "login.html";
        }, 2000);
    }