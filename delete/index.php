<?php
    session_start();
    
    include("../connect.php");
    include("../protect.php");

    if (!isset($_SESSION["login"])) {
        header("Location: ../login/");
        exit();
    }

    if (!isset($_GET["id"]) or empty($_GET["id"])) {
        exit();
    }

    $id = protect($_GET["id"]);
    $query = "DELETE FROM books WHERE book_id = '$id'";
    $status = mysqli_query($mysqli, $query);

    if (!$status) {
        exit();
    }
    
    $_SESSION["success"] = "Os dados foram excluídos com sucesso!";

    header("Location: ../search/");
    exit();
?>