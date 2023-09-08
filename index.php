<?php
    session_start();
    
    include("connect.php");
    include("protect.php");

    if (!isset($_SESSION["login"])) {
        header("Location: ./login/");
        exit();
    }

    $allowed = true;
    $variables = array("name", "title", "description", "author", "volume", "publishing-company", "edition", "publication");

    for ($i = 0; $i < count($variables); $i++) {
        if (!isset($_POST[$variables[$i]])) {
            $allowed = false;
            break;
        }
        else if (empty($_POST[$variables[$i]])) {
            $allowed = false;
            break;
        }
    }

    if ($allowed) {
        $name = protect($_POST["name"]);
        $title = protect($_POST["title"]);
        $description = protect($_POST["description"]);
        $author = protect($_POST["author"]);
        $volume = protect($_POST["volume"]);
        $publishing_company = protect($_POST["publishing-company"]);
        $edition = protect($_POST["edition"]);
        $publication = protect($_POST["publication"]);

        $query = "INSERT INTO books(book_id, book_name, book_title, book_description, book_author, book_volume, book_publishing_company, book_edition, book_publication) VALUES (NULL, '$name', '$title', '$description', '$author', '$volume', '$publishing_company', '$edition', '$publication')";
        $status = mysqli_query($mysqli, $query);

        if ($status) {
            $_SESSION["success"] = "Dados cadastrados com sucesso!";
        }
        else {
            $_SESSION["error"] = "Ocorreu algum erro ao realizar o cadastro!";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container">
        <ul class="nav nav-tabs mt-3">
            <li class="nav-item">
                <a class="nav-link active" href="./">Cadastrar</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="./search/">Buscar</a>
            </li>

            <li class="nav-item">
                <a id="exit" class="nav-link" href="./logout/">Sair</a>
            </li>
        </ul>

        <form action="index.php" method="POST">
            <h2 class="mb-4 mt-5">Empréstimo</h2>

            <?php
                if (isset($_SESSION["success"])) {
                    echo '<p class="text-success">'.$_SESSION["success"].'</p>';
                    unset($_SESSION["success"]);
                }
                else if (isset($_SESSION["error"])) {
                    echo '<p class="text-danger">'.$_SESSION["error"].'</p>';
                    unset($_SESSION["error"]);
                }
            ?>

            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" class="form-control mt-1" required>
            </div>

            <div class="form-group mt-2">
                <label>Título</label>
                <input type="text" name="title" class="form-control mt-1" required>
            </div>

            <div class="form-group mt-2">
                <label>Descrição</label>
                <input type="text" name="description" class="form-control mt-1" required>
            </div>

            <div class="form-group mt-2">
                <label>Autor</label>
                <input type="text" name="author" class="form-control mt-1" required>
            </div>

            <div class="form-group mt-2">
                <label>Volume</label>
                <input type="number" name="volume" class="form-control mt-1" min="1" max="999" required>
            </div>

            <div class="form-group mt-2">
                <label>Editora</label>
                <input type="text" name="publishing-company" class="form-control mt-1" required>
            </div>

            <div class="form-group mt-2">
                <label>Edição</label>
                <input type="number" name="edition" class="form-control mt-1" min="1" max="999" required>
            </div>

            <div class="form-group mt-2">
                <label>Data de publicação</label>
                <input type="date" name="publication" class="form-control mt-1" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3 mb-5">Cadastrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>