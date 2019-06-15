<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./View/css/styleProfil.css">
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

<!-- nos tweets et retweet-->

<?php foreach ($params['tweets'] as $tweets) : ?>

    <li>
        <?php if ($tweets["tweet_id"] == $_SESSION['id']) {?> <a href="/projet_bd/pages/traitementSuppTweet/<?php echo $tweets["tweet_id"] ?>">  <h15>Supprimer</h15></a> <?php }?>
        <h8><?php echo $tweets["user_name"]; ?></h8><h10><?php echo $tweets["tweet_date"];?></h10>
        <h9><?php echo $tweets["tweet_content"]; ?></h9>
        <a href="/projet_bd/pages/traitementRetweet/<?php echo $tweets["tweet_id"] ?>">  <h10>Retweeter</h10> </a><a href="traitementLike.php/<?php echo $tweets["tweet_id"] ?>"><h12>J'aime </h12> </a>
    </li>
<?php endforeach; ?>

<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>
