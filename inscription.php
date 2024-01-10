<?php
session_start();
include "./include/sql.php";

$error = false;
$validation = false;
// Si inscription, récupération des valeurs du formulaire en variables
if (isset($_POST['inscription'])) {
    // Variables
    $login = $_POST['login'];
    $password = $_POST['password'];
    // Set cookies
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    // Set up des messsages d'erreurs
    $sql = "SELECT * FROM utilisateurs WHERE login='" . $_POST['login'] . "'";
    $sql_resultat = $sql_connexion->query($sql);
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $error = true;
        $error_message = "<span class='error'>Votre mot de passe et sa confirmation ne
        sont pas identiques !</span>";
    } elseif (strlen($_POST['password']) < 6) {
        $error = true;
        $error_message = "<span class='error'>Votre mot de passe est trop court, il doit contenir
        au moins 6 caractères</span>";
    } elseif (mysqli_num_rows($sql_resultat)) {
        $error = true;
        $error_message = "<span class='error'>Cet identifiant existe déjà, merci d'en renseigner
        un nouveau</span>";
    } else {
        // Requête SQL 
        $sql = "INSERT INTO utilisateurs (login, password)
        VALUE ('$login', '$password')";
        // Exécution de la requête
        $sql_resultat = $sql_connexion->query($sql);
        $_SESSION['validation'] = true;
        header("Location: ./connexion.php");
    }
}


//------------------------------------------------------------------
if (isset($_SESSION['connexion'])) {
    if ($_SESSION['connexion'] == true) {
        header("Location: ./profil.php");
    }
}
if (empty($_SESSION['login'])) {
    $_SESSION['login'] = "";
}
?>


<!------------------------------------------------>
<?php
include "./include/head.php";
?>
    <title>[Le Salon] Salle de réunion haut de gamme - inscription</title>
    <meta name="description" content="Inscription à la salle de réunion hat de gamme Le Salon" />
    </head>
<!------------------------------------------------>

<body>
    <?php
    include "./include/header.php";
    ?>
    <section>
        <h1>Inscription</h1>
        <?php
        // Messages d'erreure
        if ($error == true) {
            echo $error_message;
        }
        // Affichage du tableau
        if ($validation == false) {
            echo "<form method='post' action='inscription.php'>
    <input type='text' name='login' value='" . $_SESSION['login'] . "' placeholder='Identifiant' required>
    <input type='password' name='password' placeholder='Mot de passe' required>
    <input type='password' name='confirm_password' placeholder='Confirmation du mot de passe' required>
    <button class='button' type='submit' name='inscription'>Inscription</button>
</form>";
        }
        ?>
    </section>
    <?php
    include "./include/footer.php";
    ?>
</body>
</html>