<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./View/css/styleTweeter.css">
</head>

<body>

<!--menu-->

<?php include("menu.php"); ?>

<article>
    <h4>Ecrire un nouveau Tweet</h4>
    <ul class="form-style-2">
    <form method="post" action="/projet_bd/pages/traitementTweet">
        <textarea name="tweet_content" id="tweet_content" class="field-divided" placeholder="Quoi de neuf ?" rows="5" cols="70" maxlength="140"></textarea>
        <input type="submit" value="Tweeter" />
    </ul>
    </form>

</article>

<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>
