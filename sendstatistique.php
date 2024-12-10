<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Simulate student data (or fetch from database)
$maleStudentsCount = 30;
$femaleStudentsCount = 20;

$totalStudents = $maleStudentsCount + $femaleStudentsCount;
$malePercentage = ($maleStudentsCount / $totalStudents) * 100;
$femalePercentage = ($femaleStudentsCount / $totalStudents) * 100;

// Generate the chart (make sure the chart is generated before sending the email)
exec('node generateChart.js', $output, $returnCode);

if ($returnCode !== 0) {
    die("Erreur lors de la génération du graphique.");
}

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'razanrazanr59@gmail.com'; // Your email
    $mail->Password = 'xlzl mdyy qpag ghdu'; // Your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender and Recipient
    $mail->setFrom('razanrazanr59@gmail.com', 'Statistiques Étudiants');
    $mail->addAddress('recipient-email@example.com'); // Replace with recipient email

    // Email Content
    $mail->isHTML(true);
    $mail->Subject = 'Statistiques Étudiants';
    $mail->Body = "
        <h1>Statistiques des Étudiants</h1>
        <p><strong>Nombre total d'étudiants :</strong> $totalStudents</p>
        <p><strong>Masculin :</strong> $maleStudentsCount ($malePercentage%)</p>
        <p><strong>Féminin :</strong> $femaleStudentsCount ($femalePercentage%)</p>
        <p>Veuillez trouver le graphique ci-joint.</p>
    ";

    // Attach the chart image
    $mail->addAttachment('chart.png', 'Statistiques.png');

    // Send the email
    $mail->send();
    echo "Email envoyé avec succès.";
} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
}
?>
