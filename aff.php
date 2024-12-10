<?php
session_start();
// Connexion à la base de données (assurez-vous d'avoir défini les informations de connexion correctes)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddtp1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Sélectionner toutes les entrées de la table "formulaire_data"
$sql = "SELECT * FROM formulaire_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f0f4f8;
        margin: 0;
        padding: 0;
    }
    
    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px;
        background-color: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    
    h1 {
        color: #343a40;
        text-align: center;
        font-size: 2.5em;
        margin-bottom: 20px;
    }
    
    p {
        color: #6c757d;
        margin-bottom: 15px;
        line-height: 1.6;
    }
    
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px; /* Espacement entre les lignes */
        margin-top: 20px;
    }
    
    th, td {
        padding: 15px;
        text-align: left;
        border-radius: 5px; /* Coins arrondis */
    }
    
    th {
        background-color: #4caf50; /* Vert */
        color: white;
        font-size: 1.1em;
    }
    
    tr {
        background-color: #ffffff; /* Blanc */
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
    
    /* Effets d'ombre pour les cellules */
    td:first-child, th {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
</style>";
    echo "<table>";
    echo "<tr><th>Numéro</th><th>Civilité</th><th>Pays</th><th>Nom</th><th>Prénom</th><th>Adresse</th><th>Postal 1</th><th>Postal 2</th><th>Plateforme</th><th>Application</th><th>Nationalité</th><th>Filière</th><th>Loisir</th><th>email</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["numero"] . "</td>";
        echo "<td>" . $row["civilite"] . "</td>";
        echo "<td>" . $row["pays"] . "</td>";
        echo "<td>" . $row["nom"] . "</td>";
        echo "<td>" . $row["prenom"] . "</td>";
        echo "<td>" . $row["adresse"] . "</td>";
        echo "<td>" . $row["postal1"] . "</td>";
        echo "<td>" . $row["postal2"] . "</td>";
        echo "<td>" . $row["plateform"] . "</td>";
        echo "<td>" . $row["application"] . "</td>";
        echo "<td>" . $row["nationalite"] . "</td>";
        echo "<td>" . $row["filiere"] . "</td>";
        echo "<td>" . $row["loisir"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";


        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucune donnée trouvée dans la table.";
}

$conn->close();
?>
