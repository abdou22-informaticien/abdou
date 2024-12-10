<?php
// Connexion à la base de données (assurez-vous d'avoir défini les informations de connexion correctes)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddtp1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Sélectionner toutes les entrées de la table "Enseignant"
$sql = "SELECT * FROM Enseignant";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    
    h1 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }
    
    p {
        color: #666;
        margin-bottom: 10px;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    th, td {
        padding: 15px;
        text-align: left;
        border-radius: 8px; /* Coins arrondis */
    }
    
    th {
        background-color: #4caf50; /* Vert */
        color: white;
        font-weight: bold;
    }
    
    tr {
        background-color: #ffffff; /* Blanc par défaut */
        transition: background-color 0.3s; /* Transition douce */
    }
    
    tr:nth-child(odd) {
        background-color: #e7f9e7; /* Vert clair pour les lignes impaires */
    }
    
    tr:hover {
        background-color: #c8e6c9; /* Vert plus clair au survol */
    }
    
    td {
        border: 1px solid #dee2e6; /* Bordure grise */
    }
    
</style>";
    echo "<table>";
    echo "<tr><th>Numero</th><th>Civilite</th><th>NomPrenom</th><th>Adresse</th><th>DateNaissance</th><th>LieuNaissance</th><th>Grade</th><th>Specialite</th><th>email</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Numero"] . "</td>";
        echo "<td>" . $row["Civilite"] . "</td>";
        echo "<td>" . $row["NomPrenom"] . "</td>";
        echo "<td>" . $row["Adresse"] . "</td>";
        echo "<td>" . $row["DateNaissance"] . "</td>";
        echo "<td>" . $row["LieuNaissance"] . "</td>";
        echo "<td>" . $row["Grade"] . "</td>";
        echo "<td>" . $row["Specialite"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucune donnée trouvée dans la table.";
}

$conn->close();
?>
