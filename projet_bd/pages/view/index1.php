<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./view/css/style.css">
</head>

<body>

    <form method="post" action="traitementConnection.php">
        <ul class="form-style-1">
            <p>
            <input type="text" name="user_name" id="user_name" class="field-divided" placeholder="Nom d'utilisateur" size="30" maxlength="10" />
            <input type="password" name="password" id="password" class="field-divided" placeholder="Mot de passe" size="30"/>
            <input type="submit" value="Se Connecter" />
            </p>
        </ul>
    </form>
    <div class="flash">
    <?php if(isset($_SESSION['flash'])) {
        echo "
           <p style='color: red'>
            " . $_SESSION['flash'] . " 
           </p>
        ";
    }
     ?>
    </div>

    <img src="./view/img/twitter_bird.png" HEIGHT="700">

    <h1>Découvrez ce qui se passe dans le monde en temps réel.</h1>

    <h2>Rejoignez Twitter aujourd'hui.</h2>

    <a href="inscription.php"><h3>S'inscrire</h3></a>


<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>