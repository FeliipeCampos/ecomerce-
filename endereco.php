<?php 
include('actions/connection.php');
include('header.php');

// Recupera o ID do produto da URL de forma segura
$idProduto = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$transacao_id = uniqid('transacao_'); 

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
    <title>Endereço de Entrega: <?php echo($produto['nome']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <!-- Informações do Produto à Esquerda -->
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

    <!-- Formulário de Endereço de Entrega à Direita -->
    <div class="col-md-8">
        <h2>Endereço de Entrega</h2>
        <form action="actions/endereco.php" method="post">
            <!-- Campos invisíveis para id_usuario e id_produto -->
            <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['usuario_id']; ?>">
            <input type="hidden" name="idProduto" value="<?php echo $idProduto; ?>">
            <input type="hidden" name="transacao_id" value="<?php echo $transacao_id; ?>">

            <div class="mb-3">
                <label for="nomeCompleto" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nomeCompleto" name="nomeCompleto" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
            </div>
            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" required>
            </div>
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" required>
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número da Residência</label>
                <input type="text" class="form-control" id="numero" name="numero" required>
            </div>
            <div class="mb-3">
                <label for="complemento" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="complemento" name="complemento">
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" required>
            </div>
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado" required>
            </div>
            <button type="submit" class="btn btn-primary">Confirmar Endereço</button>
        </form>
    </div>


<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
