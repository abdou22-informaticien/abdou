<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $num_etudiant = $_POST['numero'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $filiere = $_POST['filiere'];
    $email = $_POST['email'];

    // Récupérer les notes depuis la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddtp1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $sql_note = "SELECT notes.Code_module, module.DesignationModule, notes.Coefficient, notes.Note 
                 FROM notes 
                 INNER JOIN module ON notes.Code_module = module.CodeModule
                 WHERE notes.Num_Etudiant = $num_etudiant";
    $result_note = $conn->query($sql_note);

    if ($result_note && $result_note->num_rows > 0) {
        $totalNotes = 0;
        $totalCoefficients = 0;
        
        // Créer le contenu du mail
        $message = "<h2>Bulletin de Notes de l'Étudiant</h2>";
        $message .= "<p><strong>Nom/Prénom :</strong> $nom $prenom</p>";
        $message .= "<p><strong>Filière :</strong> $filiere</p>";
        $message .= "<table border='1'>
                        <tr><th>Code Module</th><th>Nom du Module</th><th>Coefficient</th><th>Note</th></tr>";
        
        while ($row_note = $result_note->fetch_assoc()) {
            $message .= "<tr>
                            <td>" . $row_note["Code_module"] . "</td>
                            <td>" . $row_note["DesignationModule"] . "</td>
                            <td>" . $row_note["Coefficient"] . "</td>
                            <td>" . ($row_note["Note"] !== null ? $row_note["Note"] : 'Note non saisie') . "</td>
                          </tr>";
            
            $totalNotes += $row_note["Note"] * $row_note["Coefficient"];
            $totalCoefficients += $row_note["Coefficient"];
        }

        $moyenne = ($totalCoefficients > 0) ? ($totalNotes / $totalCoefficients) : 0;
        $message .= "</table>";
        $message .= "<p><strong>Moyenne :</strong> " . number_format($moyenne, 2) . "</p>";

        // Configuration de PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // Paramètres de SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'razanrazanr59@gmail.com'; // Remplacez par votre email
            $mail->Password = 'xlzl mdyy qpag ghdu'; // Remplacez par votre mot de passe
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Destinataire
            $mail->setFrom('razanrazanr59@gmail.com', 'Département Informatique');
            $mail->addAddress($email); // Email de l'étudiant
            
            // Contenu de l'email
            $mail->isHTML(true);
            $mail->Subject = "Bulletin de Notes de l'Étudiant";
            $mail->Body = $message;

            // Envoi de l'email
            $mail->send();
            echo "Le bulletin a été envoyé avec succès à $email";
        } catch (Exception $e) {
            echo "L'email n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
        }
    } else {
        echo "Aucune note disponible pour cet étudiant.";
    }

    $conn->close();
}
?>
