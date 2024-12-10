<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login et Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container input,
        .container select,
        .container button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .container button {
            background-color: #0366d6;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .container button:hover {
            background-color: #0056b3;
        }

        .container a {
            color: #0366d6;
            text-decoration: none;
        }

        .container a:hover {
            text-decoration: underline;
        }

        .message {
            color: green;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<?php
session_start();

// Check if there's a success message from the login process
if (isset($_SESSION['login_success'])) {
    echo "<p style='color: green;'>" . $_SESSION['login_success'] . "</p>";
    unset($_SESSION['login_success']);
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];  // Entered password

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'bddtp1');  // Replace with your DB details

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to check if email exists
    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Check if password matches the one stored in the database
        if (password_verify($mdp, $row['mdp'])) {
            // Login successful: Store user info in session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            // Set success message in session
          

            // Redirect based on role after successful login
            if ($row['role'] == 'Admin') {
                header("Location: index.php.php");
                exit();
            } else {
                header("Location: bultain.php");
                exit();
            }
        } else {
            echo "Mot de passe incorrect!";
        }
    } else {
        // User not found, show the message and the registration form
       
        echo "<a href='register.php'>User Inexistant. Inscrivez vous </a>";
    }

    $conn->close();
}

// Check if action is to display the registration form
if (isset($_GET['action']) && $_GET['action'] == 'inscription') {
    echo '
    <form action="login.php?action=inscription" method="POST">
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
    </form>';
}

// Process the registration form submission
if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);  // Hash the password
    $role = $_POST['role'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'bddtp1');  // Replace with your DB details

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the new user into the user table
    $sql = "INSERT INTO user (email, mdp, role) VALUES ('$email', '$mdp', '$role')";
    if ($conn->query($sql) === TRUE) {
        // Redirect based on the selected role
        if ($role == 'admin') {
            header("Location: index.php");
        } else {
            header("Location: bultain.php"); // Replace with a suitable user dashboard or homepage
        }
        exit();
    } else {
        echo "Erreur lors de l'inscription: " . $conn->error;
    }

    $conn->close();
}
?>