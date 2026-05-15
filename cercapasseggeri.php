<?php
require_once __DIR__ . "/db.php";

$volo = isset($_GET["volo"]) ? trim($_GET["volo"]) : "";
$cognome = isset($_GET["cognome"]) ? trim($_GET["cognome"]) : "";
$documento = isset($_GET["documento"]) ? trim($_GET["documento"]) : "";

function h($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$sql = "
SELECT
  v.codice AS volo_codice,
  v.data_partenza,
  v.ora_partenza,
  v.data_arrivo,
  v.ora_arrivo,
  p.codice AS prenotazione_codice,
  cp.nome,
  cp.cognome,
  cp.data_nascita,
  cp.numero_documento,
  c.email AS cliente_email
FROM componente_prenotazione cp
JOIN prenotazione p ON p.id = cp.prenotazione_id
JOIN volo v ON v.codice = p.volo_codice
JOIN cliente c ON c.id = p.cliente_id
WHERE 1=1
";

$types = "";
$params = [];
if ($volo !== "") {
    $sql .= " AND v.codice = ? ";
    $types .= "s";
    $params[] = $volo;
}
if ($cognome !== "") {
    $sql .= " AND cp.cognome LIKE ? ";
    $types .= "s";
    $params[] = "%" . $cognome . "%";
}
if ($documento !== "") {
    $sql .= " AND cp.numero_documento LIKE ? ";
    $types .= "s";
    $params[] = "%" . $documento . "%";
}
$sql .= " ORDER BY v.codice, cp.cognome, cp.nome ";

$rows = [];
$stmt = $conn->prepare($sql);
if (!$stmt) { die("Errore query"); }

if ($types !== "") {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) { die("Errore esecuzione query"); }

$result = $stmt->get_result();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $result->free();
}

$stmt->close();
$conn->close();

?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Risultati passeggeri</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Risultati ricerca passeggeri</h2>

  <div class="box">
    <div><b>Filtro volo:</b> <?= h($volo !== "" ? $volo : "tutti") ?></div>
    <div><b>Filtro cognome:</b> <?= h($cognome !== "" ? $cognome : "tutti") ?></div>
    <div><b>Filtro documento:</b> <?= h($documento !== "" ? $documento : "tutti") ?></div>
    <div style="margin-top:10px;"><a href="cercapasseggeri.html">Torna alla ricerca</a></div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Volo</th>
        <th>Partenza</th>
        <th>Arrivo</th>
        <th>Prenotazione</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Data nascita</th>
        <th>Documento</th>
        <th>Email cliente</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($rows) === 0): ?>
        <tr><td colspan="9">Nessun passeggero trovato.</td></tr>
      <?php else: ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= h($r["volo_codice"]) ?></td>
            <td><?= h($r["data_partenza"]) ?> <?= h($r["ora_partenza"]) ?></td>
            <td><?= h($r["data_arrivo"]) ?> <?= h($r["ora_arrivo"]) ?></td>
            <td><?= h($r["prenotazione_codice"]) ?></td>
            <td><?= h($r["nome"]) ?></td>
            <td><?= h($r["cognome"]) ?></td>
            <td><?= h($r["data_nascita"]) ?></td>
            <td><?= h($r["numero_documento"]) ?></td>
            <td><?= h($r["cliente_email"]) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
