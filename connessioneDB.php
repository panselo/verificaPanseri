<?php
$conn = new mysqli("localhost", "root", "", "panseri_gym");

if ($conn->connect_error) {
    die("Errore connessione: " . $conn->connect_error);
}
?>