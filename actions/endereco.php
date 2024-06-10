<?php
include('connection.php');

// Recupera os dados do formulário
$idProduto = filter_input(INPUT_POST, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
$idUsuario = filter_input(INPUT_POST, 'idUsuario', FILTER_SANITIZE_NUMBER_INT);
$nomeCompleto = filter_input(INPUT_POST, 'nomeCompleto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$transacao_id = filter_input(INPUT_POST, 'transacao_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS); 

try {
    // Prepara a consulta SQL para inserção no banco de dados
    $sql = "INSERT INTO endereco (nome, telefone, cep, endereco, numero, complemento, bairro, cidade, estado, id_usuario, id_produto, transacao_id) VALUES (:nome, :telefone, :cep, :endereco, :numero, :complemento, :bairro, :cidade, :estado, :id_usuario, :id_produto, :transacao_id)";
    $stmt = $conn->prepare($sql);

    // Vincula os parâmetros aos valores recebidos do formulário
    $stmt->bindParam(':nome', $nomeCompleto);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':complemento', $complemento);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
    $stmt->bindParam(':transacao_id', $transacao_id);

    // Executa a consulta
    $stmt->execute();

    // Redireciona para a página de processamento de compra
    header("Location: processar_compra.php?idProduto=" . $idProduto . "&transacao_id=" . $transacao_id);
} catch(PDOException $e) {
    echo "Erro ao salvar endereço: " . $e->getMessage();
}
?>
