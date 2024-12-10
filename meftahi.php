<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddtp1";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération de la filière sélectionnée
    $filiereSelected = isset($_POST['filiere']) ? $_POST['filiere'] : '';

    // Requête SQL pour récupérer les moyennes des étudiants
    $query = "
    SELECT n.Num_Etudiant, e.nom, e.prenom,
           SUM(n.Note * n.Coefficient) / SUM(n.Coefficient) AS Moyenne_Ponderee
    FROM notes n
    INNER JOIN formulaire_data e ON n.Num_Etudiant = e.numero
    INNER JOIN filiere f ON e.filiere = f.filiere
    ";

    if (!empty($filiereSelected)) {
        $query .= " WHERE f.filiere = :filiere";
    }

    $query .= " GROUP BY n.Num_Etudiant";
    $stmt = $conn->prepare($query);

    if (!empty($filiereSelected)) {
        $stmt->bindParam(':filiere', $filiereSelected, PDO::PARAM_STR);
    }

    $stmt->execute();
    $studentAverages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Envoi de l'email si le bouton est cliqué
    if (isset($_POST['send_email'])) {
        if (!empty($studentAverages)) {
            // Génération de la table HTML
            $htmlTable = "<h2>Bulletin des Étudiants</h2>";
            $htmlTable .= "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>
                            <thead>
                                <tr style='background-color: #0366d6; color: white;'>
                                    <th>Numéro Étudiant</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Moyenne Pondérée</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>";

            foreach ($studentAverages as $average) {
                $formattedAverage = number_format($average['Moyenne_Ponderee'], 2);
                $statut = $average['Moyenne_Ponderee'] >= 10 ? "Réussi" : "Échoué";

                $htmlTable .= "<tr>
                                <td>{$average['Num_Etudiant']}</td>
                                <td>{$average['nom']}</td>
                                <td>{$average['prenom']}</td>
                                <td>{$formattedAverage}</td>
                                <td>{$statut}</td>
                            </tr>";
            }

            $htmlTable .= "</tbody></table>";

            // Récupération des emails des enseignants
            $emailQuery = "SELECT email FROM enseignant";
            $emailStmt = $conn->query($emailQuery);
            $emails = $emailStmt->fetchAll(PDO::FETCH_COLUMN);

            // Configuration et envoi de l'email avec PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kawkawkadour@gmail.com'; // Remplacez par votre email
                $mail->Password = 'rtuv npxp sgcx eupj'; // Remplacez par votre mot de passe d'application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('kawkawkadour@gmail.com', 'abdelilah seffah'); // Expéditeur

                // Ajout des destinataires
                foreach ($emails as $recipient) {
                    $mail->addAddress($recipient);
                }

                $mail->isHTML(true);
                $mail->Subject = "PV des Étudiants";
                $mail->Body = $htmlTable;

                $mail->send();
                echo "<p>Le PV des étudiants a été envoyé avec succès à tous les enseignants.</p>";
            } catch (Exception $e) {
                echo "<p>Erreur lors de l'envoi : {$mail->ErrorInfo}</p>";
            }
        } else {
            echo "<p>Aucune donnée à envoyer.</p>";
        }
    }
} catch (PDOException $e) {
    echo "<p>Erreur de connexion : " . $e->getMessage() . "</p>";
}
?>

<!-- Formulaire HTML -->
<form method="post">
    <label for="filiere">Filtrer par Filière :</label>
    <select name="filiere" id="filiere">
        <option value="">-- Sélectionner une Filière --</option>
        <?php
        // Récupération des filières
        $filiereQuery = "SELECT DISTINCT filiere FROM filiere";
        $filiereStmt = $conn->query($filiereQuery);
        $filiereOptions = $filiereStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($filiereOptions as $option) {
            $selected = ($option['filiere'] == $filiereSelected) ? 'selected' : '';
            echo "<option value='" . htmlspecialchars($option['filiere']) . "' $selected>" . htmlspecialchars($option['filiere']) . "</option>";
        }
        ?>
    </select>
    <button type="submit">Filtrer</button>
    <button type="submit" name="send_email">Envoyer par Email</button>
</form>

<!-- Affichage des résultats filtrés -->
<?php
if (!empty($studentAverages)) {
    echo "<h2>Résultats filtrés</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>
            <thead>
                <tr style='background-color: #0366d6; color: white;'>
                    <th>Numéro Étudiant</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Moyenne Pondérée</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($studentAverages as $average) {
        $formattedAverage = number_format($average['Moyenne_Ponderee'], 2);
        $statut = $average['Moyenne_Ponderee'] >= 10 ? "Réussi" : "Échoué";

        echo "<tr>
                <td>{$average['Num_Etudiant']}</td>
                <td>{$average['nom']}</td>
                <td>{$average['prenom']}</td>
                <td>{$formattedAverage}</td>
                <td>{$statut}</td>
            </tr>";
    }

    echo "</tbody></table>";
}
?>
<style>
/* Styles de la table */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 18px;
    text-align: left;
    background-color: #f9f9f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1.5s ease;
}

thead tr {
    background-color: #0366d6;
    color: white;
    text-align: center;
}

table th, table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:hover {
    background-color: #e0f7fa;
    transform: scale(1.01);
    transition: transform 0.2s ease-in-out;
}

/* Styles des boutons */
button {
    background-color: #0366d6;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

button:hover {
    background-color: #024c9c;
    transform: scale(1.05);
}

/* Animation de la table */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
