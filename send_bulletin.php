<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_etudiant = $_POST['Numero'];
    $email = $_POST['email'];

    // Exemple de données d'étudiant (ces données peuvent provenir de votre base de données)
    $nom = "Mohammed";
    $prenom = "Ali";
    $filiere = "Informatique";

    // Exemple de notes et matières
    $notes = [
        ["module" => "Mathématiques", "note" => 15, "coefficient" => 3],
        ["module" => "Programmation", "note" => 18, "coefficient" => 4],
        ["module" => "Réseaux", "note" => 14, "coefficient" => 2]
    ];

    // Calcul du total des notes et coefficients
    $totalNotes = 0;
    $totalCoefficients = 0;
    foreach ($notes as $note) {
        $totalNotes += $note['note'] * $note['coefficient'];
        $totalCoefficients += $note['coefficient'];
    }
    $moyenne = ($totalCoefficients > 0) ? ($totalNotes / $totalCoefficients) : 0;

    // Construction du message HTML du bulletin
    $subject = "Bulletin de notes de $nom $prenom";
    $message = "<h2>Bulletin de notes de l'étudiant</h2>";
    $message .= "<p><strong>Nom:</strong> $nom $prenom</p>";
    $message .= "<p><strong>Filière:</strong> $filiere</p>";
    $message .= "<table border='1' cellpadding='5' cellspacing='0'>";
    $message .= "<tr><th>Module</th><th>Note</th><th>Coefficient</th></tr>";
    
    foreach ($notes as $note) {
        $message .= "<tr><td>{$note['module']}</td><td>{$note['note']}</td><td>{$note['coefficient']}</td></tr>";
    }

    $message .= "</table>";
    $message .= "<p><strong>Moyenne:</strong> " . number_format($moyenne, 2) . "</p>";

    // Headers pour envoyer un email HTML
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: admin@gmail.com" . "\r\n";  // Remplacez par votre adresse email

    // Envoi de l'email
    if (mail($email, $subject, $message, $headers)) {
        echo "Le bulletin a été envoyé avec succès à $email.";
    } else {
        echo "Une erreur s'est produite lors de l'envoi du bulletin.";
    }
}
?>
