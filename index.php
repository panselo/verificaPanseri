<?php
include "connessioneDB.php";
include "funzioni.php";

session_start();

// LOGIN
if (isset($_POST['login'])) {
    if (verificaAccesso($_POST['nomeutente'], $_POST['password'])) {
        $_SESSION['loggedin'] = true;
    } else {
        echo "<p style='color: red;'>Credenziali errate!</p>";
    }
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Controlla se l'utente è loggato
if (!isset($_SESSION['loggedin'])) {
?>
    <h2>Login</h2>
    <form method="post">
        Nome utente: <input type="text" name="nomeutente" required>
        Password: <input type="password" name="password" required>
        <button type="submit" name="login">Accedi</button>
    </form>
<?php
    exit;
}

// Menu a tendina per selezionare la funzionalità
?>
<h2>Gestione Palestra</h2>
<form method="get">
    <label for="funzione">Seleziona una funzionalità:</label>
    <select name="funzione" id="funzione">
        <option value="">-- Seleziona --</option>
        <option value="inserisci_iscritto">Inserisci Iscritto</option>
        <option value="corso_piu_iscritti">Corso con più iscritti</option>
        <option value="iscritti_per_corso">Iscritti per Corso</option>
        <option value="report_corsi">Report Corsi</option>
    </select>
    <button type="submit">Seleziona</button>
</form>

<hr>

<?php
// Funzionalità selezionata
if (isset($_GET['funzione'])) {
    switch ($_GET['funzione']) {
        case 'inserisci_iscritto':
            ?>
            <h2>Inserisci Iscritto</h2>
            <form method="post">
                Corso:
                <select name="corso" required>
                    <?php
                    $corsi = $conn->query("SELECT id_corso, nome_corso FROM Corsi");
                    while ($c = $corsi->fetch_assoc()) {
                        echo "<option value='{$c['id_corso']}'>{$c['nome_corso']}</option>";
                    }
                    ?>
                </select>

                Membro:
                <select name="membro" required>
                    <?php
                    $membri = $conn->query("SELECT id_membro, nome, cognome FROM Membri");
                    while ($m = $membri->fetch_assoc()) {
                        echo "<option value='{$m['id_membro']}'>{$m['nome']} {$m['cognome']}</option>";
                    }
                    ?>
                </select>

                Orario preferito:
                <input type="time" name="orario" required>

                <button type="submit" name="addIscritto">Inserisci</button>
            </form>
            <?php
            if (isset($_POST['addIscritto'])) {
                $corso = $_POST['corso'];
                $membro = $_POST['membro'];
                $orario = $_POST['orario'];
                inserisciIscritto($conn, $corso, $membro, $orario);
            }
            break;

        case 'corso_piu_iscritti':
            ?>
            <h2>Corso con più iscritti</h2>
            <?php
            $corsi = corsoConPiuIscritti($conn);
            while ($c = $corsi->fetch_assoc()) {
                echo "{$c['nome']} {$c['cognome']} - {$c['nome_corso']} ({$c['iscritti']} iscritti)<br>";
            }
            break;

        case 'iscritti_per_corso':
            ?>
            <h2>Iscritti per Corso</h2>
            <form method="get">
                Corso:
                <select name="corso" required>
                    <?php
                    $corsi = $conn->query("SELECT id_corso, nome_corso FROM Corsi");
                    while ($c = $corsi->fetch_assoc()) {
                        echo "<option value='{$c['id_corso']}'>{$c['nome_corso']}</option>";
                    }
                    ?>
                </select>
                <input type="hidden" name="funzione" value="iscritti_per_corso">
                <button type="submit">Visualizza</button>
            </form>
            <?php
            if (isset($_GET['corso'])) {
                $iscritti = iscrittiPerCorso($conn, $_GET['corso']);
                while ($i = $iscritti->fetch_assoc()) {
                    echo "{$i['nome']} {$i['cognome']}<br>";
                }
            }
            break;
        }
}
?>

<a href="?logout">Logout</a>
