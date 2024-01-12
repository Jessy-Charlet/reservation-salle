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
$validation_message = "<span class='validation'>Votre résesrvation a été réalisée avec succès !</span>";

// Mise en place des variables
$error = false;
$lastday = new DateTime();
$today = new DateTime();
$ajoutsemaine = new DateInterval('P6D');
$ajoutunjour = new DateInterval('P1D');
$lastday->add($ajoutsemaine);

$jour = getdate();

?>

<!--Head---------------------------------------------->
<?php
include "./include/head.php";
?>
    <title>[Le Salon] Salle de réunion haut de gamme - le planning</title>
    <meta name="description" content="Planning de la salle de réunion hat de gamme Le Salon" />
    </head>
<!------------------------------------------------>

    <body>
        <!--Head---------------------------------------------->
        <?php
        include "./include/header.php";
        ?>

        <!--Main---------------------------------------------->
        <main>
            <h1>
                Réservations pour la semaine du
                <?= $today->format('d') ?> au
                <?php
                echo $lastday->format('d');
                ?>
            </h1>
            <a href="reservation-form.php" class="btn_resa">Réserver un créneau</a>
            <?php
            if ($validation == true) {
                echo $validation_message;
            }



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
                <div class="planheure1 planc">8 h</div>
                <div class="planheure planc">9 h -</div>
                <div class="planheure planc">10 h -</div>
                <div class="planheure planc">11 h -</div>
                <div class="planheure planc">12 h -</div>
                <div class="planheure planc">13 h -</div>
                <div class="planheure planc">14 h -</div>
                <div class="planheure planc">15 h -</div>
                <div class="planheure planc">16 h -</div>
                <div class="planheure planc">17 h -</div>
                <div class="planheure planc">18 h -</div>
                <div class="planheure1 planc">19 H</div>
            </div>
            <?php

            for ($i = 0; $i < 7; $i++) {
                if ($today->format('D') == "Mon"){
                    $day = "Lundi";
                }
                elseif ($today->format('D') == "Tue"){
                    $day = "Mardi";
                }
                elseif ($today->format('D') == "Wed"){
                    $day = "Mercredi";
                }
                elseif ($today->format('D') == "Thu"){
                    $day = "Jeudi";
                }
                elseif ($today->format('D') == "Fri"){
                    $day = "Vendredi";
                }
                elseif ($today->format('D') == "Sat"){
                    $day = "Samedi";
                }
                elseif ($today->format('D') == "Sun"){
                    $day = "Dimanche";
                }
                echo "<div class='planjour'>";
                echo "<div class='plandate planc'>".$day." ".$today->format('d') . "</div>";
                $verif = 0;
                $supcase = 0;
                for ($h = 8; $h < 19; $h++) {
                    if ($today->format('D') == "Sat" or $today->format('D') == "Sun") {
                        echo "<div class='planweekend planc'></div>";
                    } else {
                        foreach ($sql_resultat as $resa) {
                            $plannig_verif = false;
                            if ($h < 10){
                                $heure = "0".$h . ":00:00";
                            }
                            else{
                                $heure = $h . ":00:00";
                            }
                            $resadate = explode(" ", $resa['debut']);
                            $resadatefin = explode(" ", $resa['fin']);
                            if ($resadate[0] == $today->format('Y-m-d') and $resadate[1] == $heure) {
                                if (intval($resadatefin[1]) - intval($resadate[1]) == 1) {
                                    $case = "planc";
                                    $supcase = $supcase + 1;
                                } elseif (intval($resadatefin[1]) - intval($resadate[1]) == 2) {
                                    $case = "planc2";
                                    $supcase = $supcase + 2;
                                } elseif (intval($resadatefin[1]) - intval($resadate[1]) == 3) {
                                    $case = "planc3";
                                    $supcase = $supcase + 3;
                                } elseif (intval($resadatefin[1]) - intval($resadate[1]) == 4) {
                                    $case = "planc4";
                                    $supcase = $supcase + 4;
                                }
                                elseif (intval($resadatefin[1]) - intval($resadate[1]) == 5) {
                                    $case = "planc5";
                                    $supcase = $supcase + 5;
                                }
                                elseif (intval($resadatefin[1]) - intval($resadate[1]) == 6) {
                                    $case = "planc6";
                                    $supcase = $supcase + 6;
                                }
                                elseif (intval($resadatefin[1]) - intval($resadate[1]) == 7) {
                                    $case = "planc7";
                                    $supcase = $supcase + 7;
                                }
                                elseif (intval($resadatefin[1]) - intval($resadate[1]) == 8) {
                                    $case = "planc8";
                                    $supcase = $supcase + 8;
                                }
                                elseif (intval($resadatefin[1]) - intval($resadate[1]) == 9) {
                                    $case = "planc9";
                                    $supcase = $supcase + 9;
                                }
                                elseif (intval($resadatefin[1]) - intval($resadate[1]) == 10) {
                                    $case = "planc9";
                                    $supcase = $supcase + 10;
                                }
                                elseif (intval($resadatefin[1]) - intval($resadate[1]) == 11) {
                                    $case = "planc9";
                                    $supcase = $supcase + 11;
                                }
                                
                                echo "<a href='reservation.php?titre=" . $resa['titre'] . "&debut="
                                    . $resa['debut'] . "&fin=" . $resa['fin'] . "&login=" . $resa['login'] . "&description="
                                    . $resa['description'] . "' class='linkplan'><div class='planc planresa " . $case . "'><h2>"
                                    . $resa['titre'] . "</h2>
                                <span>" . $resa['login'] . "</span></div></a>";
                                break;
                            } else {
                            }
                        }
                        if ($supcase == 0) {
                            echo "<div class='planvide planc'>Disponible</div>";
                        }
                        else {
                            $supcase--;
                        }
                    }
                }
                echo "</div>";
                $today->add($ajoutunjour);
            }
            echo "</div>";
            ?>
        </main>

        <!--Footer---------------------------------------------->
        <?php
        include "./include/footer.php";
        ?>
    </body>

    </html>