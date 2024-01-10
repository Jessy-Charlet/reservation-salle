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

// Mise en place des variables
$error = false;
$validation = false;
$date = new DateTime();
$ajoutsemaine = new DateInterval('P6D');

// Réaction au formulaire POST
if (isset($_POST['resa'])) {
    // Requête SQL 
    $sql = "SELECT * FROM reservations";
    // Exécution de la requête
    $sql_resultat = $sql_connexion->query($sql);

    $pdate = date_create($_POST['date']);
    if (date_format($pdate, "D") == "Sun" or date_format($pdate, "D") == "Sat") {
        $error = true;
        $bdd = false;
        $error_message = "<span class='error'>Le Salon n'est pas disponnible le weekend.</span><br/>
        <a href='planning.php'>Voir le planning</a>";
    } else {
        foreach ($sql_resultat as $reservation) {
            $rdate = explode(" ", $reservation['debut']);
            $postresadate = explode(" ", $_POST['debut']);
            $resadatefin = explode(" ", $reservation['fin']);
            /*$heure = substr($rdate, 0, 1);
            $postheure = substr($postresadate, 0, 1);
            $heurefin = substr($resadatefin, 0, 1);*/
            // Si la réservation existe déjà message d'erreurS
            if ($rdate['0'] == $_POST['date']) {
                var_dump($error);
                /* while (strval($heure) < strval($heurefin["0"])) {
                     if (strval($heure) == strval($postheure["0"])) {
                         $error = true;
                         $error_message = "<span class='error'>Une réservation est déjà prise sur ces horraires.
                         <a href='planning.php'>Voir le planning</a></span>";
                     } else {
                         $bdd = true;
                     }
                     $heure++;
                 }*/
            }
            // Sinon 
            else {
                $bdd = true;
            }
        }
    }

    // Enregistrement dans la base de données
    if ($bdd == true) {
        // Atribution des variables
        $date = $_POST['date'];
        $debut = $date . " " . $_POST['debut'];
        $fin = $date . " " . $_POST['fin'];
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $id = $_SESSION['id'];
        // Requête SQL 
        $sql = "INSERT INTO reservations (titre, description, debut, fin, id_utilisateur)
        VALUE ('$titre', '$description', '$debut', '$fin', '$id')";
        // Exécution de la requête
        $sql_resultat = $sql_connexion->query($sql);
        // Retour sur le planning et message de validation
        $_SESSION['val'] = true;
        header("Location: ./planning.php");
    }
}
?>

<!------------------------------------------------>
<?php
include "./include/head.php";
?>
<!------------------------------------------------>

<body>
    <!--header-------------------------------------------------------->
    <?php
    include "./include/header.php";
    ?>
    <title>[Le Salon] Salle de réunion haut de gamme - réserver un créneau</title>
    <meta name="description" content="Formulaire de réservation de la salle de réunion hat de gamme Le Salon" />
    </head>


    <!--corps-------------------------------------------------------->
    <main>
        <section class="resa">
            <div>.</div>
            <div>
            <h1>Reservation</h1>
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
            <p>Effectuer une réservation au nom de <span class="gras"><?= $_SESSION['login'] ?></span>
            </p>
            <form method='post' action='reservation-form.php'>
                <label for="titre">Titre :</label>
                <input type='text' id="titre" name='titre' required placeholder="Nom de l'activitée">
                <label for="date">Date :</label>
                <input type="date" id="date" name="date" value="<?= $date->format('Y-m-d') ?>"
                    min="<?= $date->format('Y-m-d') ?>" max="<?php $date->add($ajoutsemaine);
                      echo $date->format('Y-m-d') ?>" />
                <label for="debut">Heure de début :</label>
                <select name="debut" id="debut">
                    <?php
                    for ($hd = 8; $hd <= 18; $hd++) {
                        if ($hd < 10) {
                            echo "<option value='0" . $hd . ":00:00'>" . $hd . "H</option>";
                        } else {
                            echo "<option value='" . $hd . ":00:00'>" . $hd . "H</option>";
                        }
                    }
                    ?>
                </select>
                <label for="fin">Heure de fin :</label>
                <select name="fin" id="fin">
                    <?php
                    for ($hf = 9; $hf <= 19; $hf++) {
                        if ($hf < 10) {
                            echo "<option value='0" . $hf . ":00:00'>" . $hf . "H</option>";
                        } else {
                            echo "<option value='" . $hf . ":00:00'>" . $hf . "H</option>";
                        }
                    }
                    ?>

                </select>
                <label for="description">Description :</label>
                <textarea id="description" name="description" maxlength="40" required rows="3" cols="33" placeholder="Une courte description de l'activitée prévu dans [Le Salon]"></textarea>
                <button class="button" type='submit' name='resa'>Reserver</button>
            </form>
                </div>
        </section>
    </main>
    <!--footer-------------------------------------------------------->
    <?php
    include "./include/footer.php";
    ?>
</body>

</html>