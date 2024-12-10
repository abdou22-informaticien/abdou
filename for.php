<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi Bulletin</title>
</head>
<body>
    <h2>Envoyer votre bulletin par email</h2>
    <form action="send_bulletin.php" method="POST">
        <label for="Numero">Numéro étudiant:</label>
        <input type="text" id="Numero" name="Numero" required>
        <br><br>
        <label for="email">Email de l'étudiant:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <button type="submit">Envoyer le bulletin</button>
    </form>
</body>
</html>
