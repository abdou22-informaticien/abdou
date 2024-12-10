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

// Sélectionner toutes les entrées de la table "filier"
$sql = "SELECT * FROM loisir";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #e9f5e9; /* Fond de page vert clair */
        margin: 0;
        padding: 0;
    }
    
    .container {
        max-width: 800px;
        margin: 20px auto; /* Ajout d'un espace supérieur */
        padding: 20px;
        background-color: white; /* Fond blanc pour le conteneur */
        border-radius: 8px; /* Coins arrondis */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Ombre légère */
    }
    
    h1 {
        color: #2c5c2c; /* Couleur verte foncée pour le titre */
        text-align: center;
    }
    
    p {
        color: #666; /* Couleur grise pour les paragraphes */
        margin-bottom: 10px;
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
        background-color: #4CAF50; /* Couleur verte pour les en-têtes */
        color: white;
    }
    
    tr:nth-child(even) {
        background-color: #f2f9f2; /* Couleur de fond des lignes paires légèrement verte */
    }
    
    tr:hover {
        background-color: #d1e7d1; /* Couleur de survol verte */
    }
    
</style>";    echo "<table>";
    echo "<tr><th>Code</th><th>loisir</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["code"] . "</td><td>" . $row["loisir"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Aucune donnée trouvée dans la table.";
}

$conn->close();
?>
