<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione - AirTPSIT-5Bi</title>
    <link rel="stylesheet" href="./css_registra/registra.css">
</head>

<body>
     
<div class="container">

<form action="registra.php" method="POST" class="form-box">
        
<div class="logo">
    <img src="img_registra/logo.png" alt="Logo CRI">
</div>

<p class="alert">Tutti i campi sono obbligatori*</p>

<label>Username</label>
<input type="text" name="username" maxlength="50" required>

<label>Nome</label>
<input type="text" name="nome" maxlength="50" required>

<label>Cognome</label>
<input type="text" name="cognome" maxlength="50" required>

<label class="password-label">Password</label>
<input type="password" name="pass" maxlength="50" required>

<label>Codice Fiscale</label>
<input type="text" name="codice_fiscale" maxlength="16" required>

<label>Data di nascita</label>
<input type="date" name="data" required>

<label>Email</label>
<input type="email" name="email" maxlength="50" required>

<label>Telefono</label>
<input type="text" name="telefono" maxlength="13" required>

<label>Ruolo</label>
<select name="ruolo_id" required>
<option value="3">USER</option>
<option value="2">ADMIN</option>
<option value="1">SUPERADMIN</option>
</select>

<div class="buttons">
<input type="reset" value="Reset" class="btn reset">
<input type="submit" value="Invia" name="submit" class="btn submit">
</div>

</form>

</div>

<?php

if(isset($_POST['submit'])){

if($_POST['username']!=NULL && $_POST['nome']!=NULL && $_POST['cognome']!=NULL && $_POST['pass']!=NULL && $_POST['codice_fiscale']!=NULL &&
   $_POST['data']!=NULL && $_POST['telefono']!=NULL && $_POST['email']!=NULL && $_POST['ruolo_id']!=NULL){

$db=mysqli_connect("localhost","root","","airtpsit")
or die ("impossibile connettersi al database".mysqli_connect_error());

$utente=$_POST['utente'];
$nome=$_POST['nome'];
$cognome=$_POST['cognome'];
$pass=$_POST['pass'];
$codice_fiscale=$_POST['codice_fiscale'];
$data=$_POST['data'];
$telefono=$_POST['telefono'];
$email=$_POST['email'];
$ruolo_id=$_POST['ruolo_id'];

$comando = "INSERT INTO utente
(utente, nome, cognome, password, codice_fiscale, data_nascita, email, telefono, ruolo_id) 
VALUES ('$username', '$nome', '$cognome', '$pass', '$codice_fiscale', '$data', '$email', '$telefono', '$ruolo_id')";

if(mysqli_query($db,$comando)){

echo "<form action='accesso.html' method='get' class='form-box'>
<p class='msg-success'>✔ Registrazione completata!</p>

<div class='buttons'>
<input type='submit' value='Vai a Login' class='btn submit' style='display:block; margin:0 auto;'>
</div>
</form>";

}

else{
echo "<p style='text-align:center;color:red;'>Errore: ".mysqli_error($db)."</p>";
}

mysqli_close($db);

}
else{
echo "<p style='text-align:center;color:red;'>Compila tutti i campi</p>";
}

}
?>

<br><a href="homepage.html">Torna alla Homepage</a>

</body>
</html>