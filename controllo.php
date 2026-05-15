<?php

// Avvio della sessione per poter salvare i dati dell'utente autenticato
session_start();

// Connessione al database MySQL che contiene la tabella delle credenziali degli utenti
$db=mysqli_connect("localhost","root","","airtpsit") 
or die ("impossibile connettersi al database".mysqli_connect_error());

// Query SQL che recupera tutti i record della tabella credenziali
$comando="SELECT * FROM utente";

// Esecuzione della query sul database
$comando1=mysqli_query($db,$comando);

// Recupero dei dati inseriti dall'utente nel form di login
$nome=$_POST['utente'];
$pass=$_POST['pass'];

// Variabili di controllo utilizzate per verificare se l'utente esiste e se la password è corretta
$flag=false;
$flag2=false;

// Ciclo che scorre tutti i record della tabella credenziali
while($riga1=mysqli_fetch_array($comando1)){

	// Controllo se il nome utente e la password inseriti coincidono con quelli presenti nel database
	if($nome == $riga1['utente'] && $pass == $riga1['password']){

		// Salvataggio del nome utente nella sessione
		 $_SESSION['utente'] = $nome;

		 // Salvataggio del ruolo dell'utente (utente semplice oppure amministratore)
		 $_SESSION['ruolo'] = $riga1['ruolo'];

		 // Reindirizzamento dell'utente alla pagina dell'area riservata
		 header("Location: areariservata.php");

		exit;

		 // Impostazione delle variabili di controllo
		 $flag=true;
		 $flag2=true;

		 break;

	} 

	// Controllo se il nome utente esiste ma la password è errata
	else if ($nome == $riga1['utente'] && $pass != $riga1['password']){

		echo "password sbagliata";

		$flag=true;
	}
}

// Messaggio mostrato se l'utente inserito non esiste nel database
if(!$flag){ 

	echo "<!DOCTYPE html>
	<html lang='it'>
	<head>

		<!-- Definizione della codifica dei caratteri -->
		<meta charset='UTF-8'>

		<!-- Titolo della pagina -->
		<title>Errore - CRI</title>

		<!-- Collegamento al foglio di stile CSS per la grafica della pagina di errore -->
		<link rel='stylesheet' href='./css/controllo.css'>

	</head>

	<body>

		<!-- Contenitore principale del messaggio -->
		<div class='messaggio-container'>

			<!-- Blocco che mostra l'errore di utente non trovato -->
			<div class='messaggio-errore'>

				<h2>⚠️ Utente Non Trovato</h2>

				<p>L'utente che hai inserito non esiste nel sistema.</p>

				<!-- Pulsanti che permettono all'utente di registrarsi oppure tornare al login -->
				<div class='bottoni-messaggio'>

					<a href='registra.php' class='btn-registrati'>Registrati Ora</a>

					<a href='accesso.html' class='btn-indietro'>Torna al Login</a>

				</div>

			</div>

		</div>

	</body>
	</html>";
}

// Messaggio opzionale che permette all'utente di cambiare la password
if($flag2){

	echo "<br>se desideri cambiare password, cliccare <a href='accesso.html?utente=$nome'>qui</a>";

}

// Chiusura della connessione al database
mysqli_close($db);

?>