<?php
// 1. Configurazione parametri database
$host = "localhost";
$user = "root";
$password = "";
$db_name = "airtpsit";

$conn = new mysqli($host, $user, $password, $db_name);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codice = $_POST['codice'];
    $nome = $_POST['nome'];
    $capitale = $_POST['capitale'];

    
    $target_dir = "immagini_compagnia/";
    
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["immagine"]["name"]);
    $target_file = $target_dir . $file_name;
    $upload_ok = true;
    $image_path = null;

    // Controllo se il file temporaneo esiste ed è un'immagine
    if(isset($_FILES["immagine"]) && $_FILES["immagine"]["tmp_name"] != "") {
        $check = getimagesize($_FILES["immagine"]["tmp_name"]);
        if($check !== false) {
            // Riga 24 corretta: ora usa $target_file che punta a immagini/
            if (move_uploaded_file($_FILES["immagine"]["tmp_name"], $target_file)) {
                $image_path = $target_file; 
            } else {
                echo "Errore: Non riesco a spostare il file in $target_file. Controlla i permessi della cartella.";
                $upload_ok = false;
            }
        } else {
            echo "Il file non è un'immagine valida.";
            $upload_ok = false;
        }
    } else {
        echo "Nessun file caricato o file troppo grande.";
        $upload_ok = false;
    }

    // 2. Inserimento nel Database
    if ($upload_ok) {
        $sql = "INSERT INTO compagnia_aerea (codice, nome, immagine, capitale_sociale) VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssd", $codice, $nome, $image_path, $capitale);

        if ($stmt->execute()) {
            echo "<h3>Compagnia '$nome' creata correttamente!</h3>";
            echo "<p>Immagine salvata in: $image_path</p>";
            echo "<a href='creacompagnia.html'>Torna al form di creazione</a>";
        } else {
            echo "Errore Database: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>