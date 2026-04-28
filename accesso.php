<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso - Airtpsit5bi</title>
    <link rel="stylesheet" href="./css/accesso.css">
</head>
<body style="background: url('img/sfondo.png') no-repeat center center fixed; background-size: cover;">

<div class="overlay"></div>

<div class="login-container">
    <img src="img/logo.png" alt="Logo Air-TPSIT" class="logo">
    <h1>AREA RISERVATA</h1>

    <form action="controllo.php" method="POST">
        <div class="form-group">
            <label>Utente</label>
            <input type="text" name="utente" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="pass" required>
        </div>

        <input type="submit" value="Accedi" class="btn">
    </form>

    <div class="navigation-links">
        <a href="registra.php" class="register-btn">Registrati</a>
        <a href="index.php" class="home-link">Torna alla Homepage</a>
    </div>
</div>

</body>
</html>