<?php
$servername = "lojafelipecode.com.br";
$username = "u914670513_felipecampos";
$password = "/x0HY36l&8V";
$database = "u914670513_felipecode";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Conexão falhou: " . $e->getMessage();
}
?>