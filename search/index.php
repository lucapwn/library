<?php
    session_start();

    include("../connect.php");
    include("../protect.php");

    if (!isset($_SESSION["login"])) {
        header("Location: ../login/");
        exit();
    }

    $query = "";
    $status = false;

    if (isset($_POST["option"]) && isset($_POST["search"])) {
        if (!empty($_POST["option"]) && !empty($_POST["search"])) {
            $option = protect($_POST["option"]);
            $search = protect($_POST["search"]);

            if ($option == "id") {
                $query = "SELECT * FROM books WHERE book_id = '$search'";
            }
            else if ($option == "name") {
                $query = "SELECT * FROM books WHERE UCASE(book_name) LIKE '%$search%'";
            }
            else if ($option == "title") {
                $query = "SELECT * FROM books WHERE UCASE(book_title) LIKE '%$search%'";
            }
            else if ($option == "description") {
                $query = "SELECT * FROM books WHERE UCASE(book_description) LIKE '%$search%'";
            }
            else if ($option == "author") {
                $query = "SELECT * FROM books WHERE UCASE(book_author) LIKE '%$search%'";
            }
            else if ($option == "volume") {
                $query = "SELECT * FROM books WHERE book_volume = '$search'";
            }
            else if ($option == "publishing-company") {
                $query = "SELECT * FROM books WHERE UCASE(book_publishing_company) LIKE '%$search%'";
            }
            else if ($option == "edition") {
                $query = "SELECT * FROM books WHERE book_edition = '$search'";
            }
            else if ($option == "publication") {
                $text = explode("/", $search);
                $date = $text[2]."-".$text[1]."-".$text[0];
                $query = "SELECT * FROM books WHERE book_publication = '$date'";
            }

            $status = mysqli_query($mysqli, $query);

            if ($status) {
                if (mysqli_num_rows($status) == 0) {
                    $_SESSION["error"] = "Nenhuma informação foi encontrada!";
                }
                else {
                    $_SESSION["success"] = "Consulta realizada com sucesso!";
                }
            }
            else {
                $_SESSION["error"] = "Ocorreu algum erro ao fazer a consulta!";
            }
        }
    }
    else {
        $query = "SELECT * FROM books";
        $status = mysqli_query($mysqli, $query);

        if ($status) {
            if (mysqli_num_rows($status) == 0) {
                $_SESSION["error"] = "Nenhum cadastro foi realizado!";
            }
            else {
                $_SESSION["success"] = "Consulta realizada com sucesso!";
            }
        }
        else {
            $_SESSION["error"] = "Ocorreu algum erro ao fazer a consulta!";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <ul class="nav nav-tabs mt-3">
            <li class="nav-item">
                <a class="nav-link" href="../">Cadastrar</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="../search/">Buscar</a>
            </li>

            <li class="nav-item">
                <a id="exit" class="nav-link" href="../logout/">Sair</a>
            </li>
        </ul>

        <form action="index.php" method="POST">
            <h2 class="mb-4 mt-5">Livros</h2>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <p id="search-text">Buscar por:</p>
                    </div>

                    <div class="col">
                        <select name="option" class="form-select form-select-sm" aria-label="form-select-sm example" required>
                            <option value="id" selected>ID</option>
                            <option value="name">Nome</option>
                            <option value="title">Título</option>
                            <option value="description">Descrição</option>
                            <option value="author">Autor</option>
                            <option value="volume">Volume</option>
                            <option value="publishing-company">Editora</option>
                            <option value="edition">Edição</option>
                            <option value="publication">Data de publicação</option>
                        </select>
                    </div>

                    <div class="col">
                        <input type="text" name="search" class="form-control" required>
                    </div>

                    <div class="col">
                        <button id="search" type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </div>
        </form>

        <?php
            if (isset($_SESSION["success"])) {
                echo '<p class="text-success">'.$_SESSION["success"].'</p>';
            }
            else if (isset($_SESSION["error"])) {
                echo '<p class="text-danger">'.$_SESSION["error"].'</p>';
                unset($_SESSION["error"]);
            }
        ?>

        <table class="table table-hover align-middle text-center mt-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Autor</th>
                    <th>Volume</th>
                    <th>Editora</th>
                    <th>Edição</th>
                    <th>Publicação</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($_SESSION["success"])) {
                        while ($result = mysqli_fetch_array($status)) {
                            echo "<tr>";
                            echo "<td>".$result["book_id"]."</td>";
                            echo "<td>".$result["book_name"]."</td>";
                            echo "<td>".$result["book_title"]."</td>";
                            echo "<td>".$result["book_description"]."</td>";
                            echo "<td>".$result["book_author"]."</td>";
                            echo "<td>".$result["book_volume"]."</td>";
                            echo "<td>".$result["book_publishing_company"]."</td>";
                            echo "<td>".$result["book_edition"]."</td>";

                            $text = explode("-", $result["book_publication"]);
                            $date = $text[2]."/".$text[1]."/".$text[0];

                            echo "<td>".$date."</td>";
                            echo '<td><a href="../update/?id='.$result["book_id"].'" class="table-icons text-success"><i class="far fa-edit fa-lg"></i></a></td>';
                            echo '<td><a href="../delete/?id='.$result["book_id"].'" class="table-icons text-danger"><i class="far fa-trash-alt fa-lg"></i></a></td>';
                            echo "</tr>";
                        }

                        unset($_SESSION["success"]);
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>