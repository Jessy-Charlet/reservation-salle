<nav class="menu">
<a href="index.php"><img src="./media/logo-le-salon.png" alt="Accueil"></a>

<?php
if (isset($_SESSION['connexion']) == true){
echo "<a href='planning.php'><img src='./media/planning.png'/>Planning</a>";
echo "<a href='profil.php'><img src='./media/id.png'/>".$_SESSION['login']."
</a>";
}
else {
    echo "<a href='connexion.php'><img src='./media/id.png'/>Connexion</a>";
}
?>

</nav>