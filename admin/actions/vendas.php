<?php
include('../../actions/connection.php');

$idVenda = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); 

if(!$idVenda) {
    echo "Venda inválida.";
    exit;
}

try {
    $sql = "UPDATE vendas SET status_entrega = 'entregue' WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $idVenda, PDO::PARAM_INT);

    $stmt->execute();

    header("Location: ../vendas.php");
} catch(PDOException $e) {
    echo "Erro ao marcar venda como entregue: " . $e->getMessage();
}
?>
