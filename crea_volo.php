<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: crea_volo.html");
    exit;
}
mysqli_report(MYSQLI_REPORT_OFF);

$codice = trim($_POST["codice"] ?? "");
$dataPartenza = $_POST["data_partenza"] ?? "";
$dataArrivo = $_POST["data_arrivo"] ?? "";
$aereoId = $_POST["aereo_id"] ?? "";
$aeroportoPartenza = strtoupper(trim($_POST["aeroporto_partenza"] ?? ""));
$aeroportoArrivo = strtoupper(trim($_POST["aeroporto_arrivo"] ?? ""));
$oraPartenza = $_POST["ora_partenza"] ?? "";
$oraArrivo = $_POST["ora_arrivo"] ?? "";
$postiBusiness = $_POST["posti_business"] ?? "";
$postiEconomy = $_POST["posti_economy"] ?? "";
$postiFirst = $_POST["posti_first"] ?? "";
$postiPremium = $_POST["posti_premium"] ?? "";

$campi = [
    $codice, $dataPartenza, $dataArrivo, $aereoId, $aeroportoPartenza, $aeroportoArrivo,
    $oraPartenza, $oraArrivo, $postiBusiness, $postiEconomy, $postiFirst, $postiPremium
];

$hasError = false;
foreach ($campi as $valore) {
    if ($valore === "") {
        $hasError = true;
        break;
    }
}

$success = false;
$dbError = "";

if (!$hasError) {
    $conn = @new mysqli("localhost", "root", "", "airtpsit");

    if ($conn->connect_error) {
        if (str_contains($conn->connect_error, "Unknown database")) {
            $dbError = "Database airtpsit non trovato. Importa prima airtpsit.sql in phpMyAdmin.";
        } else {
            $dbError = "Connessione al database fallita: " . $conn->connect_error;
        }
    } else {
        $conn->set_charset("utf8mb4");

        $sql = "INSERT INTO volo (
                    codice, data_partenza, data_arrivo, aereo_id, aeroporto_partenza, aeroporto_arrivo,
                    ora_partenza, ora_arrivo, posti_business, posti_economy, posti_first, posti_premium
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $dbError = "Preparazione query fallita: " . $conn->error;
        } else {
            $aereoId = (int) $aereoId;
            $postiBusiness = (int) $postiBusiness;
            $postiEconomy = (int) $postiEconomy;
            $postiFirst = (int) $postiFirst;
            $postiPremium = (int) $postiPremium;

            $stmt->bind_param(
                "sssissssiiii",
                $codice,
                $dataPartenza,
                $dataArrivo,
                $aereoId,
                $aeroportoPartenza,
                $aeroportoArrivo,
                $oraPartenza,
                $oraArrivo,
                $postiBusiness,
                $postiEconomy,
                $postiFirst,
                $postiPremium
            );

            if ($stmt->execute()) {
                $success = true;
            } else {
                $dbError = "Inserimento fallito: " . $stmt->error;
            }

            $stmt->close();
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Esito Creazione Volo</title>
  <link rel="stylesheet" href="./css/crea_volo.css">
</head>
<body>
  <main class="container">
    <section class="card">
      <?php if ($hasError): ?>
        <h1>Campi mancanti</h1>
        <p class="subtitle">Compila tutti i campi richiesti.</p>
      <?php elseif (!$success): ?>
        <h1>Errore durante il salvataggio</h1>
        <p class="subtitle"><?= htmlspecialchars($dbError) ?></p>
      <?php else: ?>
        <h1>Volo creato con successo</h1>
        <p class="subtitle">Record inserito nella tabella <strong>volo</strong>.</p>

        <div class="result-grid">
          <div class="result-item"><strong>Codice</strong><span><?= htmlspecialchars($codice) ?></span></div>
          <div class="result-item"><strong>Data partenza</strong><span><?= htmlspecialchars($dataPartenza) ?></span></div>
          <div class="result-item"><strong>Data arrivo</strong><span><?= htmlspecialchars($dataArrivo) ?></span></div>
          <div class="result-item"><strong>Aereo ID</strong><span><?= htmlspecialchars((string) $aereoId) ?></span></div>
          <div class="result-item"><strong>Aeroporto partenza</strong><span><?= htmlspecialchars($aeroportoPartenza) ?></span></div>
          <div class="result-item"><strong>Aeroporto arrivo</strong><span><?= htmlspecialchars($aeroportoArrivo) ?></span></div>
          <div class="result-item"><strong>Ora partenza</strong><span><?= htmlspecialchars($oraPartenza) ?></span></div>
          <div class="result-item"><strong>Ora arrivo</strong><span><?= htmlspecialchars($oraArrivo) ?></span></div>
          <div class="result-item"><strong>Posti business</strong><span><?= htmlspecialchars((string) $postiBusiness) ?></span></div>
          <div class="result-item"><strong>Posti economy</strong><span><?= htmlspecialchars((string) $postiEconomy) ?></span></div>
          <div class="result-item"><strong>Posti first</strong><span><?= htmlspecialchars((string) $postiFirst) ?></span></div>
          <div class="result-item"><strong>Posti premium</strong><span><?= htmlspecialchars((string) $postiPremium) ?></span></div>
        </div>
      <?php endif; ?>

      <a class="button-link" href="crea_volo.html">Torna al form</a>
    </section>
  </main>
</body>
</html>

