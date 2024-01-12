<?php
session_start();
include "./include/sql.php";
// Si connecté -> envoie sur profil
if (isset($_SESSION['connexion'])) {
    if (($_SESSION['connexion'] == true)) {
        header("Location: ./profil.php");
    }
}
// Initialisation des variables
if (empty($_SESSION['login'])) {
    $_SESSION['login'] = "";
}
if (empty($_SESSION['password'])) {
    $_SESSION['password'] = "";
}
$error = false;

//--Connexion-----------------------------------------------------------
if (isset($_POST['connexion'])) {
    // Requête SQL 
    $sql = "SELECT * FROM utilisateurs";
    // Exécution de la requête
    $sql_resultat = $sql_connexion->query($sql);
    // Connexion et attribution des session
    foreach ($sql_resultat as $utilisateur) {
        if ($utilisateur['login'] == $_POST['login'] and $utilisateur['password'] == $_POST['password']) {
            $id = $utilisateur['id'];
            $login = $utilisateur['login'];
            $password = $utilisateur['password'];
            $_SESSION['connexion'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            header("Location: ./profil.php");
        }
        // Mot de passe incorrect
        else {
            $error = true;
            $error_message = "<span class='error'>Identifiant ou mot de passe incorrect</span>";
        }
    }
}
?>

<!------------------------------------------------>
<?php
include "./include/head.php";
?>
    <title>[Le Salon] Salle de réunion haut de gamme - connexion</title>
    <meta name="description" content="Page de cnnexion de la salle de réunion haut de gamme Le Salon" />
    </head>
<!------------------------------------------------>

<body>
    <!--header-------------------------------------------------------->
    <?php
    include "./include/header.php";
    ?>
    <!--corps-------------------------------------------------------->
    <main>
        <section class="co">
            <h1>Connexion</h1>
            <?php
            // Messages (validation et erreur)
            if ($error == true) {
                echo $error_message;
            }
            if (isset($_SESSION['validation'])) {
                echo "<span class='validation'>Félicitation pour
            ton inscription</span>";
                unset($_SESSION['validation']);
            }
            ?>
            <!--formulaire-->
            <form method='post' action='connexion.php'>
                <input type='text' name='login' value='<?= $_SESSION['login'] ?>' placeholder='Identifiant'>
                <input type='password' name='password' value='<?= $_SESSION['password'] ?>' placeholder='Mot de passe'>
                <button class="button" type='submit' name='connexion'>Connexion</button>
            </form>
            <p>
                Pas encore de compte ?<br>
                <a class='bouton' href='inscription.php'>S'inscrire</a>
            </p>
        </section>
    </main>
    <!--footer-------------------------------------------------------->
    <?php
    include "./include/footer.php";
    ?>
</body>

</html>