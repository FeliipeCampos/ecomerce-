<?php
include('../../actions/connection.php');

$nomeProduto = filter_input(INPUT_POST, 'nomeProduto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$descricaoProduto = filter_input(INPUT_POST, 'descricaoProduto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$precoProduto = filter_input(INPUT_POST, 'precoProduto', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$imagemProduto = $_FILES['imagemProduto'];
$statusProduto = 'ativo'; 

// Gerar um nome de arquivo aleatório para a imagem
$nomeImagem = uniqid('img_') . '.jpg';

// Diretório onde as imagens serão salvas
$diretorio = "../../imagens";

// Verifica se o arquivo é uma imagem
if (getimagesize($imagemProduto['tmp_name'])) {
    // Define o tamanho final da imagem
    $larguraFinal = 500;
    $alturaFinal = 500;

    // Cria uma nova imagem com as dimensões desejadas
    $imagemFinal = imagecreatetruecolor($larguraFinal, $alturaFinal);

    // Carrega a imagem original
    $imagemOriginal = imagecreatefromstring(file_get_contents($imagemProduto['tmp_name']));

    // Obtém as dimensões da imagem original
    list($larguraOriginal, $alturaOriginal) = getimagesize($imagemProduto['tmp_name']);

    // Copia e redimensiona a imagem original para a nova imagem
    imagecopyresampled($imagemFinal, $imagemOriginal, 0, 0, 0, 0, $larguraFinal, $alturaFinal, $larguraOriginal, $alturaOriginal);

    // Caminho completo de destino, agora corrigido
    $caminhoCompleto = $diretorio . '/' . $nomeImagem;

    // Tenta salvar a nova imagem no diretório destino
    if (imagejpeg($imagemFinal, $caminhoCompleto)) {
        try {
            $sql = "INSERT INTO produtos (nome, descricao, preco, imagem, status) VALUES (:nome, :descricao, :preco, :imagem, :status)";
            $stmt = $conn->prepare($sql);
    
            $stmt->bindParam(':nome', $nomeProduto, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricaoProduto, PDO::PARAM_STR);
            $stmt->bindParam(':preco', $precoProduto, PDO::PARAM_STR);
            $stmt->bindParam(':imagem', $nomeImagem, PDO::PARAM_STR);
            $stmt->bindParam(':status', $statusProduto, PDO::PARAM_STR); 
    
            $stmt->execute();
    
            header("Location: ../index.php");
        } catch(PDOException $e) {
            echo "Erro ao cadastrar produto: " . $e->getMessage();
        }
    } else {
        echo "Erro ao salvar a imagem do produto.";
    }

    // Libera a memória associada à imagem
    imagedestroy($imagemFinal);
    imagedestroy($imagemOriginal);

} else {
    echo "O arquivo enviado não é uma imagem válida.";
}
?>
