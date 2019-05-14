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
        echo'<div class="alert alert-warning">
  <strong>Attention</strong> Vous devez être connecté pour consulter cette page.
</div>';
    }
    
?>

<!DOCTYPE html">
<html>
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