<?php
session_start();

require_once "conexion.php";

if ($_SERVER ['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

}

$sql = "SELECT * FROM cadastro WHERE username = ? AND email = ?";


$stmt = $conexao->prepare($sql);
$stmt ->bind_param("ss", $username, $email);
$stmt->execute(); 

$result = $stmt->get_result();

if( $result ->num_rows === 1){
    $row = $result -> fetch_assoc();

    if(password_verify($password, $row['password'])){
        $_SESSION['logado'] = true;

        header("location: home.php ");
        exit;
    }
} else{
    $error = "Usuarios ou senha incorretos!";
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GrowTwitter</title>
    <link rel="shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/6/6f/Logo_of_Twitter.svg" type="image/x-icon">

    <!--Css Local-->
    <link rel="stylesheet" href="./assets/css/style.css">

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"></script>
</head>
<body>
<section class="vh-100 d-flex justify-content-center align-items-center" style="background-color: hsl(0, 0%, 96%);">
    
    <div class="px-4 py-5 px-md-5 text-center text-lg-start" >
        <div class="row gx-lg-5 align-items-center justify-content-center"> 
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="my-5 display-3 fw-bold ls-tight">
                    Bem vindo <br />
                    <span class="text-primary">ao GrowTwitter</span>
                </h1>
                <p style="color: hsl(217, 10%, 50.8%)">
                    Tweet entre Growdevers!
                </p>
            </div>

            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card">
                    <div class="card-body py-5 px-md-5">

                        <form action="signin.php" method="post">

                            <div class="mb-4">
                                <label class="form-label" for="loginInput">Email</label>
                                <input type="text" id="loginEmail" class="form-control" name="email" required />
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <label class="form-label" for="loginPassword">Senha</label>
                                <input type="password" id="loginPassword" class="form-control" name="password" required />
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-info btn-rounded text-white" style="width: 90%; border-radius: 25px;">
                                Login
                            </button>

                            <!-- Register buttons -->
                            <div class="text-center">
                                <a href="#" id="openModalBtn" data-bs-toggle="modal" data-bs-target="#registerModal"
                                style="text-decoration: none;"
                                >Não tem uma
                                    conta ainda? <span class="text-secondary"> Cadastrar-se </span></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    <!-- Modal de Cadastro -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #fff; border-radius: 10px;">
            <div class="modal-header">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Logo_of_Twitter.svg"
                style="width:30px; height:30px; margin:auto;"
                alt="">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form
                action="signup.php" 
                method="post"
                >
                    <div class="mb-4">
                        <input type="text" id="cadastroName" name="name" class="form-control" placeholder="Nome" required/>
                    </div>

                    <div class="mb-4">
                        <input type="text" id="username" class="form-control" name="username" placeholder="Username" required/>
                    </div>

                    <!-- Email input -->
                    <div class="mb-4">
                        <input type="email" id="cadastroEmail" class="form-control" name="email" placeholder="Email" required/>
                    </div>

                    <!-- Password input -->
                    <div class="mb-4">
                        <input type="password" id="cadastroPassword" class="form-control" name="password" placeholder="Senha" required />
                    </div>

                    <!-- Submit button -->
                    <button 
                    type="submit" 
                    class="btn btn-info btn-rounded text-white" 
                    style="width: 90%; border-radius: 25px;"
                    name="cadastroSubmit"
                    >
                        Criar conta
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</html>

<?php
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']); 
}
?>