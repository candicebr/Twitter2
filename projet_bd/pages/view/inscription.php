<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./view/css/styleInscription.css">
</head>

<body>


    <h1>Créer votre compte</h1>
    <form method="post" action="traitement.php">
        <ul class="form-style-1">
     <p>
    <input type="text" name="pseudo" id="pseudo" class="field-divided" placeholder="pseudo" size="30" maxlength="50" />
     </p>
     <p>
    <input type="text" name="user_name" id="user_name" class="field-divided" placeholder="@nom d'utilisateur" size="30"/>
     </p>
        <?php if(isset($_SESSION['flashInscription'])) {
            echo "
           <p style='color: red'>
            " . $_SESSION['flashInscription'] . " 
           </p>
        ";
        }
        ?>
        <p>
            <input type="password" name="password" id="password" class="field-divided" placeholder="password" size="30" maxlength="50" />
        </p>
     <p>
         <label for="birth">Votre date de naissance<br/></label>
        <input type="date" name="birth" id="birth" class="field-divided" placeholder="birth"/>
     </p>
        <input type="submit" value="s'inscrire" />
        </ul>
    </form>

<img src="./view/img/twitter_bird.png" HEIGHT="700">
<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>
