<?php
session_start();

// Verificar se o cliente está logado
if(!isset($_SESSION['cliente'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Smart Kicks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2a2a72;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .profile-header {
            background-color: white;
            padding: 30px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .profile-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }
        
        .nav-pills .nav-link {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="profile-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['cliente']['nome']); ?>&background=2a2a72&color=fff&size=120" class="profile-pic" alt="Foto do Perfil">
                </div>
                <div class="col-md-6">
                    <h2><?php echo $_SESSION['cliente']['nome']; ?></h2>
                    <p class="text-muted mb-0"><?php echo $_SESSION['cliente']['email']; ?></p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="logout.php" class="btn btn-outline-danger">Sair</a>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Conteúdo do Perfil -->
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card profile-card mb-4">
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#dados" data-bs-toggle="pill">Meus Dados</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pedidos" data-bs-toggle="pill">Meus Pedidos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#enderecos" data-bs-toggle="pill">Endereços</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#favoritos" data-bs-toggle="pill">Favoritos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="dados">
                        <div class="card profile-card">
                            <div class="card-header">
                                <h5 class="mb-0">Meus Dados Pessoais</h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nome Completo</label>
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['cliente']['nome']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">E-mail</label>
                                            <input type="email" class="form-control" value="<?php echo $_SESSION['cliente']['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">CPF</label>
                                            <input type="text" class="form-control" placeholder="000.000.000-00">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Data de Nascimento</label>
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Telefone</label>
                                            <input type="tel" class="form-control" placeholder="(00) 00000-0000">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="pedidos">
                        <div class="card profile-card">
                            <div class="card-header">
                                <h5 class="mb-0">Meus Pedidos</h5>
                            </div>
                            <div class="card-body">
                                <p>Você ainda não realizou nenhum pedido.</p>
                                <a href="index.php" class="btn btn-primary">Continuar Comprando</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="enderecos">
                        <div class="card profile-card">
                            <div class="card-header">
                                <h5 class="mb-0">Meus Endereços</h5>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-primary mb-3">Adicionar Endereço</button>
                                <p>Nenhum endereço cadastrado.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="favoritos">
                        <div class="card profile-card">
                            <div class="card-header">
                                <h5 class="mb-0">Meus Favoritos</h5>
                            </div>
                            <div class="card-body">
                                <p>Você ainda não adicionou itens aos favoritos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>