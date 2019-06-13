<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Twitter</title>
    <link rel="stylesheet"  href="./view/css/styleRecherche.css">
</head>

<body>

<!--menu-->

<?php include("menu.php"); ?>

<h4><?php echo htmlspecialchars($_POST['recherche']);?></h4>

<!-- liste des personnes correspondantes aux caractères de la recherche-->


 <?php foreach ($params['users'] as $user) : ?>
<li>
     <a href="traitementSuivre.php/<?php echo $user->getId() ?>">  <h5>Suivre</h5> </a>
    <h6><?php echo $user->getPseudo(); ?></h6>
    <h7>@<?php echo $user->getUserName(); ?></h7>
    <h8><?php echo $user->getInfoPerso(); ?></h8>
</li>
<?php endforeach; ?>

<!-- Le pied de page -->

<?php include("pied_de_page.php"); ?>

</body>
</html>