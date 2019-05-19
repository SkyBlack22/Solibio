<?php
     require '../database.php';
     $bdd=Database::connect();
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);#recuperation de l'ID dans l'URL
     }
    if(!empty($_POST)) #après avoir appuyer sur le bouton
    {
        $idrecette="";
        $select=$bdd->prepare("SELECT id FROM recettes WHERE id_utilisateur= ?");#requete pour recuperer l'id des recettes postées par l'utilisateur
        $select->execute(array($id));
        while ($idrec=$select->fetch())
        {
            $idrecette=$idrec['id'];
        }
        $id= checkInput($_GET['id']);
        $delcom = $bdd->prepare("DELETE FROM commentaire WHERE id_utilisateur = ?");#suppression des commentaires de l'utilisateur
        $delcom->execute(array($id));
        $dellikes = $bdd->prepare("DELETE FROM likes WHERE id_utilisateur = ?");#suppression des likes de l'utilisateur
        $dellikes->execute(array($id));
        //$deldislikes = $bdd->prepare("DELETE FROM dislikes WHERE id_utilisateur = ?");
        //$deldislikes->execute(array($id));
        if($idrecette!="")
        {
            $delingredient = $bdd->prepare("DELETE FROM ingredient WHERE id_recette = ?");#suppression des ingredients liés aux recettes postées par  l'utilisateur
            $delingredient->execute(array($idrecette));
            $delrecettes = $bdd->prepare("DELETE FROM recettes WHERE id_utilisateur = ?");#suppression des recettes de l'utilisateur
            $delrecettes->execute(array($id));
        }
        $deluser = $bdd->prepare("DELETE FROM utilisateur WHERE ID = ?");#suppression du compte de l'utilisateur
        $deluser->execute(array($id));
        header("Location: viewuser.php");#Redirection
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<!DOCTYPE html">
<html>
<head>
        <title>AmicaleFulbert</title>
        <link href ="../Lecss.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>


    <body data-spy="scroll" data-target=".navbar" data-offset="60">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img id="logo" src="../images/logo.jpg" width="50" height="50" alt="Logo"> AmicaleFulbert</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse"  id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Accueil</a>
                    </li>

                    <?php
                    session_start();
                    if(empty($_SESSION['ID']))
                      { ?>
                          <li class="nav-item"><a class="nav-link" href="../connexion.php">Connexion</a></li>
                          <li class="nav-item"><a class="nav-link" href="../Inscription.php">Inscription</a></li>
                    <?php } ?>
                    <?php 
                    if(!empty($_SESSION['ID']))
                      { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="../compte.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon Compte</a>
                        <!-- bloc menu déroulant -->
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../modifiercompte.php">Modifier Compte</a>
                            <a class="dropdown-item" href="../recettecompte.php">Vos recettes</a>
                            <a class="dropdown-item" href="../compte.php">Mon Compte</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../deconnexion.php">Se déconnecter</a>
                        </div>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../Contact.php">Contact</a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
    <?php
    if(!empty($_SESSION['ID']) AND $_SESSION['admin']==1)#verification si l'utilisateur est administrateur
    {
    ?>
      <div class="container admin">
            <div class="col">
                <h1><strong>Supprimer cet utilisateur</strong></h1>
                <br>
                <form class="form-group" action="" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a class="btn btn-default" href="viewuser.php">Non</a>
                    </div> 
                </form>
            </div>
        </div>
    <?php 
    }
    else
    {
        echo'<div class="alert alert-warning">
  <strong>Attention</strong> Vous n\'êtes pas administrateur.
</div>';
    }
    ?>
       <?php include '../footer.html'; ?>
  </body>
</html>