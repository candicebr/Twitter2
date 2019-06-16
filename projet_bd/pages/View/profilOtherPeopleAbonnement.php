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
    <a href="/profilTweet"><h4>Tweets</h4></a><a href="/profilAbonnement"><h4>Abonnements</h4></a><a href="/profilAbonnes"><h4>Abonnés</h4></a><a href="/profilLike"><h4>J'aime</h4></a><a href="/changeProfil"><h14>Editer le profil</h14></a>
</section>

<!-- courte description du profil-->

<?php include("descriptionProfil.php"); ?>

<!-- nos tweets et retweet-->

<?php foreach ($params['tweets'] as $tweet) : ?>

    <li>
        <h8><?php echo $tweet["user_name"]; ?></h8><h10><?php echo $tweet["tweet_date"];?></h10>
        <h9><?php echo $tweet["tweet_content"]; ?></h9>
        <a href="/traitementRetweet/<?php echo $tweet["tweet_id"] ?>">  <h10>Retweeter</h10> </a><a href="/traitementLike/<?php echo $tweet["tweet_id"] ?>">  <h12>J'aime </h12> </a>
    </li>
<?php endforeach; ?>

<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>