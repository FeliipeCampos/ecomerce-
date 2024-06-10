<?php 
include('actions/connection.php');
include('header.php');

// Recupera o ID do produto da URL de forma segura
$idProduto = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if ($idProduto) {
    // Prepara a consulta SQL para evitar SQL Injection
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $idProduto, PDO::PARAM_INT);
    $stmt->execute();
    
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$produto) {
        echo "Produto não encontrado.";
        exit;
    }
} else {
    echo "ID de produto inválido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliar Produto: <?php echo($produto['nome']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <!-- Informações do Produto em um Card à Esquerda -->
        <div class="col-md-4">
            <div class="card">
                <img src="<?php echo('imagens/' . $produto['imagem']); ?>" class="card-img-top" alt="<?php echo($produto['nome']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo($produto['nome']); ?></h5>
                    <p class="card-text"><?php echo($produto['descricao']); ?></p>
                    <p class="fw-bold">Preço: R$ <?php echo(number_format($produto['preco'], 2, ',', '.')); ?></p>
                </div>
            </div>
        </div>

        <!-- Área de Avaliação Principal à Direita -->
        <div class="col-md-8">
            <h2>Avaliar Produto</h2>
            <form action="actions/criar_avaliacao.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idProduto" value="<?php echo $idProduto; ?>">
                <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['usuario_id']; ?>"> 
                
                <div class="mb-3">
                    <label for="textoAvaliacao" class="form-label">Texto da Avaliação</label>
                    <textarea class="form-control" id="textoAvaliacao" name="textoAvaliacao" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="notaAvaliacao" class="form-label">Nota (1 a 5 estrelas)</label>
                    <select class="form-select" id="notaAvaliacao" name="notaAvaliacao" required>
                        <option value="1">1 Estrela</option>
                        <option value="2">2 Estrelas</option>
                        <option value="3">3 Estrelas</option>
                        <option value="4">4 Estrelas</option>
                        <option value="5">5 Estrelas</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="imagemAvaliacao1" class="form-label">Imagem 1 (Opcional)</label>
                    <input type="file" class="form-control" id="imagemAvaliacao1" name="imagemAvaliacao1">
                </div>
                <div class="mb-3">
                    <label for="imagemAvaliacao2" class="form-label">Imagem 2 (Opcional)</label>
                    <input type="file" class="form-control" id="imagemAvaliacao2" name="imagemAvaliacao2">
                </div>
                <div class="mb-3">
                    <label for="imagemAvaliacao3" class="form-label">Imagem 3 (Opcional)</label>
                    <input type="file" class="form-control" id="imagemAvaliacao3" name="imagemAvaliacao3">
                </div>
                <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
