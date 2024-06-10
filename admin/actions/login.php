<?php
session_start();

include('../../actions/connection.php');

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = $_POST['password'];

try {
    $sql = "SELECT id, senha, nome, sobrenome FROM admin WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id']; 
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['usuario_sobrenome'] = $user['sobrenome'];
            $_SESSION['logado'] = true;

            header("Location: ../index.php");
            exit;
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Email não encontrado!";
    }
} catch (PDOException $e) {
    echo "Erro no login: " . $e->getMessage();
}
?>
