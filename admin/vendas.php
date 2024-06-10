<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Compras</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Lista de Compras</h2>
    
    <div class="mb-3">
        <form action="" method="GET">
            <div class="row">
                <div class="col">
                    <select class="form-select" name="status" onchange="this.form.submit()">
                        <option value="">Todas as Compras</option>
                        <option value="pendente" <?php echo (isset($_GET['status']) && $_GET['status'] == 'processando') ? 'selected' : ''; ?>>Pendente</option>
                        <option value="confirmado" <?php echo (isset($_GET['status']) && $_GET['status'] == 'concluido') ? 'selected' : ''; ?>>Confirmado</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Produto</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Data da Venda</th>
                    <th>Método de Pagamento</th>
                    <th>Status de Entrega</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../actions/connection.php');

                $status = isset($_GET['status']) ? $_GET['status'] : '';
                $sql = "SELECT * FROM vendas";
                if (!empty($status)) {
                    $sql .= " WHERE status = :status";
                }

                $stmt = $conn->prepare($sql);
                if (!empty($status)) {
                    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                }

                $stmt->execute();
                while ($venda = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?php echo($venda['id']); ?></td>
                        <td><?php echo($venda['nome_produto']); ?></td>
                        <td>R$ <?php echo(number_format($venda['preco'], 2, ',', '.')); ?></td>
                        <td><?php echo($venda['status']); ?></td>
                        <td><?php echo(date("d/m/Y H:i:s", strtotime($venda['data_venda']))); ?></td>
                        <td><?php echo($venda['metodo_pagamento']); ?></td>
                        <td><?php echo($venda['status_entrega']); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $venda['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ações
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $venda['id']; ?>">
                                    <li><a class="dropdown-item" href="actions/vendas.php?id=<?php echo($venda['id']); ?>" onclick="return confirm('Tem certeza que deseja marcar como entregue?');">Marcar como entregue</a></li>
                                    <li><a class="dropdown-item" href="endereco.php?id=<?php echo($venda['preference_id']); ?>">Visualizar endereço</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
