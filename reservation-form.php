<?php
session_start();
include "./include/sql.php";

if (isset($_SESSION['connexion'])) {
    if (($_SESSION['connexion'] == false)) {
        header("Location: ./connexion.php");
    }
} elseif (empty($_SESSION['connexion'])) {
    header("Location: ./connexion.php");
}

$error = false;
$validation = false;
$date = new DateTime();
$ajoutsemaine = new DateInterval('P6D');


if (isset($_POST['resa'])) {
    // Requête SQL 
    $sql = "SELECT * FROM reservations";
    // Exécution de la requête
    $sql_resultat = $sql_connexion->query($sql);
    foreach ($sql_resultat as $reservation) {
        // Si la réservation existe déjà message d'erreur
        if (
            intval($reservation['debut']) >= intval($_POST['debut']) and intval($reservation['debut']) <= intval($_POST['fin']) or
            intval($reservation['fin']) >= intval($_POST['debut']) and intval($reservation['fin']) <= intval($_POST['fin'])
        ) {            
            $error = true;
            $error_message = "<span class='error'>Une réservation est déjà prise sur ces horraires
            <a href='planning.php'>Voir le planning</a></span>";
        }
        // Sinon 
        else {
            // Atribution des variables
            $date = $_POST['date'];
            $debut = $date . " " . $_POST['debut'];
            $fin = $date . " " . $_POST['fin'];
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $id = $_SESSION['id'];
            // Enregistrement dans la Base de Données
            // Requête SQL 
            $sql = "INSERT INTO reservations (titre, description, debut, fin, id_utilisateur)
        VALUE ('$titre', '$description', '$debut', '$fin', '$id')";
            // Exécution de la requête
            $sql_resultat = $sql_connexion->query($sql);
            // Message de validation
            $validation = true;
            $validation_message = "<span class='error'>Votre résesrvation a été réalisée avec succès !<br>
            <a href='planning.php'>Voir le planning</a></span>";
            break;
        }
    }
}
?>

<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Connexion</title>
    <meta name="author" content="Jessy Charlet">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./include/style.css">
</head>
<!-------------------------------------------------------------->

<body>
    <!--header-------------------------------------------------------->
    <?php
    include "./include/header.php";
    ?>



    <!--corps-------------------------------------------------------->
    <main>
        <section>
            <h1>Reservation</h1>
            <?php
            // Messages (validation et erreur)
            if ($error == true) {
                echo $error_message;
            } elseif ($validation == true) {
                echo $validation_message;
            }
            if (isset($_SESSION['validation'])) {
                echo "<span class='validation'>Félicitation pour
            ton inscription</span>";
                unset($_SESSION['validation']);
            }
            ?>
            <!--formulaire-->
            <p>Utilisateur :
                <?= $_SESSION['login'] ?>
            </p>
            <form method='post' action='reservation-form.php'>
                <label for="titre">Titre :</label>
                <input type='text' id="titre" name='titre' required placeholder='Titre'>
                <label for="date">Date :</label>
                <input type="date" id="date" name="date" value="<?= $date->format('Y-m-d') ?>" min="<?= $date->format('Y-m-d') ?>"
                    max="<?php $date->add($ajoutsemaine);
                echo $date->format('Y-m-d')?>" />
                <label for="debut">Heure de début :</label>
                <select name="debut" id="debut">
                    <option value="08:00:00">8H</option>
                    <option value="09:00:00">9H</option>
                    <option value="10:00:00">10H</option>
                    <option value="11:00:00">11H</option>
                    <option value="12:00:00">12H</option>
                    <option value="13:00:00">13H</option>
                    <option value="14:00:00">14h</option>
                    <option value="15:00:00">15H</option>
                    <option value="16:00:00">16H</option>
                    <option value="17:00:00">17H</option>
                    <option value="18:00:00">18H</option>
                    <option value="19:00:00">19H</option>
                </select>
                <label for="fin">Heure de fin :</label>
                <select name="fin" id="fin">
                    <option value="09:00:00">9H</option>
                    <option value="10:00:00">10H</option>
                    <option value="11:00:00">11H</option>
                    <option value="12:00:00">12H</option>
                    <option value="13:00:00">13H</option>
                    <option value="14:00:00">14h</option>
                    <option value="15:00:00">15H</option>
                    <option value="16:00:00">16H</option>
                    <option value="17:00:00">17H</option>
                    <option value="18:00:00">18H</option>
                    <option value="19:00:00">19H</option>
                </select>
                <label for="description">Description :</label>
                <textarea id="description" name="description" maxlength="40" required rows="2" cols="33"></textarea>
                <button class="button" type='submit' name='resa'>Reserver</button>
            </form>
        </section>
    </main>
    <!--footer-------------------------------------------------------->
    <?php
    include "./include/footer.php";
    ?>
</body>