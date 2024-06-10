<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-4 g-4">

        <!-- Criar Produto -->
        <div class="col">
            <a href="criar_produto.php" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle fa-3x"></i>
                        <h5 class="card-title mt-3">Criar Produto</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Visualizar Produtos -->
        <div class="col">
            <a href="visualizar_produtos.php" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-eye fa-3x"></i>
                        <h5 class="card-title mt-3">Visualizar Produtos</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Ver Vendas -->
        <div class="col">
            <a href="vendas.php" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x"></i>
                        <h5 class="card-title mt-3">Ver Vendas</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Visualizar Usuários -->
        <div class="col">
            <a href="visualizar_usuarios.php" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x"></i>
                        <h5 class="card-title mt-3">Visualizar Usuários</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Relatórios -->
        <div class="col">
            <a href="relatorios.php" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-3x"></i>
                        <h5 class="card-title mt-3">Relatórios</h5>
                    </div>
                </div>
            </a>
        </div>

        <!-- Carrossel -->
        <div class="col">
            <a href="carrossel.php" style="text-decoration: none; color: inherit;">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-images fa-3x"></i>
                        <h5 class="card-title mt-3">Modificar Carrossel</h5>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>


<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
