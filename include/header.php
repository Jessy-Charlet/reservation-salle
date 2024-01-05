<nav class="menu">
<a href="index.php"><img src="./media/logo-le-salon.png" alt="Accueil"></a>

<?php
if (isset($_SESSION['connexion']) == true){
echo "<a href='planning.php'>Planning</a>";
echo "<a href='profil.php'>".$_SESSION['login']."</a>";
}
else {
    echo "<a href='connexion.php'>Connexion</a>";
}
?>

<a href="index.php">Home</a>
</nav>