<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./view/css/styleProfilAbonnements.css">
</head>

<body>

<!--menu-->

<?php include("menu.php"); ?>

<!-- Petit menu: tweets, abonnements, abonnés, j'aime-->

<section>
    <a href="/projet_bd/pages/profilTweet"><h4>Tweets</h4></a><a href="/projet_bd/pages/profilAbonnement"><h4>Abonnements</h4></a><a href="/projet_bd/pages/profilAbonnes"><h4>Abonnés</h4></a><a href="/projet_bd/pages/profilLike"><h4>J'aime</h4></a><a href="/projet_bd/pages/changeProfil"><h14>Editer le profil</h14></a>
</section>

<!-- courte description du profil-->

<?php include("descriptionProfil.php"); ?>

<!-- nos abonnement-->


<?php foreach ($params['users'] as $user) : ?>
    <li>
        <a href="/projet_bd/pages/traitementSuivre/<?php echo $user->getId() ?>">  <h15>Désabonner</h15> </a>
        <a href="/projet_bd/pages/profilOtherPeopleAbonnement/<?php echo $user->getId() ?>"><h16><?php echo $user->getPseudo(); ?></h16></a>
        <h17>@<?php echo $user->getUserName(); ?></h17>
        <h8><?php echo $user->getInfoPerso(); ?></h8>
    </li>
<?php endforeach; ?>

<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>