<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Imagens ao Carrossel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Adicionar Imagens ao Carrossel</h2>
        <form action="actions/carrossel.php" method="post" enctype="multipart/form-data">
        <!-- Imagem 1 -->
        <div class="mb-3">
            <label for="imagem1" class="form-label">Imagem 1</label>
            <input type="file" class="form-control" id="imagem1" name="imagem1" required>
        </div>
        <div class="mb-3">
            <label for="linkImagem1" class="form-label">Link para Imagem 1 (Opcional)</label>
            <input type="text" class="form-control" id="linkImagem1" name="linkImagem1">
            <div id="linkHelp1" class="form-text">Se fornecer um link, os usuários poderão clicar na imagem do banner para serem redirecionados.</div>
        </div>

        <!-- Imagem 2 -->
        <div class="mb-3">
            <label for="imagem2" class="form-label">Imagem 2 (Opcional)</label>
            <input type="file" class="form-control" id="imagem2" name="imagem2" required>
        </div>
        <div class="mb-3">
            <label for="linkImagem2" class="form-label">Link para Imagem 2 (Opcional)</label>
            <input type="text" class="form-control" id="linkImagem2" name="linkImagem2">
            <div id="linkHelp2" class="form-text">Se fornecer um link, os usuários poderão clicar na imagem do banner para serem redirecionados.</div>
        </div>

        <!-- Imagem 3 -->
        <div class="mb-3">
            <label for="imagem3" class="form-label">Imagem 3 (Opcional)</label>
            <input type="file" class="form-control" id="imagem3" name="imagem3" required>
        </div>
        <div class="mb-3">
            <label for="linkImagem3" class="form-label">Link para Imagem 3 (Opcional)</label>
            <input type="text" class="form-control" id="linkImagem3" name="linkImagem3">
            <div id="linkHelp3" class="form-text">Se fornecer um link, os usuários poderão clicar na imagem do banner para serem redirecionados.</div>
        </div>

        <button type="submit" class="btn btn-primary">Adicionar Imagens</button>
    </form>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
