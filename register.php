<?php
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Afficher les messages de succès ou d'erreur
if (isset($_SESSION['registration_success'])) {
    echo "<p style='color: green;'>" . $_SESSION['registration_success'] . "</p>";
    unset($_SESSION['registration_success']);
}

if (isset($_SESSION['registration_error'])) {
    echo "<p style='color: red;'>" . $_SESSION['registration_error'] . "</p>";
    unset($_SESSION['registration_error']);
}

// Afficher le formulaire d'inscription
echo '
<form action="register.php" method="POST" class="form-container">
    <label for="email">Adresse Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="mdp">Mot de Passe:</label>
    <input type="password" id="mdp" name="mdp" required><br><br>

    <label for="role">Type:</label>
    <select name="role" id="role" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit" name="register">Valider</button>
</form>
';

// Traiter les données POST lors de la soumission
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Hachage sécurisé
    $role = $_POST['role'];

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'bddtp1');

    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Vérifier si l'email existe déjà
    $sql = "SELECT * FROM user WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['registration_error'] = "L'email existe déjà. Veuillez en choisir un autre.";
        header("Location: register.php");
        exit();
    }

    // Insérer un nouvel utilisateur
    $sql = "INSERT INTO user (email, mdp, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $mdp, $role);

    if ($stmt->execute()) {
        $_SESSION['registration_success'] = "Inscription réussie !";
    
        // Connecte automatiquement l'utilisateur après inscription
        $_SESSION['user_id'] = $conn->insert_id; // ID de l'utilisateur nouvellement créé
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
    
        // Redirection selon le rôle
        if ($role == 'admin') {
            header("Location: index.php");
        } else {
            header("Location: bultain.php");
        }
        exit();
    }
    
    $stmt->close();
    $conn->close();
}
?>
<style>
/* Style for the form container */
.form-container {
    width: 400px;  /* Set the width of the form */
    margin: 0 auto;
    padding: 30px;
    background-color: #f4f4f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

/* Style for form labels */
.form-container label {
    display: block;
    margin-bottom: 12px;
    font-weight: bold;
    font-size: 18px;
    color: #333;
}

/* Style for input fields */
.form-container input[type="email"],
.form-container input[type="password"],
.form-container select {
    width: 100%;
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    color: #555;
}

/* Style for buttons */
.form-container button {
    width: 100%;
    padding: 15px;
    background-color: rgba(70, 130, 180, 0.3);
    border: none;
    border-radius: 5px;
    color: black;
    font-size: 18px;
    cursor: pointer;
    margin-bottom: 15px;
}

/* Hover effect for buttons */
.form-container button:hover {
    background-color: rgba(70, 130, 180, 0.5);
}

/* Success message style */
.success-msg {
    color: green;
    font-size: 18px;
    text-align: center;
}

/* Error message style */
.error-msg {
    color: red;
    font-size: 18px;
    text-align: center;
}

/* Style for the "Inscription" link */
.form-container a {
    text-decoration: none;
    display: block;
    text-align: center;
    font-size: 16px;
    color: rgba(70, 130, 180, 0.3);
    margin-top: 15px;
}

/* Hover effect for "Inscription" link */
.form-container a:hover {
    color: rgba(70, 130, 180, 0.3);
}
</style>