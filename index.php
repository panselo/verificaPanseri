<?php 
include "connessioneDB.php";
include "funzioni.php";

session_start();

// LOGIN
if (isset($_POST['login'])) {
    if (verificaAccesso($conn, $_POST['nomeutente'], $_POST['password'])) {
        $_SESSION['loggedin'] = true;
    } else {
        echo "Credenziali errate!";
    }
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

?>