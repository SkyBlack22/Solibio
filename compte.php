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
        echo '<h1>Bonjour '.$user['PSEUDO'].'</h1>';
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
    if(!empty($_SESSION['ID']))
    {
        echo'<br /><h2>Espace Mon Compte</h2>';
        echo'
        <ul>
            <li><span>Pour gérer vos recettes postées :</span><a href="recettecompte.php"> cliquez ici.</a></li>
            <li><span>Pour modifier vos informations :</span><a href="modifiercompte.php"> cliquez ici.</a></li>
            <li><span>Pour vous déconnecter :</span><a href="deconnexion.php"> cliquez ici.</a></li>
        </ul>';
    } ?>
    <?php 
    if(!empty($_SESSION['ID']) AND ($_SESSION['ID'] == 33))
    {
        echo'<br /><h2>Espace Administrateur</h2>';
        echo'
        <ul>
            <li><span>Pour gérer les utilisateurs :</span><a href="admin/viewuser.php"> cliquez ici.</a></li>
            <li><span>Pour gérer les recettes postées :</span><a href="admin/deleterecette.php"> cliquez ici.</a></li>
            <li><span>Pour gérer les commentaires postés :</span><a href="admin/viewcom.php"> cliquez ici.</a></li>
        </ul>';
    }
    ?>
    
    
    <?php include 'footer.html'; ?>
</body>