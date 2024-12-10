<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Résultat du Formulaire</title>
</head>
<body>
    <h1>Résultat du Formulaire</h1>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<p>Numéro: " . htmlspecialchars($_POST["numero"]) . "</p>";
        echo "<p>Civilité: " . htmlspecialchars($_POST["civilite"]) . "</p>";
        echo "<p>Pays: " . htmlspecialchars($_POST["pays"]) . "</p>";
        echo "<p>Nom: " . htmlspecialchars($_POST["nom"]) . "</p>";
        echo "<p>Prénom: " . htmlspecialchars($_POST["prenom"]) . "</p>";
        echo "<p>Adresse: " . htmlspecialchars($_POST["adresse"]) . "</p>";
        echo "<p>Code Postal: " . htmlspecialchars($_POST["postal1"]) . "</p>";
        echo "<p>Localité: " . htmlspecialchars($_POST["postal2"]) . "</p>";
        
        if (isset($_POST["plateform"])) {
            echo "<p>Plateforme(s): " . implode(", ", array_map('htmlspecialchars', $_POST["plateform"])) . "</p>";
        }
        
        // Gestion de l'application
        if (isset($_POST["application"])) {
            if (is_array($_POST["application"])) {
                echo "<p>Application(s): " . implode(", ", array_map('htmlspecialchars', $_POST["application"])) . "</p>";
            } else {
                echo "<p>Application: " . htmlspecialchars($_POST["application"]) . "</p>";
            }
        }

        // Gestion de la nationalité
        if (isset($_POST["nationalite"])) {
            if (is_array($_POST["nationalite"])) {
                echo "<p>Nationalité(s): " . implode(", ", array_map('htmlspecialchars', $_POST["nationalite"])) . "</p>";
            } else {
                echo "<p>Nationalité: " . htmlspecialchars($_POST["nationalite"]) . "</p>";
            }
        }

        // Gestion de la filière
        if (isset($_POST["filiere"])) {
            if (is_array($_POST["filiere"])) {
                echo "<p>Filiere(s): " . implode(", ", array_map('htmlspecialchars', $_POST["filiere"])) . "</p>";
            } else {
                echo "<p>Filiere: " . htmlspecialchars($_POST["filiere"]) . "</p>";
            }
        }
        
        // Gestion des loisirs
        if (isset($_POST["loisir"])) {
            if (is_array($_POST["loisir"])) {
                echo "<p>Loisir(s): " . implode(", ", array_map('htmlspecialchars', $_POST["loisir"])) . "</p>";
            } else {
                echo "<p>Loisir: " . htmlspecialchars($_POST["loisir"]) . "</p>";
            }
        }
    } else {
        echo "<p>Aucune donnée soumise.</p>";
    }
    ?>             

    <p><a href="ens.php">Retour au formulaire</a></p>
</body>
</html>
