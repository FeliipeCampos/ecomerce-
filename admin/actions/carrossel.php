<?php
include('../../actions/connection.php');

// Variáveis para os links opcionais
$link1 = filter_input(INPUT_POST, 'linkImagem1', FILTER_SANITIZE_URL);
$link2 = filter_input(INPUT_POST, 'linkImagem2', FILTER_SANITIZE_URL);
$link3 = filter_input(INPUT_POST, 'linkImagem3', FILTER_SANITIZE_URL);

$imagens = ['imagem1', 'imagem2', 'imagem3'];
$nomesImagens = []; // Armazena os nomes das imagens processadas

// Diretório onde as imagens do carrossel serão salvas
$diretorio = "../../imagens_carrossel";

foreach ($imagens as $imagem) {
    if (isset($_FILES[$imagem]) && $_FILES[$imagem]['error'] == 0) {
        $nomeImagem = uniqid('img_') . '.jpg'; // Nome único para a imagem
        $caminhoCompleto = $diretorio . '/' . $nomeImagem;

        // Carrega a imagem original
        $imagemOriginal = imagecreatefromstring(file_get_contents($_FILES[$imagem]['tmp_name']));

        // Verifica se a imagem foi carregada com sucesso
        if ($imagemOriginal !== false) {
            // Define o tamanho final da imagem
            $larguraFinal = 960;
            $alturaFinal = 300;

            // Cria uma nova imagem com as dimensões desejadas
            $imagemFinal = imagecreatetruecolor($larguraFinal, $alturaFinal);

            // Obtém as dimensões da imagem original
            list($larguraOriginal, $alturaOriginal) = getimagesize($_FILES[$imagem]['tmp_name']);

            // Copia e redimensiona a imagem original para a nova imagem
            imagecopyresampled($imagemFinal, $imagemOriginal, 0, 0, 0, 0, $larguraFinal, $alturaFinal, $larguraOriginal, $alturaOriginal);

            // Salva a nova imagem no diretório destino
            if (imagejpeg($imagemFinal, $caminhoCompleto)) {
                $nomesImagens[] = $nomeImagem; // Adiciona o nome da imagem processada ao array
            } else {
                echo "Erro ao salvar a imagem $imagem.";
            }

            // Libera a memória associada à imagem
            imagedestroy($imagemFinal);
            imagedestroy($imagemOriginal);
        } else {
            echo "O arquivo $imagem não é uma imagem válida.";
        }
    }
}

// Inserção no banco de dados
try {
    $sql = "INSERT INTO carrossel (imagem1, imagem2, imagem3, link1, link2, link3) VALUES (:imagem1, :imagem2, :imagem3, :link1, :link2, :link3)";
    $stmt = $conn->prepare($sql);

    // Vincula os parâmetros às variáveis (nomes das imagens e links)
    $stmt->bindParam(':imagem1', $nomesImagens[0], PDO::PARAM_STR);
    $stmt->bindParam(':imagem2', $nomesImagens[1], PDO::PARAM_STR);
    $stmt->bindParam(':imagem3', $nomesImagens[2], PDO::PARAM_STR);
    $stmt->bindParam(':link1', $link1, PDO::PARAM_STR);
    $stmt->bindParam(':link2', $link2, PDO::PARAM_STR);
    $stmt->bindParam(':link3', $link3, PDO::PARAM_STR);

    $stmt->execute();

    header("Location: ../index.php");
} catch(PDOException $e) {
    echo "Erro ao inserir dados no banco: " . $e->getMessage();
}
?>
