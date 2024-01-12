<?php
session_start();
include "./include/sql.php";

// Vérification de l'état de connexion du client
if (isset($_SESSION['connexion'])) {
    if (($_SESSION['connexion'] == false)) {
        header("Location: ./connexion.php");
    }
} elseif (empty($_SESSION['connexion'])) {
    header("Location: ./connexion.php");
}

// Vérification du message de validation
if (isset($_SESSION['val'])) {
    $validation = $_SESSION['val'];
    unset($_SESSION['val']);
} else {
    $validation = false;
}

$error = false;
$validation = false;


//  Déconnexion
if (isset($_POST['deco'])) {
    session_destroy();
    header("Location: ./connexion.php");
}

//  Modification du login
if (isset($_POST['update_login'])) {
    $id = $_SESSION['id'];
    $login = $_POST['login'];
    $_SESSION['login'] = $login;
    $sql = "SELECT * FROM utilisateurs WHERE login='" . $_POST['login'] . "'";
    $sql_resultat = $sql_connexion->query($sql);
    if (mysqli_num_rows($sql_resultat)) {
        $error = true;
        $error_message = "<span class='error'>Cet identifiant existe déjà, merci d'en renseigner
        un nouveau</span>";
    } else {
        $sql = "UPDATE utilisateurs SET login='$login' WHERE id='$id'";
        $sql_resultat = $sql_connexion->query($sql);
        $validation = true;
        $validation_message = "<span class='validation'>Votre identifiant a bien été modifié.</span>";
    }

}
//  Modification du mot de passe
elseif (isset($_POST['update_password'])) {
    $id = $_SESSION['id'];
    $password = $_POST['password'];
    $_SESSION['password'] = $password;
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $error = true;
        $error_message = "<span class='error'>Votre mot de passe et sa confirmation ne
        sont pas identiques !</span>";
    } elseif (strlen($_POST['password']) < 6) {
        $error = true;
        $error_message = "<span class='error'>Votre mot de passe est trop court, il doit contenir
        au moins 6 caractères</span>";
    } else {
        $sql = "UPDATE utilisateurs SET password='$password' WHERE id=$id";
        $sql_resultat = $sql_connexion->query($sql);
        $validation = true;
        $validation_message = "<span class='validation'>Votre mot de passe a bien été modifié.</span>";
    }
}
//  Suppression d'une réservation
elseif (isset($_POST['supprimer'])) {
    $ids = $_POST['id'];
    $sql = "DELETE FROM reservations WHERE id=$ids";
    $sql_resultat = $sql_connexion->query($sql);
    $validation = true;
    $validation_message = "<span class='validation'>Votre réservation à bien étée annulée.</span>";
}



?>

<!--Head---------------------------------------------->
<?php
include "./include/head.php";
?>
<title>[Le Salon] Salle de réunion haut de gamme - mon profil</title>
<meta name="description" content="Mon compte de la salle de réunion hat de gamme Le Salon" />
</head>
<!------------------------------------------------>

<body>
    <!--Header---------------------------------------------->
    <?php
    include "./include/header.php";
    ?>

    <!--Main---------------------------------------------->
    <main>
        <section class="profil">
            <div>
                <?php
                // Requête SQL 
                $sql = "SELECT  login AS 'Identifiant', password AS 'Mot de passe'
    FROM utilisateurs WHERE id='" . $_SESSION['id'] . "'";
                $sql_resultat = $sql_connexion->query($sql);
                //-------------------------------------------------------------------------------
                echo "<h1>" . $_SESSION['login'] . "</h1>";
                ?>
                <a href="reservation-form.php">Faire une réservation</a>
                <form method='post' action='profil.php'>
                    <button class="deconnexion" type='submit' name='deco'>Déconnexion</button>
                </form>
            </div>
            <div>
                <h2>Modifier mes informations</h2>
                <form method='post' action='profil.php'>
                    <label for='login'>Identifiant</label>
                    <input type='text' name='login' id='login' value='<?= $_SESSION['login'] ?>'
                        placeholder='Identifiant' required />
                    <button type='submit' name='update_login'>Ok</button>
                </form>

                <form method='post' action='profil.php'>
                    <label for='mdp'>Mot de passe</label>
                    <div>
                        <input type='password' name='password' id='mdp' placeholder='Mot de passe' required />
                        <input type='password' name='confirm_password' placeholder='Confirmation du mot de passe'
                            required />
                    </div>
                    <button type='submit' name='update_password'>Ok</button>
                </form>
            </div>
            <div>
                <?php
                // Affichage des messages errors et validation
                if ($error == true) {
                    echo $error_message;
                } elseif ($validation == true) {
                    echo $validation_message;
                }
                echo "<h2>Mes réservations</h2>";
                // Affichage des réservations
                // Requête SQL
                $sql = "SELECT titre, debut, fin, description, id
                FROM reservations  WHERE id_utilisateur='" . $_SESSION['id'] . "' ORDER BY debut DESC";
                $sql_resultat = $sql_connexion->query($sql);
                //-------------------------------------------------------------------------------
                echo "<div>";
                $date = date('Y-m-d H:i:s');
                while ($row = mysqli_fetch_array($sql_resultat, MYSQLI_ASSOC)) {
                    if ($row["debut"] < $date) {
                        $perim = "perim";
                    } elseif ($row["debut"] > $date) {
                        $perim = "pasperim";
                    }
                    echo "<div class='reservationp " . $perim . "'>";
                    echo "<div>" . $row['titre'] . "</div>";
                    echo "<p>Réservé le: <span>" . substr($row["debut"], 8, -9) . "/" . substr($row["debut"], 5, -12) . "/" . substr($row["debut"], 0, 4) . "</span><br>";
                    echo "De<span> " . $row["debut"]["11"] . $row["debut"]["12"] . "H </span>à <span>" . $row["fin"]["11"] . $row["fin"]["12"] . "H</span>";
                    echo "<p>" . $row['description'] . "</p>";
                    if ($perim == "pasperim") {
                        echo "<form method='post' action='profil.php'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'/>";
                        echo "<button type='submit' name='supprimer'>Annuler ma réservation</button>";
                        echo "</form>";
                    } elseif ($perim == 'perim') {
                        echo "<div>Réservation expirée</div>";
                    }
                    echo "<div>
                        <div class='rond'></div>
                        <div class='rond'></div>
                        <div class='rond'></div>
                    </div>
                </div>";
                }
                ?>
            </div>
            </div>
        </section>
    </main>
    <!--Footer---------------------------------------------->
    <?php
    include "./include/footer.php";
    ?>
</body>

</html>