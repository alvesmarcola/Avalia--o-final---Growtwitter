<?php
require_once("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO cadastro (nome, username, email, password) VALUES (?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $nome, $username, $email, $password);

        if ($stmt->execute()){
            $_SESSION['error'] = 'Usuario criado!';

        } else {
            echo "Erro: " . $sql . "<br>" . $conexao->error;
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da consulta: " . $conexao->error;
    }
    
}
$conexao->close();
?>
