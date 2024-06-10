<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Endereço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <?php
    include('../actions/connection.php');
    $preference_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if ($preference_id) {
        $stmt = $conn->prepare("SELECT * FROM endereco WHERE preference_id = :preference_id");
        $stmt->bindParam(':preference_id', $preference_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $endereco = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h2>Visualizar Endereço</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Nome:</strong> <?php echo($endereco['nome']); ?></p>
            <p><strong>Telefone:</strong> <?php echo($endereco['telefone']); ?></p>
            <p><strong>CEP:</strong> <?php echo($endereco['cep']); ?></p>
            <p><strong>Endereço:</strong> <?php echo($endereco['endereco']); ?></p>
            <p><strong>Complemento:</strong> <?php echo($endereco['complemento']); ?></p>
            <p><strong>Bairro:</strong> <?php echo($endereco['bairro']); ?></p>
            <p><strong>Cidade:</strong> <?php echo($endereco['cidade']); ?></p>
            <p><strong>Estado:</strong> <?php echo($endereco['estado']); ?></p>
        </div>
    </div>
    <?php
        } else {
            echo "<p>Endereço não encontrado.</p>";
        }
    } else {
        echo "<p>ID inválido.</p>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
