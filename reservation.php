<?php
session_start();

// Vérification de l'état de connexion du client
if (isset($_SESSION['connexion'])) {
    if (($_SESSION['connexion'] == false)) {
        header("Location: ./connexion.php");
    }
} elseif (empty($_SESSION['connexion'])) {
    header("Location: ./connexion.php");
}


?>
<!--Head---------------------------------------------->
<?php
include "./include/head.php";
?>
    <title>[Le Salon] Salle de réunion haut de gamme - réservation</title>
    <meta name="description" content="Réservation de la salle de réunion hat de gamme Le Salon" />
    </head>
<!------------------------------------------------>

<body>
    
    <!--Header-------------------------------------------------------->

    <?php
    include "./include/header.php";
    ?>
    
    <!--Main-------------------------------------------------------->

    <main>
        <section class="reservation">
            <h1>
                <?= $_GET['titre'] ?>
            </h1>
            <p><span>Réservé de :</span><br>
                <?= $_GET['debut'] ?><br><span>à</span><br>
                <?= $_GET['fin'] ?>
            </p>
            <p><span>Reservation effectuée par :</span><br>
                <?= $_GET['login'] ?>
            </p>
            <p><span>Description :</span><br>
                <?= $_GET['description'] ?>
            </p>
            <div>
                <div class="rond"></div>
                <div class="rond"></div>
                <div class="rond"></div>
            </div>
        </section>
    </main>
    
    <!--Footer-------------------------------------------------------->

    <?php
    include "./include/footer.php";
    ?>
</body>
</html>