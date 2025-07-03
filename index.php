<?php
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

// Receber dados do forms
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Processar login quando enviado
if (!empty($dados["Sendlogin"])) {
    $query_usuario = "SELECT id, senha FROM usuarios WHERE usuario = ? LIMIT 1";
    $stmt = $conn->prepare($query_usuario);
    $stmt->bind_param("s", $dados["usuario"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows == 1) {
        $row_usuario = $resultado->fetch_assoc();
        if (md5($dados["senha_usuario"]) == $row_usuario['senha']) {
            session_start();
            $_SESSION['id'] = $row_usuario['id'];
            $_SESSION['usuario'] = $dados["usuario"];
            header("Location: dashboard.php");
            exit();
        } else {
            $login_error = "Senha incorreta!";
        }
    } else {
        $login_error = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Kicks - Loja de Tênis Esportivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2a2a72;
            --secondary-color: #009ffd;
            --accent-color: #ffa400;
            --light-color: #f8f9fa;
            --dark-color: #232528;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-color);
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .nav-link {
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1600269452121-4f2416e55c28?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 25px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #1a1a4a;
            border-color: #1a1a4a;
        }
        
        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
            font-weight: 600;
        }
        
        .btn-accent:hover {
            background-color: #e69500;
            border-color: #e69500;
            color: white;
        }
        
        .section-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 40px;
            position: relative;
            display: inline-block;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background-color: var(--accent-color);
            bottom: -10px;
            left: 0;
        }
        
        .product-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
        }
        
        .product-img {
            height: 200px;
            object-fit: cover;
        }
        
        .product-title {
            font-weight: 600;
            margin-top: 10px;
        }
        
        .product-price {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .badge-discount {
            background-color: var(--accent-color);
            color: white;
        }
        
        .admin-login {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .login-modal .modal-header {
            background-color: var(--primary-color);
            color: white;
        }
        
        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 50px 0;
        }
        
        .footer-title {
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .footer-link {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        .social-icon {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }
        .navbar-brand img{
            width: 150px;    
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="assets/logo.png" alt="logo1"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Lançamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Masculino</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Feminino</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Infantil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ofertas</a>
                    </li>
                </ul>
                <div class="ms-3 d-flex">
                    <a href="#" class="btn btn-outline-dark me-2"><i class="fas fa-search"></i></a>
                    <a href="login.php" class="btn btn-outline-dark me-2"><i class="fas fa-user"></i></a>
                    <a href="#" class="btn btn-outline-dark"><i class="fas fa-shopping-cart"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">TÊNIS SMART KICKS</h1>
            <p class="hero-subtitle">Tecnologia e conforto para cada passo</p>
            <a href="#" class="btn btn-accent btn-lg">VER COLEÇÃO</a>
        </div>
    </section>

    <!-- Destaques -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">DESTAQUES</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="img-fluid product-img" alt="Tênis Esportivo">
                        <div class="p-3">
                            <h5 class="product-title">Smart Run Pro</h5>
                            <p class="text-muted">Corrida</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">R$ 399,90</span>
                                <span class="badge badge-discount">-20%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="img-fluid product-img" alt="Tênis Casual">
                        <div class="p-3">
                            <h5 class="product-title">Smart Urban</h5>
                            <p class="text-muted">Casual</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">R$ 349,90</span>
                                <span class="badge badge-discount">-15%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="https://images.unsplash.com/photo-1605348532760-6753d2c43329?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" class="img-fluid product-img" alt="Tênis Skate">
                        <div class="p-3">
                            <h5 class="product-title">Smart Skate Pro</h5>
                            <p class="text-muted">Skate</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">R$ 329,90</span>
                                <span class="badge badge-discount">-10%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1025&q=80" class="img-fluid product-img" alt="Tênis Basquete">
                        <div class="p-3">
                            <h5 class="product-title">Smart Dunk</h5>
                            <p class="text-muted">Basquete</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="product-price">R$ 459,90</span>
                                <span class="badge badge-discount">-25%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Promocional -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>PROMOÇÃO DE INVERNO</h2>
                    <p class="lead">Até 40% OFF em tênis selecionados</p>
                    <p>Coleção especial para dias frios com máximo conforto</p>
                    <a href="#" class="btn btn-primary">APROVEITAR OFERTAS</a>
                </div>
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1511556532299-8f662fc26c06?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="img-fluid rounded" alt="Promoção Inverno">
                </div>
            </div>
        </div>
    </section>

    <!-- Categorias -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">CATEGORIAS</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-0">
                        <img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" class="card-img-top" alt="Masculino">
                        <div class="card-body text-center">
                            <h5 class="card-title">Masculino</h5>
                            <a href="#" class="btn btn-outline-primary">Ver Coleção</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0">
                        <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=880&q=80" class="card-img-top" alt="Feminino">
                        <div class="card-body text-center">
                            <h5 class="card-title">Feminino</h5>
                            <a href="#" class="btn btn-outline-primary">Ver Coleção</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0">
                        <img src="https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" class="card-img-top" alt="Infantil">
                        <div class="card-body text-center">
                            <h5 class="card-title">Infantil</h5>
                            <a href="#" class="btn btn-outline-primary">Ver Coleção</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2>RECEBA NOVIDADES E OFERTAS</h2>
                    <p class="lead">Cadastre-se e receba as melhores promoções da Smart Kicks</p>
                    <form class="row g-2 justify-content-center">
                        <div class="col-md-8">
                            <input type="email" class="form-control form-control-lg" placeholder="Seu melhor e-mail">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-accent btn-lg w-100">CADASTRAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="footer-title">SMART KICKS</h5>
                    <p>Tecnologia e conforto para cada passo. A melhor seleção de tênis para todos os estilos.</p>
                    <div class="mt-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5 class="footer-title">LOJA</h5>
                    <a href="#" class="footer-link">Produtos</a>
                    <a href="#" class="footer-link">Lançamentos</a>
                    <a href="#" class="footer-link">Ofertas</a>
                    <a href="#" class="footer-link">Coleções</a>
                </div>
                <div class="col-md-2">
                    <h5 class="footer-title">SOBRE</h5>
                    <a href="#" class="footer-link">Nossa História</a>
                    <a href="#" class="footer-link">Tecnologias</a>
                    <a href="#" class="footer-link">Trabalhe Conosco</a>
                    <a href="#" class="footer-link">Imprensa</a>
                </div>
                <div class="col-md-2">
                    <h5 class="footer-title">AJUDA</h5>
                    <a href="#" class="footer-link">FAQ</a>
                    <a href="#" class="footer-link">Trocas e Devoluções</a>
                    <a href="#" class="footer-link">Entregas</a>
                    <a href="#" class="footer-link">Pagamentos</a>
                </div>
                <div class="col-md-2">
                    <h5 class="footer-title">CONTATO</h5>
                    <a href="#" class="footer-link">Fale Conosco</a>
                    <a href="#" class="footer-link">Lojas Físicas</a>
                    <a href="#" class="footer-link">WhatsApp</a>
                    <a href="#" class="footer-link">SAC</a>
                </div>
            </div>
            <hr class="mt-4 bg-secondary">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">© 2023 Smart Kicks. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="footer-link me-3">Termos de Uso</a>
                    <a href="#" class="footer-link">Política de Privacidade</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Botão de Login Admin (Floating) -->
    <div class="admin-login">
        <button type="button" class="btn btn-primary rounded-circle p-3" data-bs-toggle="modal" data-bs-target="#loginModal" title="Área do Administrador">
            <i class="fas fa-lock"></i>
        </button>
    </div>

    <!-- Modal de Login -->
    <div class="modal fade login-modal" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ÁREA DO ADMINISTRADOR</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if(isset($login_error)): ?>
                        <div class="alert alert-danger"><?php echo $login_error; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite o usuário" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha_usuario" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha_usuario" name="senha_usuario" placeholder="Digite a senha" required>
                        </div>
                        <div class="d-grid">
                            <input type="submit" name="Sendlogin" value="ACESSAR" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>