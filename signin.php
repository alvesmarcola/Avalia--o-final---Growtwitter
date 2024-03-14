<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        include_once('conexion.php');
        $email = $_POST['email'];
        $senha = $_POST['password'];

        $sql = "SELECT * FROM cadastro WHERE email = ? LIMIT 1";
        $stmt = $conexao->prepare($sql);

        // Verificando se a preparação da consulta foi bem-sucedida
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                // Verificando a senha
                if ($senha === $row['password']) {
                    $_SESSION['logado'] = true;
                    $_SESSION['username'] = $row['username']; // Salvando o username na sessão, se necessário
                    header("Location: home.php");
                    exit;
                } else {
                    $_SESSION['error'] = 'Senha incorreta';
                }
            } else {
                $_SESSION['error'] = 'Usuário não encontrado';
            }
        
            $stmt->close();
        } else {
            $_SESSION['error'] = 'Erro na preparação da consulta';
        }
    } else {
        $_SESSION['error'] = 'Por favor, preencha todos os campos';
    }
} else {
    $_SESSION['error'] = 'Método de requisição inválido';
}

header("Location: index.php"); 
exit;
?>
