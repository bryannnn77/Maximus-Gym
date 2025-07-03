<?php
session_start();

if(!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Smart Kicks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a29bfe;
            --dark-color: #2d3436;
            --light-color: #f5f6fa;
            --success-color: #00b894;
            --warning-color: #fdcb6e;
            --danger-color: #d63031;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            margin-bottom: 5px;
            border-radius: 5px;
            padding: 10px 15px;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 600;
        }
        
        .metric-card {
            text-align: center;
            padding: 20px;
        }
        
        .metric-card .value {
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .metric-card .label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .revenue {
            border-left: 4px solid var(--success-color);
        }
        
        .orders {
            border-left: 4px solid var(--primary-color);
        }
        
        .customers {
            border-left: 4px solid var(--warning-color);
        }
        
        .products {
            border-left: 4px solid var(--secondary-color);
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        .recent-orders table {
            font-size: 0.9rem;
        }
        
        .badge-success {
            background-color: var(--success-color);
        }
        
        .badge-warning {
            background-color: var(--warning-color);
        }
        
        .badge-danger {
            background-color: var(--danger-color);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="text-center mb-4">
                    <h4>Smart Kicks</h4>
                    <p class="text-muted">Administração</p>
                </div>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-tshirt"></i> Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-shopping-cart"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-users"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-line"></i> Relatórios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog"></i> Configurações
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-danger" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <nav class="navbar navbar-expand-lg mb-4">
                    <div class="container-fluid">
                        <h5 class="mb-0">Dashboard</h5>
                        <div class="user-profile">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario']); ?>&background=6c5ce7&color=fff" alt="User">
                            <span><?php echo $_SESSION['usuario']; ?></span>
                        </div>
                    </div>
                </nav>
                
                <!-- Metrics Row -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card revenue">
                            <div class="card-body metric-card">
                                <div class="value text-success">R$ 48,250</div>
                                <div class="label">Faturamento Mensal</div>
                                <small class="text-success"><i class="fas fa-arrow-up"></i> 12% em relação ao mês passado</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card orders">
                            <div class="card-body metric-card">
                                <div class="value text-primary">324</div>
                                <div class="label">Pedidos</div>
                                <small class="text-primary"><i class="fas fa-arrow-up"></i> 8% em relação ao mês passado</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card customers">
                            <div class="card-body metric-card">
                                <div class="value text-warning">1.245</div>
                                <div class="label">Clientes</div>
                                <small class="text-warning"><i class="fas fa-arrow-up"></i> 5% novos clientes</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card products">
                            <div class="card-body metric-card">
                                <div class="value" style="color: #a29bfe;">587</div>
                                <div class="label">Produtos</div>
                                <small class="text-muted">12 novos esta semana</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Charts Row -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Faturamento Mensal (últimos 6 meses)</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Categorias Mais Vendidas</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="categoryChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bottom Row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Pedidos Recentes</h6>
                            </div>
                            <div class="card-body recent-orders">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Cliente</th>
                                                <th>Valor</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#1254</td>
                                                <td>Ana Silva</td>
                                                <td>R$ 289,90</td>
                                                <td><span class="badge badge-success">Entregue</span></td>
                                            </tr>
                                            <tr>
                                                <td>#1253</td>
                                                <td>Carlos Oliveira</td>
                                                <td>R$ 450,50</td>
                                                <td><span class="badge badge-warning">Processando</span></td>
                                            </tr>
                                            <tr>
                                                <td>#1252</td>
                                                <td>Mariana Costa</td>
                                                <td>R$ 189,90</td>
                                                <td><span class="badge badge-danger">Cancelado</span></td>
                                            </tr>
                                            <tr>
                                                <td>#1251</td>
                                                <td>João Santos</td>
                                                <td>R$ 320,00</td>
                                                <td><span class="badge badge-success">Entregue</span></td>
                                            </tr>
                                            <tr>
                                                <td>#1250</td>
                                                <td>Patrícia Lima</td>
                                                <td>R$ 275,50</td>
                                                <td><span class="badge badge-warning">Processando</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Produtos Mais Vendidos</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://via.placeholder.com/60" class="rounded mr-3" alt="Produto">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Tênis Court Vision Low Masculino Nike</h6>
                                        <small class="text-muted">Vendidos: 124 unidades</small>
                                    </div>
                                    <div class="text-success font-weight-bold">R$ 436,99</div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://via.placeholder.com/60" class="rounded mr-3" alt="Produto">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Tênis Masculino Nike Court Royale 2</h6>
                                        <small class="text-muted">Vendidos: 98 unidades</small>
                                    </div>
                                    <div class="text-success font-weight-bold">R$ 275,49</div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://via.placeholder.com/60" class="rounded mr-3" alt="Produto">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Tênis Nike Air Max Impact 4 Masculino</h6>
                                        <small class="text-muted">Vendidos: 87 unidades</small>
                                    </div>
                                    <div class="text-success font-weight-bold">R$ 370,49</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/60" class="rounded mr-3" alt="Produto">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Tênis Adidas Courtblock Masculino</h6>
                                        <small class="text-muted">Vendidos: 76 unidades</small>
                                    </div>
                                    <div class="text-success font-weight-bold">R$ 219,99</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
                datasets: [{
                    label: 'Faturamento (R$)',
                    data: [32000, 38500, 41200, 39800, 46500, 48250],
                    backgroundColor: 'rgba(108, 92, 231, 0.1)',
                    borderColor: 'rgba(108, 92, 231, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
        
        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Feminino', 'Masculino', 'Infantil', 'Esportivo'],
                datasets: [{
                    data: [35, 28, 15, 10],
                    backgroundColor: [
                        '#6c5ce7',
                        '#00b894',
                        '#fdcb6e',
                        '#d63031',
                        '#a29bfe'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>