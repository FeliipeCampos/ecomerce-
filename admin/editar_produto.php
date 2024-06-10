<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <?php
    include('../actions/connection.php');
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    if ($id) {
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h2>Editar Produto</h2>
    <form action="actions/atualizar_produto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idProduto" value="<?php echo($produto['id']); ?>">
        <div class="mb-3">
            <label for="nomeProduto" class="form-label">Nome do Produto</label>
            <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" required value="<?php echo($produto['nome']); ?>">
        </div>
        <div class="mb-3">
            <label for="descricaoProduto" class="form-label">Descrição do Produto</label>
            <textarea class="form-control" id="descricaoProduto" name="descricaoProduto" rows="3"><?php echo($produto['descricao']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="precoProduto" class="form-label">Preço do Produto</label>
            <input type="text" class="form-control" id="precoProduto" name="precoProduto" required value="<?php echo($produto['preco']); ?>">
        </div>
        <div class="mb-3">
            <label for="imagemProdutoAtual" class="form-label">Imagem Atual do Produto</label>
            <div>
                <img src="../imagens/<?php echo($produto['imagem']); ?>" width="100" alt="Imagem do Produto">
            </div>
        </div>
        <div class="mb-3">
            <label for="imagemProduto" class="form-label">Alterar Imagem do Produto</label>
            <input type="file" class="form-control" id="imagemProduto" name="imagemProduto">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Produto</button>
    </form>
    <?php
        } else {
            echo "<p>Produto não encontrado.</p>";
        }
    } else {
        echo "<p>ID inválido.</p>";
    }
    ?>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
