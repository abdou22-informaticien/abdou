<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddtp1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer le numéro d'étudiant du formulaire avec vérification
$num_etudiant = isset($_POST["Numero"]) ? intval($_POST["Numero"]) : 0; // Assurez-vous que le champ s'appelle "Numero"

if ($num_etudiant > 0) { // Vérifiez que le numéro est valide
    // Rechercher l'étudiant
    $sql = "SELECT Nom, Prenom, Filiere, Civilite FROM formulaire_data WHERE numero = $num_etudiant";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row["Nom"];
        $prenom = $row["Prenom"];
        $filiere = $row["Filiere"];
        $civilite = $row["Civilite"];

        // Récupérer les notes
        $sql_note = "SELECT notes.Code_module, module.DesignationModule, notes.Coefficient, notes.Note 
                     FROM notes 
                     INNER JOIN module ON notes.Code_module = module.CodeModule
                     WHERE notes.Num_Etudiant = $num_etudiant";
        $result_note = $conn->query($sql_note);

        if ($result_note && $result_note->num_rows > 0) {
            $totalNotes = 0;
            $totalCoefficients = 0;
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Notes de l'étudiant</title>
                <style>
                    body { font-family: 'Arial', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                    .container { max-width: 800px; margin: 0 auto; padding: 20px; }
                    h1 { color: #333; text-align: center; }
                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                    th { background-color: blueviolet; color: white; }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Notes de l'étudiant</h1>
                    <form method="post" action="send_email_simple.php">
                        <input type="hidden" name="numero" value="<?php echo $num_etudiant; ?>">
                        <input type="hidden" name="nom" value="<?php echo $nom; ?>">
                        <input type="hidden" name="prenom" value="<?php echo $prenom; ?>">
                        <input type="hidden" name="filiere" value="<?php echo $filiere; ?>">
                        
                        <p><strong>Nom/Prénom :</strong> <?php echo $nom . " " . $prenom; ?></p>
                        <p><strong>Filière :</strong> <?php echo $filiere; ?></p>

                        <table>
                            <tr>
                                <th>Code Module</th>
                                <th>Nom du Module</th>
                                <th>Coefficient</th>
                                <th>Note</th>
                            </tr>
                            <?php
                            while ($row_note = $result_note->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row_note["Code_module"] . "</td>";
                                echo "<td>" . $row_note["DesignationModule"] . "</td>";
                                echo "<td>" . $row_note["Coefficient"] . "</td>";
                                echo "<td>" . ($row_note["Note"] !== null ? $row_note["Note"] : 'Note non saisie') . "</td>";
                                echo "</tr>";

                                // Calculer les moyennes
                                $totalNotes += $row_note["Note"] * $row_note["Coefficient"];
                                $totalCoefficients += $row_note["Coefficient"];
                            }
                            ?>
                        </table>
                        
                        <p><strong>Moyenne :</strong> <?php echo number_format(($totalCoefficients > 0) ? ($totalNotes / $totalCoefficients) : 0, 2); ?></p>

                        <!-- Ajouter champ email -->
                        <label for="email">Adresse Email :</label>
                        <input type="email" name="email" id="email" required placeholder="example@mail.com">
                        <br><br>

                        <!-- Bouton envoyer -->
                        <button type="submit">Envoyer Email Simple</button>
                    </form>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "Aucune note disponible pour cet étudiant.";
        }
    } else {
        echo "Étudiant inexistant.";
    }
} else {
    echo "Veuillez entrer un numéro d'étudiant valide.";
}

$conn->close();
?>
