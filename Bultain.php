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

// Sélectionner les codes de la table "nationalites"
$sql = "SELECT * FROM module";
$result = $conn->query($sql);

$module = array(); // Tableau pour stocker les codes de nationalité

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $module[] = $row["DesignationModule"];
  
      }
}


$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>bulletin de notes</title>
    <link rel="stylesheet" type="text/css" href="styl.css" />
  </head>
  <body>
    <br />
    <form action="RechBultain.php" method="post">
      <input type="submit" value="etudiant" formaction="index.php" />
      <input type="submit" value="enseignant" formaction="ens.php" />
      <input type="submit" value="module" formaction="module.php" />
      <input type="submit" value="bulletin de notes" formaction="Bultain.php" />
      <input type="submit" value="PV" formaction="meftahi.php/" />
      <input type="submit" value="Statistiques" formaction="stat.php" />
      <input type="submit" name="mo" value="Afficher List Users " formaction="Use.php" />
      <input
        type="submit"
        name="mo"
        value="Statistique_user  "
        formaction="Statuse.php" 
      />
      <br /><br />
    <!---->
      <label for="Number">Numero : </label>
      <input type="text" id="Number" name="Number" />
      <!---->
      <input type="submit" value="Rechercher" formaction="RechBultain.php" />
          </form>
  </body>
</html>
