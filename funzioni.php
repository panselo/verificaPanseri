<?php

function verificaAccesso($conn, $nomeutente, $password) {
    return $nomeutente === "panseri" && $password === "verifica";
}

function inserisciIscritto($conn, $corso, $membro) {
    $data = date('Y-m-d');
    $orario = date('H:i:s');
    $conn->query("INSERT INTO Iscrizioni_Corsi (id_corso, id_membro, data_iscrizione, orario_preferito)
                  VALUES ($corso, $membro, '$data', '$orario')");
}

?>