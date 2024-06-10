<?php
session_start();

include('connection.php');

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = $_POST['password'];
$redirect = filter_input(INPUT_POST, 'redirect', FILTER_SANITIZE_STRING); // Captura o redirect

try {
    $sql = "SELECT id, senha, nome, sobrenome FROM usuarios WHERE email = :email";
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

            if (!empty($redirect)) {
                header("Location: $redirect"); // Usa o valor de redirect se não estiver vazio
            } else {
                header("Location: ../index.php"); // Redireciona para a index se redirect estiver vazio
            }
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
