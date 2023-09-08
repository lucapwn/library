<?php
    session_start();

    $username = "admin";
    $password = "admin";

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        if (!empty($_POST["username"]) && !empty($_POST["password"])) {
            if ($_POST["username"] == $username && $_POST["password"] == $password) {
                $_SESSION["login"] = $username;
                header("Location: ../");
                exit();
            }
            else {
                $_SESSION["message"] = "O usuário ou a senha são inválidos!";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <form action="index.php" method="POST">
            <h2 class="mb-4 mt-5">Login</h2>

            <?php
                if (isset($_SESSION["message"])) {
                    echo '<p class="text-danger">'.$_SESSION["message"].'</p>';
                }
            ?>

            <div class="form-group">
                <label>Usuário</label>
                <input type="text" name="username" class="form-control mt-1" required>
            </div>

            <div class="form-group mt-1">
                <label>Senha</label>
                <input type="password" name="password" class="form-control mt-1" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Entrar</button>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>