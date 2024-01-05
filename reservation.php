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
            <section class="reservation">
    <h1><?= $_GET['titre']?></h1>
    <p><span>Réservé de :</span><br><?= $_GET['debut']?><br><span>à</span><br><?= $_GET['fin']?></p>
    <p><span>Reservation effectuée par :</span><br><?= $_GET['login']?></p>
    <p><span>Description :</span><br><?= $_GET['description']?></p>
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