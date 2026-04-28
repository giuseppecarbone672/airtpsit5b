<?php
$compagnia = isset($_POST['compagnia']) ? trim($_POST['compagnia']) : '';
$numeroVolo = isset($_POST['nvolo']) ? trim((string) $_POST['nvolo']) : '';
$orario = isset($_POST['orario']) ? trim($_POST['orario']) : '';
$messaggio = '';
$risultato = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($compagnia === '' || $numeroVolo === '' || $orario === '') {
        $messaggio = 'Compila tutti i campi prima di effettuare la ricerca.';
    } else {
        try {
            $pdo = new PDO(
                'mysql:host=localhost;dbname=airtpsit;charset=utf8mb4',
                'root',
                ''
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "
                SELECT
                    ca.nome AS compagnia,
                    v.codice AS codice_volo,
                    TIME_FORMAT(v.ora_partenza, '%H:%i') AS orario,
                    ap.nome AS aeroporto_partenza,
                    aa.nome AS aeroporto_arrivo,
                    g.codice_gate AS gate,
                    g.terminal
                FROM volo v
                INNER JOIN aereo a ON v.aereo_id = a.id
                INNER JOIN compagnia_aerea ca ON a.compagnia_codice = ca.codice
                INNER JOIN aeroporto ap ON v.aeroporto_partenza = ap.codice
                INNER JOIN aeroporto aa ON v.aeroporto_arrivo = aa.codice
                INNER JOIN gate g ON g.volo_codice = v.codice
                WHERE UPPER(ca.nome) = UPPER(?)
                  AND RIGHT(v.codice, CHAR_LENGTH(?)) = ?
                  AND TIME_FORMAT(v.ora_partenza, '%H:%i') = ?
                LIMIT 1
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$compagnia, $numeroVolo, $numeroVolo, $orario]);
            $risultato = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($risultato === false) {
                $messaggio = 'Nessun volo trovato con i dati inseriti.';
                $risultato = null;
            }
        } catch (PDOException $e) {
            $messaggio = 'Errore di connessione o query al database.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultato Ricerca Gate</title>
    <link rel="stylesheet" href="/css_cercagate/cercagate.css">
</head>
<body>
    <main class="page-shell">
        <section class="card">
            <p class="eyebrow">Esito Ricerca</p>
            <h1>Risultato volo</h1>
            <p class="intro">Questa pagina elabora i dati inviati dal form HTML esistente.</p>

            <?php if ($messaggio !== ''): ?>
                <div class="notice error"><?php echo htmlspecialchars($messaggio, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php endif; ?>

            <?php if ($risultato !== null): ?>
                <div class="result-box">
                    <p><strong>Compagnia:</strong> <?php echo htmlspecialchars($risultato['compagnia'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Codice volo:</strong> <?php echo htmlspecialchars($risultato['codice_volo'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Orario partenza:</strong> <?php echo htmlspecialchars($risultato['orario'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Tratta:</strong> <?php echo htmlspecialchars($risultato['aeroporto_partenza'], ENT_QUOTES, 'UTF-8'); ?> -> <?php echo htmlspecialchars($risultato['aeroporto_arrivo'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Gate:</strong> <?php echo htmlspecialchars($risultato['gate'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>Terminal:</strong> <?php echo htmlspecialchars($risultato['terminal'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            <?php endif; ?>

            <a href="cercagate.html" class="button link-button">Nuova ricerca</a>
        </section>
    </main>
</body>
</html>
