<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddtp1";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupérer et valider les données du formulaire
    $code_module = $_POST['code_module'];
    $designation = $_POST['designation'];
    $coefficient = $_POST['coefficient'];
    $volume_horaire = $_POST['volume_horaire'];
    $filiere = $_POST['filiere'];

    // Assurez-vous que les données sont valides
    if (empty($code_module) || empty($designation) || !is_numeric($coefficient) || !is_numeric($volume_horaire) || empty($filiere)) {
        echo "Veuillez remplir tous les champs correctement.";
        $conn->close();
        exit();
    }

    // Préparer la requête SQL pour mettre à jour les données du module
    $stmt = $conn->prepare("UPDATE Module SET DesignationModule=?, Coefficient=?, VolumeHoraire=?, Filiere=? WHERE CodeModule=?");
    if ($stmt === false) {
        die("Erreur lors de la préparation de la requête : " . $conn->error);
    }

    // Lier les paramètres
    $stmt->bind_param("sdssi", $designation, $coefficient, $volume_horaire, $filiere, $code_module);

    // Exécuter la requête
    if ($stmt->execute() === TRUE) {
        echo "Les données du module ont été mises à jour avec succès";
    } else {
        echo "Erreur lors de la mise à jour des données du module : " . $stmt->error;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>
