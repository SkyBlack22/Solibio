<?php
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);
     }
    require '../database.php';
    $bdd = Database::connect();
    $select=$bdd->prepare("SELECT id FROM recettes WHERE id_utilisateur= ?");
    $select->execute(array($id));
    while ($idrec=$select->fetch())
    {
        $idrecette=$idrec['id'];
    }
    if(!empty($_POST)) 
    {
        
        $id= checkInput($_GET['id']);
        $delcom = $bdd->prepare("DELETE FROM commentaire WHERE id_utilisateur = ?");
        $delcom->execute(array($id));
        $dellikes = $bdd->prepare("DELETE FROM likes WHERE id_utilisateur = ?");
        $dellikes->execute(array($id));
        //$deldislikes = $bdd->prepare("DELETE FROM dislikes WHERE id_utilisateur = ?");
        //$deldislikes->execute(array($id));
        $delingredient = $bdd->prepare("DELETE FROM ingredient WHERE id_recette = ?");
        $delingredient->execute(array($idrecette));
        $delrecettes = $bdd->prepare("DELETE FROM recettes WHERE id_utilisateur = ?");
        $delrecettes->execute(array($id));
        $deluser = $bdd->prepare("DELETE FROM utilisateur WHERE ID = ?");
        $deluser->execute(array($id));
        header("Location: viewuser.php"); 
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
    <meta charset="utf-8"/>
    <title>Suppression utilisateur</title>
    <link href ="../Lecss.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  
  <body>
  	<header>
           <div class="container">
               <h1>Solibio<span class="orange">.</span></h1>
               <nav>
                  <ul>
                    <?php 
                      session_start();
                      if(!empty($_SESSION['ID']))
                      {
                        echo '<li><a href="../deconnexion.php">Déconnexion</a></li>';
                        echo '<li><a href="../compte.php">Mon Compte</a></li>';
                      }
                    ?>
                    <?php 
                      if(empty($_SESSION['ID']))
                      {
                          echo '<li><a href="../connexion.php">Connexion</a></li>';
                          echo'<li><a href="../Inscription.php">Inscription</a></li>';
                      }
                      ?>
                    <li><a href="../index.php">Accueil</a></li>
                   
                  </ul>
               </nav>
            </div>
      </header> 
      <div class="container admin">
            <div class="col">
                <h1><strong>Supprimer un item</strong></h1>
                <br>
                <form class="form" action="" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                        <div class="row">
                            <button type="submit" class="btn btn-warning">Oui</button>
                        </div>
                        <div class="row">
                            <a class="btn btn-default" href="viewuser.php">Non</a>
                        </div> 
                    </div>
                </form>
            </div>
        </div> 
       <?php include '../footer.html'; ?>
  </body>
</html>