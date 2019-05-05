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
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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