<?php

function verificaAccesso($nomeutente, $password) {
    // Verifica che il nome utente sia "panseri" e la password sia "verifica"
    return $nomeutente === "panseri" && $password === "verifica";
}

function inserisciIscritto($conn, $corso, $membro) {
    $data = date('Y-m-d');
    $orario = date('H:i:s');
    $query = "INSERT INTO Iscrizioni_Corsi (id_corso, id_membro, data_iscrizione, orario_preferito)
              VALUES ($corso, $membro, '$data', '$orario')";
    if ($conn->query($query)) {
        echo "Iscritto aggiunto con successo!";
    } else {
        echo "Errore: " . $conn->error;
    }
}


?>
