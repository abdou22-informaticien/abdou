<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Si le bouton "Envoyer Mail (sans PHPMailer)" est cliqué
    if (isset($_POST["send_without_phpmailer"])) {
        // Envoi d'e-mail sans PHPMailer (mail() de PHP)
        $headers = "From: razanrazanr59@gmail.com\r\n";
        $headers .= "Reply-To: razanrazanr59@gmail.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo "L'e-mail a été envoyé avec succès sans PHPMailer!";
        } else {
            echo "Erreur lors de l'envoi de l'e-mail sans PHPMailer.";
        }
    }

    // Si le bouton "Envoyer Mail (avec PHPMailer)" est cliqué
    elseif (isset($_POST["send_with_phpmailer"])) {
        // Envoi d'e-mail avec PHPMailer
        $mail = new PHPMailer(true);
        
        try {
            // Paramètres du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Serveur SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'razanrazanr59@gmail.com';  // Votre e-mail
            $mail->Password = 'xlzl mdyy qpag ghdu           ';  // Mot de passe d'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataires
            $mail->setFrom('razanrazanr59@gmail.com', 'kawkaw kadour');
            $mail->addAddress($email);  // Ajouter l'adresse du destinataire

            // Contenu de l'e-mail
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags($message);  // Message en texte brut pour les clients non-HTML

            // Envoi de l'e-mail
            $mail->send();
            echo "L'e-mail a été envoyé avec succès avec PHPMailer!";
        } catch (Exception $e) {
            echo "L'e-mail n'a pas pu être envoyé avec PHPMailer. Erreur: {$mail->ErrorInfo}";
        }
    }
}
?>
