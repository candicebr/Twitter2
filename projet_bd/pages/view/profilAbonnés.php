<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./iew/css/styleProfil.css">
</head>

<body>

<!--menu-->

<?php include("menu.php"); ?>

<!-- Petit menu: tweets, abonnements, abonnés, j'aime-->

<section>
    <a href="profilTweet.php"><h4>Tweets</h4></a><a href="profilAbonnement.php"><h4>Abonnements</h4></a><a href="profilAbonnés.php"><h4>Abonnés</h4></a><a href="profilLike.php"><h4>J'aime</h4></a><a href="changeProfil.php"><h14>Editer le profil</h14></a>
</section>

<!-- courte description du profil-->

<?php include("descriptionProfil.php"); ?>

<!-- nos abonnés-->

<?php foreach ($params['users'] as $user) : ?>
    <li>
        <a href="traitementSuivre.php/<?php echo $user->getId() ?>">  <h5>Désabonner</h5> </a>
        <h6><?php echo $user->getPseudo(); ?></h6>
        <h7>@<?php echo $user->getUserName(); ?></h7>
        <h8><?php echo $user->getInfoPerso(); ?></h8>
    </li>
<?php endforeach; ?>

<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>