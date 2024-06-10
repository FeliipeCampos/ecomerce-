<?php
include('../../actions/connection.php');

$idProduto = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
$nomeProduto = filter_input(INPUT_POST, 'nomeProduto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$descricaoProduto = filter_input(INPUT_POST, 'descricaoProduto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$precoProduto = filter_input(INPUT_POST, 'precoProduto', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$imagemProduto = $_FILES['imagemProduto'];

// Verifica se o arquivo de imagem foi fornecido
$imagemAtualizada = false;
$nomeImagem = "";

if (isset($imagemProduto) && $imagemProduto['error'] == 0) {
    // Gerar um nome de arquivo aleatório para a imagem
    $nomeImagem = uniqid('img_') . '.jpg';
    $diretorio = "../../imagens";
    $caminhoCompleto = $diretorio . '/' . $nomeImagem;

    if (getimagesize($imagemProduto['tmp_name'])) {
        $larguraFinal = 500;
        $alturaFinal = 500;
        $imagemFinal = imagecreatetruecolor($larguraFinal, $alturaFinal);
        $imagemOriginal = imagecreatefromstring(file_get_contents($imagemProduto['tmp_name']));
        list($larguraOriginal, $alturaOriginal) = getimagesize($imagemProduto['tmp_name']);
        imagecopyresampled($imagemFinal, $imagemOriginal, 0, 0, 0, 0, $larguraFinal, $alturaFinal, $larguraOriginal, $alturaOriginal);

        if (imagejpeg($imagemFinal, $caminhoCompleto)) {
            $imagemAtualizada = true;
        } else {
            echo "Erro ao salvar a imagem do produto.";
            exit;
        }
        imagedestroy($imagemFinal);
        imagedestroy($imagemOriginal);
    } else {
        echo "O arquivo enviado não é uma imagem válida.";
        exit;
    }
}

try {
    if ($imagemAtualizada) {
        $sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, imagem = :imagem WHERE id = :id";
    } else {
        $sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id";
    }

    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':id', $idProduto, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nomeProduto, PDO::PARAM_STR);
    $stmt->bindParam(':descricao', $descricaoProduto, PDO::PARAM_STR);
    $stmt->bindParam(':preco', $precoProduto, PDO::PARAM_STR);
    if ($imagemAtualizada) {
        $stmt->bindParam(':imagem', $nomeImagem, PDO::PARAM_STR);
    }
    
    $stmt->execute();

    header("Location: ../index.php");
} catch(PDOException $e) {
    echo "Erro ao atualizar produto: " . $e->getMessage();
}
?>
