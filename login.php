<?php
session_start();

// Configurações do banco de dados
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'login';

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Processar login do cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_cliente'])) {
    $email = $_POST['email'];
    $senha = md5($_POST['senha']); // Simples hash MD5 para exemplo
    
    // Verificar credenciais (exemplo simplificado)
    if ($email === 'cliente@exemplo.com' && $senha === md5('123456')) {
        $_SESSION['cliente'] = [
            'nome' => 'Cliente Exemplo',
            'email' => $email
        ];
        header("Location: perfil.php");
        exit();
    } else {
        $erro_cliente = "E-mail ou senha incorretos!";
    }
}

// Processar login do admin (mesmo código anterior)
if (!empty($_POST["Sendlogin"])) {
    $query_usuario = "SELECT id, senha FROM usuarios WHERE usuario = ? LIMIT 1";
    $stmt = $conn->prepare($query_usuario);
    $stmt->bind_param("s", $_POST["usuario"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows == 1) {
        $row_usuario = $resultado->fetch_assoc();
        if (md5($_POST["senha_usuario"]) == $row_usuario['senha']) {
            $_SESSION['id'] = $row_usuario['id'];
            $_SESSION['usuario'] = $_POST["usuario"];
            header("Location: dashboard.php");
            exit();
        } else {
            $erro_admin = "Senha incorreta!";
        }
    } else {
        $erro_admin = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Kicks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2a2a72;
            --secondary-color: #009ffd;
            --accent-color: #ffa400;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .form-control {
            padding: 12px;
            border-radius: 5px;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }
        
        .btn-login:hover {
            background-color: #1a1a4a;
            color: white;
        }
        
        .login-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            text-align: center;
            flex: 1;
        }
        
        .tab.active {
            border-bottom: 3px solid var(--primary-color);
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .admin-access {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <div class="login-logo">SMART KICKS</div>
                <p>Faça login para acessar sua conta</p>
            </div>
            
            <div class="login-tabs">
                <div class="tab active" onclick="openTab('cliente')">Cliente</div>
                <div class="tab" onclick="openTab('admin')">Administrador</div>
            </div>
            
            <!-- Login do Cliente -->
            <div id="cliente" class="tab-content active">
                <?php if(isset($erro_cliente)): ?>
                    <div class="alert alert-danger"><?php echo $erro_cliente; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="lembrar">
                        <label class="form-check-label" for="lembrar">Lembrar de mim</label>
                    </div>
                    <button type="submit" name="login_cliente" class="btn btn-login">ENTRAR</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="#">Esqueci minha senha</a>
                    <p class="mt-2">Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
                </div>
            </div>
            
            <!-- Login do Admin -->
            <div id="admin" class="tab-content">
                <?php if(isset($erro_admin)): ?>
                    <div class="alert alert-danger"><?php echo $erro_admin; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário Admin</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha_usuario" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" required>
                    </div>
                    <input type="submit" name="Sendlogin" value="ACESSAR DASHBOARD" class="btn btn-login">
                </form>
                
                <div class="admin-access">
                    <p>Acesso restrito aos administradores do sistema</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openTab(tabName) {
            // Esconde todos os conteúdos de tab
            const tabContents = document.getElementsByClassName('tab-content');
            for (let i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }
            
            // Remove a classe active de todas as tabs
            const tabs = document.getElementsByClassName('tab');
            for (let i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }
            
            // Mostra a tab atual e marca como ativa
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>