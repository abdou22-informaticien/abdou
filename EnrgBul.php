<?php
// Connexion à la base de données (assurez-vous d'avoir défini les informations de connexion correctes)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddtp1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et échapper les données du formulaire
    $num_etudiant = (int) $_POST["Numero"];
    $civilite = $conn->real_escape_string($_POST["Civilite"]);
    $nom_prenom = $conn->real_escape_string($_POST["NomPrenom"]);
    $filiere = $conn->real_escape_string($_POST["Filiere"]);
    $module = $conn->real_escape_string($_POST["Module"]);
    $code_module = $conn->real_escape_string($_POST["CodModule"]);
    $coefficient = (float) $_POST["Cof"];
    $note = (float) $_POST["Note"];

    // Insérer les données dans la table "Notes"
    $insert_sql = "INSERT INTO Notes (Num_Etudiant, Filiere, Nom_module, Code_module, Coefficient, Note)
                  VALUES ($num_etudiant, '$filiere', '$module', '$code_module', $coefficient, $note)";

    if ($conn->query($insert_sql) === TRUE) {
        echo "Enregistrement réussi.";
    } else {
        echo "Erreur lors de l'enregistrement : " . $conn->error;
    }
}

$conn->close();
?>
