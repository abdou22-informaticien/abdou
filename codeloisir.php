<?php
// Afficher toutes les erreurs pour التحقق من وجود مشاكل
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
            // Vérifier si le code ou la loisir existe déjà
            $check_sql = "SELECT * FROM loisir WHERE code = ? OR loisir = ?";
            $stmt_check = $conn->prepare($check_sql);
            $stmt_check->bind_param("ss", $code, $loisir);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                echo "Le code ou la loisir déjà exist.";
            } else {
                // Utiliser des requêtes préparées pour éviter les injections SQL
                $stmt = $conn->prepare("INSERT INTO loisir (code, loisir) VALUES (?, ?)");
                $stmt->bind_param("ss", $code, $loisir);

                if ($stmt->execute()) {
                    echo "Record saved successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            }

            $stmt_check->close();
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    }

    // Afficher la liste des loisir
    if (isset($_POST["afficherliste"])) {
        $sql_select = "SELECT * FROM loisir";
        $result_select = $conn->query($sql_select);

        if ($result_select->num_rows > 0) {
            echo "<h2>Liste des loisir :</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Code</th><th>loisir</th></tr>";
            while ($row = $result_select->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["code"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["loisir"]) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No results";
        }
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
