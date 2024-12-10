<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchedId = $_POST['searchedId'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bddtp1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupérer les données de la table "filiere"
    $sql_filiere = "SELECT filiere FROM filiere";
    $result_filiere = $conn->query($sql_filiere);
  
    $filiere = array(); // Tableau pour stocker les données de filiere
  
    if ($result_filiere->num_rows > 0) {
        while ($row_filiere = $result_filiere->fetch_assoc()) {
            $filiere[] = $row_filiere["filiere"];
        }
    } 

    // Requête SQL pour récupérer les données du module correspondant au code de module recherché
    $sql = "SELECT * FROM Module WHERE CodeModule = '$searchedId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Affichage des données
        while ($row = $result->fetch_assoc()) {
            echo "<head>
                <link rel='stylesheet' type='text/css' href='style.css'>
            </head>";
            echo "<form action='modifMO.php' method='post'>";
            echo "<label for='code_module'>Code Module:</label><br />";
            echo "<input type='text' id='code_module' name='code_module' value='" . $row['CodeModule'] . "' /><br /><br />";

            echo "<label for='designation'>Désignation Module:</label><br />";
            echo "<input type='text' id='designation' name='designation' value='" . $row['DesignationModule'] . "' /><br /><br />";

            echo "<label for='coefficient'>Coefficient:</label><br />";
            echo "<input type='text' id='coefficient' name='coefficient' value='" . $row['Coefficient'] . "' /><br /><br />";

            echo "<label for='volume_horaire'>Volume Horaire:</label><br />";
            echo "<input type='text' id='volume_horaire' name='volume_horaire' value='" . $row['VolumeHoraire'] . "' /><br /><br />";

            echo "<label for='filiere'>Filière:</label>";
            echo "<select id='filiere' name='filiere'>";
            foreach ($filiere as $filiere_option) {
                // Vérifiez la valeur dans le tableau row
                $selected = ($row['Filiere'] == $filiere_option) ? 'selected' : '';
                echo "<option value='$filiere_option' $selected>$filiere_option</option>";
            }
            echo "</select><br /><br />";

            echo "<input type='submit' value='Modifier' />";
            echo "</form>";
        }
    } else {
        echo "Aucun résultat trouvé pour ce Code Module.";
    }

    $conn->close();
}
?>
