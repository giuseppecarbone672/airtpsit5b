<?php
$origine = $_POST["origine"] ?? "";
$destinazione = $_POST["destinazione"] ?? "";
$data = $_POST["data"] ?? "";
$prezzo = $_POST["prezzo"] ?? "";
$hasError = ($origine === "" || $destinazione === "" || $data === "" || $prezzo === "");

$prezzoFormattato = "";
if (!$hasError) {
    if (is_numeric($prezzo)) {
        $prezzoFormattato = number_format((float) $prezzo, 2, ",", ".") . " &euro;";
    } else {
        $prezzoFormattato = htmlspecialchars($prezzo) . " &euro;";
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Volo Creato</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="container">
    <section class="card">
      <?php if ($hasError): ?>
        <h1>Campi mancanti</h1>
        <p class="subtitle">Compila tutti i campi per creare il volo.</p>
        <a class="button-link" href="crea_volo.html">Torna al form</a>
      <?php else: ?>
        <h1>Volo creato con successo</h1>
        <p class="subtitle">Ecco il riepilogo del volo inserito.</p>

        <div class="result-grid">
          <div class="result-item">
            <strong>Origine</strong>
            <span><?= htmlspecialchars($origine) ?></span>
          </div>
          <div class="result-item">
            <strong>Destinazione</strong>
            <span><?= htmlspecialchars($destinazione) ?></span>
          </div>
          <div class="result-item">
            <strong>Data</strong>
            <span><?= htmlspecialchars($data) ?></span>
          </div>
          <div class="result-item">
            <strong>Prezzo</strong>
            <span><?= $prezzoFormattato ?></span>
          </div>
        </div>

        <a class="button-link" href="crea_volo.html">Crea un altro volo</a>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>

