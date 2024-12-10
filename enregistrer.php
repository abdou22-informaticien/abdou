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

    // Récupérer les données du formulaire avec vérification
    $numero = isset($_POST['numero']) ? $_POST['numero'] : '';
    $civilite = isset($_POST['civilite']) ? $_POST['civilite'] : '';
    $pays = isset($_POST['pays']) ? $_POST['pays'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
    $postal1 = isset($_POST['postal1']) ? $_POST['postal1'] : '';
    $postal2 = isset($_POST['postal2']) ? $_POST['postal2'] : '';
    $plateform = isset($_POST['plateform']) ? implode(", ", $_POST['plateform']) : '';
    $application = isset($_POST['application']) ? $_POST['application'] : '';
    $nationalite = isset($_POST['nationalite']) ? $_POST['nationalite'] : '';
    $filiere = isset($_POST['filiere']) ? $_POST['filiere'] : '';
    $loisir = isset($_POST['loisir']) ? $_POST['loisir'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Vérifier que les champs obligatoires ne sont pas vides
    if (empty($numero) || empty($civilite) || empty($pays) || empty($nom) || empty($prenom) || empty($nationalite) || empty($filiere) || empty($email)) {
        die("Veuillez remplir tous les champs obligatoires.");
    }

    // Prépare la requête d'insertion
    $sql = "INSERT INTO formulaire_data (numero, civilite, pays, nom, prenom, adresse, postal1, postal2, plateform, application, nationalite, filiere, loisir, email) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Vérifie si la préparation de la requête a réussi
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Lie les paramètres à la requête
    $stmt->bind_param("ssssssssssssss", $numero, $civilite, $pays, $nom, $prenom, $adresse, $postal1, $postal2, $plateform, $application, $nationalite, $filiere, $loisir, $email);

    // Exécute la requête
    if ($stmt->execute()) {
        echo "Enregistrement réussi.";
    } else {
        echo "Erreur lors de l'enregistrement : " . $stmt->error;
    }

    // Ferme la connexion à la base de données
    $conn->close();
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
