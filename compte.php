<?php
    include 'header.php';
    require('database.php');
    include_once('cookie.php');
    $bdd=Database::connect();
    if(!empty($_SESSION['ID']))
    {
        
        $requser=$bdd->prepare("SELECT * FROM utilisateur WHERE ID= ?");
        $requser->execute(array($_SESSION['ID']));
        $user = $requser->fetch();
        echo 'Bonjour '.$user['PSEUDO'];
    }
    else
    {
        echo 'Vous devez être connecté';
    }
    
?>

<!DOCTYPE html">
<html>
     <head><title>Mon Compte</title>
        <link href ="Lecss.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
     </head>
<body>
    <?php 
    if(!empty($_SESSION['ID']) AND ($_SESSION['ID'] == 33))
    {
        echo'<ul>
        <li id="boutondeco" class="decolink"><a href="admin/viewuser.php">Gestion Utilisateurs</a></li>
        <li id="boutondeco" class="decolink"><a href="admin/deleterecette.php">Gestion Recettes</a></li>
        <li id="boutondeco" class="decolink"><a href="admin/viewcom.php">Gestion Commmentaires</a></li>';
    }
    ?>
    <?php
    if(!empty($_SESSION['ID']))
    {
        echo'<ul>
        <li id="boutonmodif" class="modiflink"><a  href="recettecompte.php">Afficher recette</a></li>
        <li id="boutonmodif" class="modiflink"><a  href="modifiercompte.php">Modifier votre compte</a></li>
        <li id="boutondeco"  class="decolink"><a href="deconnexion.php">Se déconnecter</a></li>
        </ul>';
    } ?>
    
    
    <?php include 'footer.html'; ?>
</body>