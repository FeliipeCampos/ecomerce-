<?php
session_start(); 
include('connection.php');
require_once '../vendor/autoload.php';

// Configuração do SDK do MercadoPago
MercadoPago\SDK::setAccessToken("APP_USR-1673542333608499-031411-c6d69a6d3f51e4e49ffcd9fc4d726444-1443321131");

// Captura o idProduto da URL
$idProduto = filter_input(INPUT_GET, 'idProduto', FILTER_SANITIZE_NUMBER_INT);
$transacao_id = filter_input(INPUT_GET, 'transacao_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Busca informações do produto
$sql = "SELECT * FROM produtos WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $idProduto, PDO::PARAM_INT);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    echo "Produto não encontrado.";
    exit;
}

// Criação do item para a venda
$item = new MercadoPago\Item();
$item->title = $produto['nome'];
$item->quantity = 1;
$item->unit_price = $produto['preco'];

// Criação da preferência de pagamento
$preference = new MercadoPago\Preference();
$preference->items = array($item);
$preference->save();

if ($preference->id) {
    if(isset($_SESSION['usuario_id'])) {
        $idUsuario = $_SESSION['usuario_id'];

        $status = "pendente";
        // Atualize sua consulta SQL para incluir o campo status_entrega
        $sqlVenda = "INSERT INTO vendas (id_produto, nome_produto, preco, status, status_entrega, preference_id, data_venda, id_usuario) VALUES (:id_produto, :nome_produto, :preco, :status, :status_entrega, :preference_id, NOW(), :usuario_id)";
        $stmtVenda = $conn->prepare($sqlVenda);
        
        $stmtVenda->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
        $stmtVenda->bindParam(':nome_produto', $produto['nome'], PDO::PARAM_STR);
        $stmtVenda->bindParam(':preco', $produto['preco'], PDO::PARAM_STR);
        $stmtVenda->bindParam(':status', $status, PDO::PARAM_STR);
        // Adicionando a mesma variável status ao campo status_entrega
        $stmtVenda->bindParam(':status_entrega', $status, PDO::PARAM_STR);
        $stmtVenda->bindParam(':preference_id', $preference->id, PDO::PARAM_STR);
        $stmtVenda->bindParam(':usuario_id', $idUsuario, PDO::PARAM_INT);
        
        if ($stmtVenda->execute()) {
            
            // Atualizar o campo preference_id na tabela endereco com o preference_id
            $sqlUpdateEndereco = "UPDATE endereco SET preference_id = :preference_id WHERE transacao_id = :transacao_id";
            $stmtUpdateEndereco = $conn->prepare($sqlUpdateEndereco);
            $stmtUpdateEndereco->bindParam(':preference_id', $preference->id, PDO::PARAM_STR);
            $stmtUpdateEndereco->bindParam(':transacao_id', $transacao_id, PDO::PARAM_STR);
            $stmtUpdateEndereco->execute();
            
            // Redireciona o usuário para a página de checkout do MercadoPago
            header("Location: " . $preference->init_point);
            exit;
        } else {
            echo "Erro ao registrar a venda no banco de dados.";
            exit;
        }
    } else {
        echo "Usuário não logado.";
        exit;
    }
} else {
    echo "Erro ao criar a preferência de pagamento.";
    exit;
}
?>