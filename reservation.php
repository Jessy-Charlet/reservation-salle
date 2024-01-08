<?php
session_start();

if (isset($_SESSION['connexion'])) {
    if (($_SESSION['connexion'] == false)) {
        header("Location: ./connexion.php");
    }
} elseif (empty($_SESSION['connexion'])) {
    header("Location: ./connexion.php");
}


?>
<!------------------------------------------------>
<?php
include "./include/head.php";
?>
<!------------------------------------------------>

<body>
    <?php
    include "./include/header.php";
    ?>
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
    <?php
    include "./include/footer.php";
    ?>
</body>
</html>