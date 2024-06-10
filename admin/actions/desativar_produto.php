<?php
// Inicia a sessão
session_start();

// Inclui a conexão com o banco de dados
include('../../actions/connection.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['logado'])) {
    echo "Usuário não logado!";
    exit;
}

// Verifica se o ID do produto foi passado
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id) {
    echo "ID inválido!";
    exit;
}

try {
    // Prepara a query para atualizar o status do produto para 'desativado'
    $sql = "UPDATE produtos SET status = 'desativado' WHERE id = :id";
    $stmt = $conn->prepare($sql);

    // Vincula o parâmetro ':id' ao valor do ID do produto, com o tipo adequado
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Executa a query
    $stmt->execute();

    // Verifica se a atualização foi realizada
    if ($stmt->rowCount()) {
        // Se o produto foi desativado com sucesso, redireciona para a página de visualização de produtos
        header("Location: ../visualizar_produtos.php");
        exit;
    } else {
        echo "Produto não encontrado ou já desativado.";
    }
} catch (PDOException $e) {
    echo "Erro ao desativar produto: " . $e->getMessage();
}
?>
