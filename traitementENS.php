<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du Formulaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        p {
            line-height: 1.5;
        }
        .result {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .back-link {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <h1>Résultat du Formulaire</h1>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<div class='result'>";
        echo "<p><strong>Numéro:</strong> " . htmlspecialchars($_POST["numero"]) . "</p>";
        echo "<p><strong>Civilité:</strong> " . htmlspecialchars($_POST["Civilite"]) . "</p>";
        echo "<p><strong>Nom et Prénom:</strong> " . htmlspecialchars($_POST["nomprenom"]) . "</p>";
        echo "<p><strong>Adresse:</strong> " . htmlspecialchars($_POST["adresse"]) . "</p>";
        echo "<p><strong>Date de Naissance:</strong> " . htmlspecialchars($_POST["datenaissance"]) . "</p>";
        echo "<p><strong>Lieu de Naissance:</strong> " . htmlspecialchars($_POST["lieunaissance"]) . "</p>";
        echo "<p><strong>Grade:</strong> " . htmlspecialchars($_POST["grade"]) . "</p>";
        echo "<p><strong>Spécialité:</strong> " . htmlspecialchars($_POST["specialite"]) . "</p>";
        echo "<p><strong>email:</strong> " . htmlspecialchars($_POST["email"]) . "</p>";


    }
    ?>

    <p><a class="back-link" href="ens.php">Retour au formulaire</a></p>
</body>
</html>
