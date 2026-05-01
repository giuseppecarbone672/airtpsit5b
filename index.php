<?php
$host = 'localhost';
$dbname = 'airtpsit';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $sql = "
        SELECT
            v.codice,
            v.data_partenza,
            v.data_arrivo,
            v.ora_partenza,
            v.ora_arrivo,
            v.posti_business,
            v.posti_economy,
            v.posti_first,
            v.posti_premium,
            ap.nome AS aeroporto_partenza_nome,
            ap.codice AS aeroporto_partenza_codice,
            aa.nome AS aeroporto_arrivo_nome,
            aa.codice AS aeroporto_arrivo_codice,
            a.codice AS aereo_codice,
            c.nome AS compagnia_nome,
            g.codice_gate,
            g.terminal
        FROM volo v
        INNER JOIN aereo a ON v.aereo_id = a.id
        INNER JOIN compagnia_aerea c ON a.compagnia_codice = c.codice
        INNER JOIN aeroporto ap ON v.aeroporto_partenza = ap.codice
        INNER JOIN aeroporto aa ON v.aeroporto_arrivo = aa.codice
        LEFT JOIN gate g ON v.codice = g.volo_codice
        ORDER BY v.data_partenza, v.ora_partenza, v.codice
    ";

    $stmt = $pdo->query($sql);
    $voli = $stmt->fetchAll();
} catch (PDOException $e) {
    $errore = 'Impossibile collegarsi al database o recuperare i voli.';
    $dettaglioErrore = $e->getMessage();
    $voli = [];
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function formatDateIt($date)
{
    if (!$date) {
        return '-';
    }

    return date('d/m/Y', strtotime($date));
}

function formatTime($time)
{
    if (!$time) {
        return '-';
    }

    return substr($time, 0, 5);
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voli AirTPSIT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <div>
            <p class="eyebrow">Compagnia aerea</p>
            <h1>Voli AirTPSIT</h1>
        </div>
        <span class="badge"><?php echo count($voli); ?> voli trovati</span>
    </header>

    <main class="container">
        <?php if (isset($errore)): ?>
            <section class="message error">
                <h2><?php echo e($errore); ?></h2>
                <p>Controlla che MySQL sia avviato, che il database <strong>airtpsit</strong> esista e che le credenziali siano corrette.</p>
                <small><?php echo e($dettaglioErrore); ?></small>
            </section>
        <?php elseif (empty($voli)): ?>
            <section class="message">
                <h2>Nessun volo disponibile</h2>
                <p>Nel database non sono presenti voli da visualizzare.</p>
            </section>
        <?php else: ?>
            <section class="flight-grid" aria-label="Elenco voli">
                <?php foreach ($voli as $volo): ?>
                    <?php
                        $postiTotali = (int) $volo['posti_business']
                            + (int) $volo['posti_economy']
                            + (int) $volo['posti_first']
                            + (int) $volo['posti_premium'];
                    ?>
                    <article class="flight-card">
                        <div class="flight-card__head">
                            <div>
                                <p class="company"><?php echo e($volo['compagnia_nome']); ?></p>
                                <h2><?php echo e($volo['codice']); ?></h2>
                            </div>
                            <span class="plane"><?php echo e($volo['aereo_codice']); ?></span>
                        </div>

                        <div class="route">
                            <div>
                                <strong><?php echo e($volo['aeroporto_partenza_codice']); ?></strong>
                                <span><?php echo e($volo['aeroporto_partenza_nome']); ?></span>
                            </div>
                            <div class="route-line" aria-hidden="true"></div>
                            <div>
                                <strong><?php echo e($volo['aeroporto_arrivo_codice']); ?></strong>
                                <span><?php echo e($volo['aeroporto_arrivo_nome']); ?></span>
                            </div>
                        </div>

                        <dl class="details">
                            <div>
                                <dt>Partenza</dt>
                                <dd><?php echo formatDateIt($volo['data_partenza']); ?>, <?php echo formatTime($volo['ora_partenza']); ?></dd>
                            </div>
                            <div>
                                <dt>Arrivo</dt>
                                <dd><?php echo formatDateIt($volo['data_arrivo']); ?>, <?php echo formatTime($volo['ora_arrivo']); ?></dd>
                            </div>
                            <div>
                                <dt>Gate</dt>
                                <dd>
                                    <?php if ($volo['codice_gate']): ?>
                                        Terminal <?php echo e($volo['terminal']); ?> - Gate <?php echo e($volo['codice_gate']); ?>
                                    <?php else: ?>
                                        Da assegnare
                                    <?php endif; ?>
                                </dd>
                            </div>
                            <div>
                                <dt>Posti disponibili</dt>
                                <dd><?php echo $postiTotali; ?></dd>
                            </div>
                        </dl>

                        <div class="seat-list" aria-label="Posti per classe">
                            <span>Economy: <?php echo (int) $volo['posti_economy']; ?></span>
                            <span>Premium: <?php echo (int) $volo['posti_premium']; ?></span>
                            <span>Business: <?php echo (int) $volo['posti_business']; ?></span>
                            <span>First: <?php echo (int) $volo['posti_first']; ?></span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
