<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Formulaire de Module</title>
    <link rel="stylesheet" type="text/css" href="styl.css" />
  </head>

  <body>
    <form action="enrgMO.php" method="post">
      <br />
      <div class="menue">
        <input type="submit" value="etudiant" formaction="index.php" />
        <input type="submit" value="enseignant" formaction="ens.php" />
        <input type="submit" value="module" formaction="module.php" />
        <input
          type="submit"
          value="bulletin de notes"
          formaction="Bultain.php"
        />
        <input type="submit" value="PV" formaction="meftahi.php/" />
        <input
          type="submit"
          name="stat_button"
          value="Statistiques"
          formaction="stat.php" -->
        />
        <input
          type="submit"
          name="mo"
          value="Statistiques"
          formaction="moo.php" -->
        />
        <input
          type="submit"
          name="mo"
          value="Afficher List Users "
          formaction="Use.php" -->
        />
        <input
          type="submit"
          name="mo"
          value="Statistique_user  "
          formaction="Statuse.php" -->
        />
      </div>
      <br /><br />
      <label for="searchedId">Code Module:</label>
      <input type="text" searchedId="searchedId" name="searchedId" />
      <input
        type="submit"
        value="Rechercher"
        formaction="rechMO.php"
      /><br /><br />
      <hr />
      <label for="code_module">Code Module:</label><br />
      <input type="text" id="code_module" name="code_module" /><br /><br />

      <label for="designation">Désignation Module:</label><br />
      <input type="text" id="designation" name="designation" /><br /><br />

      <label for="coefficient">Coefficient:</label><br />
      <input type="text" id="coefficient" name="coefficient" /><br /><br />

      <label for="volume_horaire">Volume Horaire:</label><br />
      <input
        type="text"
        id="volume_horaire"
        name="volume_horaire"
      /><br /><br />
       <label for="">Option:</label>
      <label for="option"
        ><input
          type="radio"
          name="option"
          id="option"
          value="semestrielle"
        />semestrielle</label
      >
      <label for="option"
        ><input
          type="radio"
          name="option"
          id="option"
          value="annuel"
        />annuel</label
      >
      <br /> 

      <label for="filiere">Filière d'inscription:</label>
      <select id="filiere" name="filiere" >
          <option value="">Sélectionnez une filiere</option>
          <?php
          // Connexion à la base de données
          $conn = mysqli_connect('localhost', 'root', '', 'bddtp1');

          if (!$conn) {
              die('Erreur de connexion à la base de données ' . mysqli_connect_error());
          }

          // Récupérer les nationalités de la base de données
          $sql = "SELECT * FROM filiere";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . htmlspecialchars($row['filiere']) . "'>" . htmlspecialchars($row['filiere']) . "</option>";
              }
          } else {
              echo "<option value=''>Aucune filiere disponible</option>";
          }

          $conn->close();
          ?>
      </select><br><br>
      ><br /><br />
      <input type="submit" value="Enregistrer" name="enregistrer" />
      <input type="submit" value="Affichage Liste" formaction="affMO.php" />
      <input type="submit" value="Supprimer" formaction="suMO.php" />
    </form>
  </body>
</html>
