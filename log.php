
<style>
/* Style for the form container */
form {
    width: 400px;  /* Increased width */
    margin: 0 auto;
    padding: 30px;  /* Increased padding */
    background-color: pink;
    border-radius: 10px;
    box-shadow: 0 4px 8px ;
    font-family: Arial, sans-serif;
}

/* Style for form labels */
form label {
    display: block;
    margin-bottom: 12px;  /* Increased margin */
    font-weight: bold;
    font-size: 18px;  /* Larger font size */
    color: #333;
}

/* Style for input fields */
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 15px;  /* Increased padding */
    margin-bottom: 20px;  /* Increased margin */
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;  /* Larger font size */
    color: #555;
}

/* Style for buttons */
form button {
    width: 100%;
    padding: 15px;  /* Increased padding */
    background-color: bleu;
    border: none;
    border-radius: 5px;
    color: black;
    font-size: 18px;  /* Larger font size */
    cursor: pointer;
    margin-bottom: 15px;  /* Increased margin */
}

/* Hover effect for buttons */
form button:hover {
    background-color:  pink;
}

/* Style for the "Inscription" link */
form a {
    text-decoration: none;
    display: block;
    text-align: center;
    font-size: 16px;  /* Larger font size */
    color:  rgba(70, 130, 180, 0.3);
    margin-top: 15px;  /* Increased margin */
}

/* Hover effect for "Inscription" link */
form a:hover {
    color:  rgba(70, 130, 180, 0.3);
}

</style>
<form action="login.php" method="POST">
    <label for="email">Adresse Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="mdp">Mot de Passe:</label>
    <input type="password" id="mdp" name="mdp" required><br><br>

    <button type="submit" name="login">Valider</button>
    <a href="register.php"><button type="button">Inscription</button></a>
</form>
