<?php
session_start();
?>

<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Réservation</title>
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
        <header class="header_index">
            <a href="reservation-form.php">Faire une réservation</a>
        </header>
        <section>
            <article>
                <p>
                    Bienvenue dans notre salle de réunion haut de gamme <strong>Le Salon</strong>,
                    un espace exclusif conçu pour répondre à vos besoins professionnels les plus exigeants.
                    Disponible du lundi au vendredi, de 8h à 19h, cette salle offre un
                    environnement luxueux et moderne, parfaitement adapté à vos réunions d'affaires
                    les plus importantes.
                </p>
                <p>
                    Notre salle de réunion incarne l'élégance contemporaine avec son design
                    sophistiqué et ses équipements de pointe. Chaque détail a été soigneusement
                    pensé pour créer un cadre professionnel et
                    inspirant qui favorise la créativité et la productivité.
                </p>
                <p>
                    Les caractéristiques de cette salle comprennent des équipements audiovisuels
                    de haute qualité, des sièges ergonomiques pour un confort optimal, un éclairage
                    ajustable pour créer l'ambiance parfaite,
                    et une connexion internet ultra-rapide pour assurer des communications fluides.
                </p>
                <p>
                    Que ce soit pour des présentations exécutives, des sessions de brainstorming,
                    des entretiens confidentiels ou des réunions stratégiques, notre salle de réunion
                    haut de gamme offre un espace polyvalent qui peut être adapté à vos besoins
                    spécifiques. Nous nous efforçons de fournir un service exceptionnel pour garantir
                    le succès de chaque réunion que vous organisez dans notre établissement.
                </p>
                <p>
                    La réservation de notre salle de réunion haut de gamme est simple et flexible.
                    Il vous suffit de nous contacter pour réserver l'espace à la date et à l'heure
                    qui vous conviennent. Notre équipe dédiée sera à votre disposition pour répondre
                    à vos besoins particuliers et s'assurer que votre
                    réunion se déroule sans accroc.
                </p>
                <p>
                    Découvrez le luxe et la fonctionnalité réunis dans notre salle de réunion haut
                    de gamme. Faites de chaque réunion une expérience mémorable dans un cadre
                    professionnel exceptionnel. Nous sommes impatients de vous accueillir dans
                    notre espace exclusif où le succès de votre entreprise prend vie.
                </p>
            </article>
        </section>
    </main>
    <!--footer-------------------------------------------------------->
    <?php
    include "./include/footer.php";
    ?>
</body>

</html>