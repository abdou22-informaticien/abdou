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

// Récupérer les informations des étudiants et leurs notes
$sql_notes = "SELECT formulaire_data.numero AS Num_Etudiant, 
                     formulaire_data.Nom, 
                     formulaire_data.Prenom, 
                     notes.Coefficient, 
                     notes.Note,
                     formulaire_data.filiere
              FROM notes 
              INNER JOIN formulaire_data ON notes.Num_Etudiant = formulaire_data.numero
              ORDER BY formulaire_data.numero";

$result_notes = $conn->query($sql_notes);

// Déclaration des variables pour calculer les moyennes par étudiant
$notes_par_etudiant = [];
$coefficients_par_etudiant = [];
$etudiants = [];

if ($result_notes->num_rows > 0) {
    while ($row_note = $result_notes->fetch_assoc()) {
        $num_etudiant = $row_note["Num_Etudiant"];
        $coefficient = $row_note["Coefficient"];
        $note = $row_note["Note"];
        
        // Stocker les informations uniques par étudiant
        if (!isset($etudiants[$num_etudiant])) {
            $etudiants[$num_etudiant] = [
                "Nom" => $row_note["Nom"],
                "Prenom" => $row_note["Prenom"],
                "filiere" => $row_note["filiere"]
            ];
            $notes_par_etudiant[$num_etudiant] = 0;
            $coefficients_par_etudiant[$num_etudiant] = 0;
        }

        // Calcul des notes pondérées pour chaque étudiant
        $notes_par_etudiant[$num_etudiant] += $note * $coefficient;
        $coefficients_par_etudiant[$num_etudiant] += $coefficient;
    }

    // Génération du tableau HTML
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Étudiants et moyennes</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #333;
                color: #d1d1d1;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            h1 {
                color: #f1f1f1;
                text-align: center;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th, td {
                border: 1px solid #f44336;
                padding: 12px;
                text-align: left;
            }

            th {
                background-color: #555;
                color: white;
            }

            tr:nth-child(even) {
                background-color: #444;
            }

            tr:hover {
                background-color: #666;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Étudiants et moyennes</h1>
            <table>
                <tr>
                    <th>Numéro d'étudiant</th>
                    <th>Nom/Prénom</th>
                    <th>Filière</th>
                    <th>Moyenne</th>
                    <th>Statut</th>
                </tr>
                <?php
                foreach ($etudiants as $num_etudiant => $info) {
                    // Calcul de la moyenne pour chaque étudiant
                    $moyenne = ($coefficients_par_etudiant[$num_etudiant] > 0) 
                               ? ($notes_par_etudiant[$num_etudiant] / $coefficients_par_etudiant[$num_etudiant]) 
                               : 0;

                    // Déterminer le statut de l'étudiant
                    $statut = ($moyenne >= 10) ? "Étudiant admis" : "Étudiant ajourné";

                    echo "<tr>";
                    echo "<td>" . $num_etudiant . "</td>";
                    echo "<td>" . $info["Nom"] . ' ' . $info["Prenom"] . "</td>";
                    echo "<td>" . $info["filiere"] . "</td>";
                    echo "<td>" . number_format($moyenne, 2) . "</td>";
                    echo "<td>" . $statut . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <button type="button" class="print-button" onclick="window.print();">Imprimer</button>
    </body>
    </html>
    <?php
} else {
    echo "Aucune note disponible pour les étudiants.";
}

$conn->close();
?>
