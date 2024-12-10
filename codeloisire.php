<?php
// Afficher toutes les erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Établir la connexion à la base de données
$conn = mysqli_connect('localhost', 'root', '', 'bddtp1');

if (!$conn) {
    die('Erreur de connexion à la base de données ' . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $code = isset($_POST["codenas"]) ? $_POST["codenas"] : "";
    $loisir = isset($_POST["loisir"]) ? $_POST["loisir"] : ""; 

    // Enregistrer les données dans la base de données
    if (isset($_POST["enregistrer"])) {
        if (!empty($code) && !empty($loisir)) {
            // Vérifier si le code ou le loisir existe déjà
            $check_sql = "SELECT * FROM loisir WHERE code = ? OR loisir = ?";
            $stmt_check = $conn->prepare($check_sql);
            $stmt_check->bind_param("ss", $code, $loisir);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo "Le code ou le loisir existe déjà.";
            } else {
                // Utiliser des requêtes préparées pour éviter les injections SQL
                $stmt = $conn->prepare("INSERT INTO loisir (code, loisir) VALUES (?, ?)");
                $stmt->bind_param("ss", $code, $loisir);

                if ($stmt->execute()) {
                    echo "Enregistrement réussi.";
                } else {
                    echo "Erreur : " . $stmt->error;
                }

                $stmt->close();
            }

            $stmt_check->close();
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    }

    // Afficher la liste des loisirs
    if (isset($_POST["afficherliste"])) {
        $sql_select = "SELECT * FROM loisir";
        $result_select = $conn->query($sql_select);

        // Style CSS
        echo "<style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #e9f5e9; /* Fond de page vert clair */
                margin: 0;
                padding: 20px;
            }
            h2 {
                color: #2c5c2c; /* Couleur verte foncée pour le titre */
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 12px;
                text-align: left;
            }
            th {
                background-color: #4CAF50; /* Couleur verte pour l'en-tête */
                color: white;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2; /* Fond gris clair pour les lignes paires */
            }
            tr:hover {
                background-color: #ddd; /* Fond gris au survol */
            }
        </style>";

        if ($result_select->num_rows > 0) {
            echo "<h2>Liste des loisirs :</h2>";
            echo "<table>";
            echo "<tr><th>Code</th><th>Loisir</th></tr>";
            while ($row = $result_select->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["code"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["loisir"]) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun résultat trouvé.";
        }
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
