<?php
include('connection.php');

$idProduto = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
$idUsuario = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_NUMBER_INT); 
$avaliacaoTexto = filter_input(INPUT_POST, 'textoAvaliacao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$notaAvaliacao = filter_input(INPUT_POST, 'notaAvaliacao', FILTER_SANITIZE_NUMBER_INT);
$imagens = ['imagemAvaliacao1', 'imagemAvaliacao2', 'imagemAvaliacao3'];
$nomesImagens = [];

$diretorio = "../imagens_avaliacoes";

foreach ($imagens as $imagem) {
    if (isset($_FILES[$imagem]) && $_FILES[$imagem]['error'] == 0) {
        $nomeImagem = uniqid('img_') . '.jpg';
        $caminhoCompleto = $diretorio . '/' . $nomeImagem;

        if (move_uploaded_file($_FILES[$imagem]['tmp_name'], $caminhoCompleto)) {
            // Armazena o nome do arquivo para inserção no banco
            $nomesImagens[] = $nomeImagem;
        } else {
            // Caso o upload falhe, adiciona null ao array
            $nomesImagens[] = null;
        }
    } else {
        // Caso o arquivo não seja enviado, adiciona null ao array
        $nomesImagens[] = null;
    }
}

try {
    $sql = "INSERT INTO avaliacoes (id_produto, id_usuario, avaliacao, nota, imagem1, imagem2, imagem3) VALUES (:id_produto, :id_usuario, :avaliacao, :nota, :imagem1, :imagem2, :imagem3)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
    $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(':avaliacao', $avaliacaoTexto, PDO::PARAM_STR);
    $stmt->bindParam(':nota', $notaAvaliacao, PDO::PARAM_INT);
    $stmt->bindParam(':imagem1', $nomesImagens[0], PDO::PARAM_STR);
    $stmt->bindParam(':imagem2', $nomesImagens[1], PDO::PARAM_STR);
    $stmt->bindParam(':imagem3', $nomesImagens[2], PDO::PARAM_STR);

    $stmt->execute();

    header("Location: ../index.php");
} catch(PDOException $e) {
    echo "Erro ao cadastrar avaliação: " . $e->getMessage();
}
?>
