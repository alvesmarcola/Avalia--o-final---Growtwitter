<?php
session_start();
require_once "conexion.php";

function logout(){
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
};

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: index.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>GrowTwitter</h1>

    <form action="<?php echo htmlespecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="submit" name="logout" value="Logout">
    </form>

    <?php

    if(isset($_POST["logout"])){
        logout();
    }

    ?>

</body>
</html>