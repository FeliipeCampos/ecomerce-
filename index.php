<?php include('header.php'); 
include('actions/connection.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Nome</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
    
<div id="carrossel_index" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $sql = "SELECT * FROM carrossel LIMIT 1"; 
        $stmt = $conn->query($sql);
        if ($carrossel = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $imagem1 = $carrossel["imagem1"];
            $link1 = $carrossel["link1"];
            $imagem2 = $carrossel["imagem2"];
            $link2 = $carrossel["link2"];
            $imagem3 = $carrossel["imagem3"];
            $link3 = $carrossel["link3"];
        ?>
            <div class='carousel-item active'>
                <?php if ($link1): ?>
                    <a href='<?php echo $link1; ?>' target='_blank'><img class='d-block w-100' src='imagens_carrossel/<?php echo $imagem1; ?>' alt='Slide 1'></a>
                <?php else: ?>
                    <img class='d-block w-100' src='imagens_carrossel/<?php echo $imagem1; ?>' alt='Slide 1'>
                <?php endif; ?>
            </div>
            <div class='carousel-item'>
                <?php if ($link2): ?>
                    <a href='<?php echo $link2; ?>' target='_blank'><img class='d-block w-100' src='imagens_carrossel/<?php echo $imagem2; ?>' alt='Slide 2'></a>
                <?php else: ?>
                    <img class='d-block w-100' src='imagens_carrossel/<?php echo $imagem2; ?>' alt='Slide 2'>
                <?php endif; ?>
            </div>
            <div class='carousel-item'>
                <?php if ($link3): ?>
                    <a href='<?php echo $link3; ?>' target='_blank'><img class='d-block w-100' src='imagens_carrossel/<?php echo $imagem3; ?>' alt='Slide 3'></a>
                <?php else: ?>
                    <img class='d-block w-100' src='imagens_carrossel/<?php echo $imagem3; ?>' alt='Slide 3'>
                <?php endif; ?>
            </div>
        <?php
        }
        ?>
    </div>
    <a class="carousel-control-prev" href="#carrossel_index" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carrossel_index" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>

<div class="container mt-5 mb-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php
        $stmt = $conn->query("SELECT * FROM produtos WHERE status = 'ativo'");

        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Calcula as avaliações para cada produto
            $sql_avaliacoes = "SELECT COUNT(*) AS total_avaliacoes, AVG(nota) AS media_avaliacoes FROM avaliacoes WHERE id_produto = :id_produto";
            $stmt_avaliacoes = $conn->prepare($sql_avaliacoes);
            $stmt_avaliacoes->bindParam(':id_produto', $produto['id'], PDO::PARAM_INT);
            $stmt_avaliacoes->execute();
            $avaliacoes = $stmt_avaliacoes->fetch(PDO::FETCH_ASSOC);
            
            $mediaAvaliacoes = $avaliacoes['media_avaliacoes'] ? number_format($avaliacoes['media_avaliacoes'], 1) : "0";
            $totalAvaliacoes = $avaliacoes['total_avaliacoes'];

            // Calcula o número de vendas confirmadas para cada produto
            $sql_vendas = "SELECT COUNT(*) AS total_vendas FROM vendas WHERE id_produto = :id_produto AND status = 'confirmado'";
            $stmt_vendas = $conn->prepare($sql_vendas);
            $stmt_vendas->bindParam(':id_produto', $produto['id'], PDO::PARAM_INT);
            $stmt_vendas->execute();
            $vendas = $stmt_vendas->fetch(PDO::FETCH_ASSOC);
            
            $totalVendas = $vendas['total_vendas'];
        ?>
            <div class="col">
                <div class="card h-100">
                    <a href="produto.php?id=<?php echo($produto['id']); ?>">
                        <img src="<?php echo("imagens/" . $produto['imagem']); ?>" class="card-img-top" alt="<?php echo($produto['nome']); ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="produto.php?id=<?php echo($produto['id']); ?>">
                                <?php echo($produto['nome']); ?>
                            </a>
                        </h5>
                        <p class="card-text"><?php echo($produto['descricao']); ?></p>
                        <p class="card-text text-warning"><i class="fas fa-star"></i> <?php echo $mediaAvaliacoes; ?>/5 (<?php echo $totalAvaliacoes; ?> avaliações)</p>                        
                        <p class="card-text">R$ <?php echo(number_format($produto['preco'], 2, ',', '.')); ?></p>
                        <p class="card-text"><i class="fas fa-shopping-cart"></i> <?php echo $totalVendas; ?> vendas</p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
