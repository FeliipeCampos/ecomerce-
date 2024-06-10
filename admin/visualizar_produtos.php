<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Produtos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Lista de Produtos</h2>
    
    <div class="mb-3">
        <form action="" method="GET">
            <div class="row">
                <div class="col">
                    <select class="form-select" name="status" onchange="this.form.submit()">
                        <option value="">Todos os Produtos</option>
                        <option value="ativo" <?php echo (isset($_GET['status']) && $_GET['status'] == 'ativo') ? 'selected' : ''; ?>>Ativos</option>
                        <option value="desativado" <?php echo (isset($_GET['status']) && $_GET['status'] == 'desativado') ? 'selected' : ''; ?>>Desativados</option>
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
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../actions/connection.php');

                $status = isset($_GET['status']) ? $_GET['status'] : '';
                $sql = "SELECT * FROM produtos";
                if (!empty($status)) {
                    $sql .= " WHERE status = :status";
                }

                $stmt = $conn->prepare($sql);
                if (!empty($status)) {
                    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                }

                $stmt->execute();
                while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?php echo($produto['id']); ?></td>
                        <td><?php echo($produto['nome']); ?></td>
                        <td><?php echo($produto['descricao']); ?></td>
                        <td>R$ <?php echo(number_format($produto['preco'], 2, ',', '.')); ?></td>
                        <td><?php echo($produto['status']); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $produto['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ações
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $produto['id']; ?>">
                                    <li><a class="dropdown-item" href="editar_produto.php?id=<?php echo($produto['id']); ?>">Editar</a></li>
                                    <?php if ($produto['status'] == 'ativo'): ?>
                                        <li><a class="dropdown-item text-danger" href="actions/desativar_produto.php?id=<?php echo($produto['id']); ?>" onclick="return confirm('Tem certeza que deseja desativar este produto?');">Desativar</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item text-success" href="actions/ativar_produto.php?id=<?php echo($produto['id']); ?>" onclick="return confirm('Tem certeza que deseja ativar este produto?');">Ativar</a></li>
                                    <?php endif; ?>
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
