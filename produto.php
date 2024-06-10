<?php
include('actions/connection.php');

$idProduto = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if ($idProduto) {
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $idProduto, PDO::PARAM_INT);
    $stmt->execute();
    
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$produto) {
        echo "Produto não encontrado.";
        exit;
    }
    
    $sql_vendas = "SELECT COUNT(*) AS total_vendas FROM vendas WHERE id_produto = :id_produto AND status = 'confirmado'";
    $stmt_vendas = $conn->prepare($sql_vendas);
    $stmt_vendas->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
    $stmt_vendas->execute();
    $vendas = $stmt_vendas->fetch(PDO::FETCH_ASSOC);
    $totalVendas = $vendas['total_vendas'];
} else {
    echo "ID de produto inválido.";
    exit;
}
include('header.php');
?>


<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo($produto['nome']); ?></title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-6">
            <img src="<?php echo("imagens/" . $produto['imagem']); ?>" class="img-fluid" alt="<?php echo($produto['nome']); ?>">
        </div>
        <div class="col-lg-6">
            <h2><?php echo($produto['nome']); ?></h2>
            <p class="text-muted"><?php echo($produto['descricao']); ?></p>
            <?php
            $sql_avaliacoes_count = "SELECT COUNT(*) AS total_avaliacoes, AVG(nota) AS media_avaliacoes FROM avaliacoes WHERE id_produto = :id_produto";
            $stmt_avaliacoes_count = $conn->prepare($sql_avaliacoes_count);
            $stmt_avaliacoes_count->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
            $stmt_avaliacoes_count->execute();
            $avaliacoes_count = $stmt_avaliacoes_count->fetch(PDO::FETCH_ASSOC);
            ?>
            <p class="text-warning">
                <i class="fas fa-star"></i> <?php echo number_format($avaliacoes_count['media_avaliacoes'], 1); ?>/5 (<?php echo $avaliacoes_count['total_avaliacoes']; ?> avaliações)
            </p>
            <p class="fw-bold">R$ <?php echo(number_format($produto['preco'], 2, ',', '.')); ?></p>
            <p><i class="fas fa-shopping-cart"></i> <?php echo $totalVendas; ?> vendas</p>
            <div class="mt-4">
            <?php
                if (isset($_SESSION['usuario_id'])) {
                    echo '<a href="endereco.php?id=' . $idProduto . '" class="btn btn-primary">Comprar</a>';
                } else {
                    echo '<a href="login.php?redirect=../produto.php?id=' . $idProduto . '" class="btn btn-primary">Comprar</a>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3>Avaliações</h3>
            <hr>
            <div class="mb-3">
                <?php
                if (isset($_SESSION['usuario_id'])) {
                    echo '<a href="avaliacao.php?id=' . $idProduto . '" class="btn btn-primary">Deixar Avaliação</a>';
                } else {
                    echo '<a href="login.php?redirect=../avaliacao.php?id=' . $idProduto . '" class="btn btn-primary">Deixar Avaliação</a>';
                }
                ?>
            </div>

            <?php
            $sql_avaliacoes = "SELECT avaliacoes.*, usuarios.nome, usuarios.sobrenome FROM avaliacoes 
                                INNER JOIN usuarios ON avaliacoes.id_usuario = usuarios.id 
                                WHERE id_produto = :id_produto";
            $stmt_avaliacoes = $conn->prepare($sql_avaliacoes);
            $stmt_avaliacoes->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
            $stmt_avaliacoes->execute();
            $avaliacoes = $stmt_avaliacoes->fetchAll(PDO::FETCH_ASSOC);

            foreach ($avaliacoes as $avaliacao) {
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="text-warning">
                            <?php
                            $nota = $avaliacao['nota'];
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $nota ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                            }
                            ?>
                            <?php echo $nota ?>/5
                        </p>
                        <h5 class="card-title"><?php echo($avaliacao['nome'] . ' ' . $avaliacao['sobrenome']); ?></h5>
                        <p><?php echo($avaliacao['avaliacao']); ?></p>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="imagens_avaliacoes/<?php echo($avaliacao['imagem1']); ?>" class="img-fluid img-thumbnail imagem-preview" alt="Foto 1" style="height: 100px; object-fit: cover;" data-src="imagens_avaliacoes/<?php echo($avaliacao['imagem1']); ?>">
                            </div>
                            <div class="col-md-4">
                                <img src="imagens_avaliacoes/<?php echo($avaliacao['imagem2']); ?>" class="img-fluid img-thumbnail imagem-preview" alt="Foto 2" style="height: 100px; object-fit: cover;" data-src="imagens_avaliacoes/<?php echo($avaliacao['imagem2']); ?>">
                            </div>
                            <div class="col-md-4">
                                <img src="imagens_avaliacoes/<?php echo($avaliacao['imagem3']); ?>" class="img-fluid img-thumbnail imagem-preview" alt="Foto 3" style="height: 100px; object-fit: cover;" data-src="imagens_avaliacoes/<?php echo($avaliacao['imagem3']); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="imagemModal" tabindex="-1" aria-labelledby="imagemModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="" class="img-fluid" id="imagemModalSrc" alt="Visualização da Imagem">
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var images = document.querySelectorAll('.imagem-preview');

  images.forEach(function(image) {
    image.addEventListener('click', function() {
      var src = this.getAttribute('data-src');
      document.getElementById('imagemModalSrc').src = src;
      var modal = new bootstrap.Modal(document.getElementById('imagemModal'));
      modal.show();
    });
  });
});
</script>

<!-- Bootstrap Bundle with Popper -->
</body>
</html>
