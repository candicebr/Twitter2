
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./view/css/styleTL.css">
</head>

<body>

<!--menu-->

<?php include("menu.php"); ?>

<!-- Rapide apperçu du profil -->
<section>
    <h4><?php echo $_SESSION['pseudo']; ?></h4>
    <h5>@<?php echo $_SESSION['user_name']; ?></h5>
    <h6>Tweets</h6><h6>Abonnements</h6><h6>Abonnés</h6>
    <h7><?php //echo $_SESSION['nombre_tweet']; ?></h7><h7>Nombre</h7><h7>Nombre</h7>
</section>

<!-- tlTweet-->


<?php foreach ($params['tweets'] as $tweets) : ?>

    <li>
        <h8><?php echo $params['tweets']['user_name']; ?></h8><h10><?php echo $tweets->getTweetDate();?></h10>
        <h9><?php echo $tweets->getTweetContent(); ?></h9>
        <a href="traitementRetweet.php/<?php echo $tweets->getTweetId() ?>">  <h10>Retweeter</h10> </a><h11>nombre </h11><a href="traitementLike.php/<?php echo $tweets->getTweetId() ?>">  <h12>J'aime </h12> </a><h13>nombre</h13>
    </li>
<?php endforeach; ?>
<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>
