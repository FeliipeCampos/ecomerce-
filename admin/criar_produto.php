<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Produto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Adicionar Novo Produto</h2>
    <form action="actions/criar_produto.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nomeProduto" class="form-label">Nome do Produto</label>
            <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" required>
        </div>
        <div class="mb-3">
            <label for="descricaoProduto" class="form-label">Descrição do Produto</label>
            <textarea class="form-control" id="descricaoProduto" name="descricaoProduto" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="precoProduto" class="form-label">Preço do Produto</label>
            <input type="text" class="form-control" id="precoProduto" name="precoProduto" required>
        </div>
        <div class="mb-3">
            <label for="imagemProduto" class="form-label">Imagem do Produto</label>
            <input type="file" class="form-control" id="imagemProduto" name="imagemProduto" required>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Produto</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
