<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./view/css/styleProfil.css">
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

<!-- nos tweets et retweet-->

<?php foreach ($params['tweets'] as $tweets) : ?>

    <li>
        <?php if ($tweets->getTweetUserId() == $_SESSION['id']) {?> <a href="traitementSuppTweet.php/<?php echo $tweets->getTweetId() ?>">  <h15>Supprimer</h15></a> <?php }?>
        <h8><?php echo $_SESSION['user_name']; ?></h8><h10><?php echo $tweets->getTweetDate();?></h10>
        <h9><?php echo $tweets->getTweetContent(); ?></h9>
        <a href="traitementRetweet.php/<?php echo $tweets->getTweetId() ?>">  <h10>Retweeter</h10> </a><h11>nombre </h11><a href="traitementLike.php/<?php echo $tweets->getTweetId() ?>">  <h12>J'aime </h12> </a><h13>nombre</h13>
    </li>
<?php endforeach; ?>

<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>