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
$lastday = new DateTime();
$today = new DateTime();
$ajoutsemaine = new DateInterval('P6D');
$ajoutunjour = new DateInterval('P1D');
$lastday->add($ajoutsemaine);

$jour = getdate();
$semaine = array(
    " Dimanche ",
    " Lundi ",
    " Mardi ",
    " Mercredi ",
    " Jeudi ",
    " vendredi ",
    " samedi "
);
$mois = array(
    1 => " janvier ",
    " février ",
    " mars ",
    " avril ",
    " mai ",
    " juin ",
    " juillet ",
    " août ",
    " septembre ",
    " octobre ",
    " novembre ",
    " décembre "
);
?>

<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Planning</title>
    <meta name="author" content="Jessy Charlet">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./include/style.css">
</head>
<!-------------------------------------------------------------->

<body>

    <body>
        <?php
        include "./include/header.php";
        ?>
        <main>
            <h1>
                Réservations du
                <?= $today->format('d M') ?> au
                <?php
                echo $lastday->format('d M');
                ?>
            </h1>
            <a href="reservation-form.php" class="btn_resa">Réserver un créneau</a>
            <?php
            $m = intval($today->format('m'));
            $y = intval($today->format('Y'));
            $sem = array(6, 0, 1, 2, 3, 4, 5); // Correspondance des jours de la semaine : lundi = 0, dimanche = 6
            $week = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');

            $t = mktime(12, 0, 0, $m, 1, $y); // Timestamp du premier jour du mois
            


            // Requête SQL (selectionne toutes les infos de la table réservations)
            $sql = "SELECT * FROM reservations
            INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id";
            // Exécution de la requête SQL
            $sql_resultat = $sql_connexion->query($sql);
            // Les jours de la semaine
            echo "<div class='plan'>";
            ?>
            <div class="planjour">
                <div class="plandate planc"></div>
                <div class="planheure planc">8H / 9H</div>
                <div class="planheure planc">10H / 11h</div>
                <div class="planheure planc">11H / 12h</div>
                <div class="planheure planc">12H / 13h</div>
                <div class="planheure planc">13H / 14h</div>
                <div class="planheure planc">14H / 15h</div>
                <div class="planheure planc">15H / 16h</div>
                <div class="planheure planc">16H / 17h</div>
                <div class="planheure planc">17H / 18h</div>
                <div class="planheure planc">18H / 19h</div>
            </div>
            <?php
            for ($i = 0; $i < 7; $i++) {
                echo "<div class='planjour'>";
                echo "<div class='plandate planc'>" . $today->format('D d') . "</div>";
                for ($h = 9; $h < 19; $h++) {
                    if ($today->format('D') == "Sat" or $today->format('D') == "Sun") {
                        echo "<div class='planweekend planc'></div>";
                    } else {
                        $verif = 0;
                        foreach ($sql_resultat as $resa) {
                            $plannig_verif = false;
                            $heure = $h . ":00:00";
                            $resadate = explode(" ", $resa['debut']);
                            if ($resadate[0] == $today->format('Y-m-d') and $resadate[1] == $heure) {
                                echo "<a href='reservation.php?titre=".$resa['titre']."&debut=".$resa['debut']."&fin=".$resa['fin']."&login=".$resa['login']."&description=".$resa['description']."' class='linkplan'><div class='planresa planc'><h2>" . $resa['titre'] . "</h2>
                                <span>" . $resa['login'] . "</span></div></a>";
                                $verif = 1;
                                break;
                            } else {

                            }
                        }
                        if ($verif == 0) {
                            echo "<div class='planvide planc'>Disponible</div>";
                        }
                    }
                }
                echo "</div>";
                $today->add($ajoutunjour);
            }
            echo "</div>";
            ?>
        </main>
        <?php
        include "./include/footer.php";
        ?>
    </body>