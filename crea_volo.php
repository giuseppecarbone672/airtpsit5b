<?php
$origine = $_POST["origine"] ?? "";
$destinazione = $_POST["destinazione"] ?? "";
$data = $_POST["data"] ?? "";
$prezzo = $_POST["prezzo"] ?? "";

if ($origine === "" || $destinazione === "" || $data === "" || $prezzo === "") {
    echo "Compila tutti i campi.<br><a href='crea_volo.html'>Torna al form</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Volo Creato</title>
</head>
<body>
  <h1>Volo creato con successo</h1>
  <p><strong>Origine:</strong> <?= htmlspecialchars($origine) ?></p>
  <p><strong>Destinazione:</strong> <?= htmlspecialchars($destinazione) ?></p>
  <p><strong>Data:</strong> <?= htmlspecialchars($data) ?></p>
  <p><strong>Prezzo:</strong> <?= htmlspecialchars($prezzo) ?> €</p>
  <a href="crea_volo.html">Crea un altro volo</a>
</body>
</html>
