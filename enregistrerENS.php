<?php
// Vérifie si le formulaire a été soumis
if (isset($_POST['enregistrer'])) {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddtp1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupérer les données du formulaire avec vérification des clés
    $numero = isset($_POST['numero']) ? $_POST['numero'] : '';
    $civilite = isset($_POST['Civilite']) ? $_POST['Civilite'] : '';
    $nomPrenom = isset($_POST['nomprenom']) ? $_POST['nomprenom'] : '';
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
    $dateNaissance = isset($_POST['datenaissance']) ? $_POST['datenaissance'] : '';
    $lieuNaissance = isset($_POST['lieunaissance']) ? $_POST['lieunaissance'] : '';
    $grade = isset($_POST['grade']) ? $_POST['grade'] : '';
    $specialite = isset($_POST['specialite']) ? $_POST['specialite'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Prépare la requête d'insertion
    $sql = "INSERT INTO Enseignant (Numero, Civilite, NomPrenom, Adresse, DateNaissance, LieuNaissance, Grade, Specialite,email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Vérifie si la préparation de la requête a réussi
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Lie les paramètres à la requête
    $stmt->bind_param("issssssss", $numero, $civilite, $nomPrenom, $adresse, $dateNaissance, $lieuNaissance,$grade, $specialite,$email);

    // Exécute la requête
    if ($stmt->execute()) {
        echo "Enregistrement réussi.";
    } else {
        echo "Erreur lors de l'enregistrement : " . $stmt->error;
    }

    // Ferme la connexion à la base de données
    $stmt->close();
    $conn->close();
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
