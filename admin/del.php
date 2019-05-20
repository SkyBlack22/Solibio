<?php
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);
     }
    require('../database.php');
    $bdd=Database::connect();
    if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        $statement5 = $bdd->prepare("DELETE FROM commentaire WHERE id_recette = ?");
        $statement5->execute(array($id));
        $statement3 = $bdd->prepare("DELETE FROM likes WHERE id_recette = ?");
        $statement3->execute(array($id));
        $statement4 = $bdd->prepare("DELETE FROM dislikes WHERE id_recette = ?");
        $statement4->execute(array($id));
        $delingredient = $bdd->prepare("DELETE FROM ingredient WHERE id_recette = ?");
        $delingredient->execute(array($id));
        $statement = $bdd->prepare("DELETE FROM recettes WHERE id = ?");
        $statement->execute(array($id));
        header("Location: deleterecette.php"); 
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
          <div class="container">
            <br/>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    <form class="card card-sm" method="get">
                        <div class="card-body row no-gutters align-items-center">
                            <div class="col-auto">
                                <i class="fas fa-search h4 text-body"></i>
                            </div>
                            <!--end of col-->
                            <div class="col">
                                <input class="form-control form-control-lg form-control-borderless" type="search" name="q" placeholder="Rechercher une recette">
                            </div>
                            <!--end of col-->
                            <div class="col-auto">
                                <button class="btn btn-lg btn-success" type="submit">Search</button>
                            </div>
                            <!--end of col-->
                        </div>
                    </form>
                </div>            <!--end of col-->
            </div>
        </div>
       <div class="container admin">
            <div class="col">
                <h1><strong>Supprimer la recette</strong></h1>
                <br>
                <form class="form" action="del.php" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a class="btn btn-default" href="deleterecette.php">Non</a>
                    </div>
                </form>
            </div>
        </div> 
      
       <?php include '../footer.html'; ?>
  </body>
