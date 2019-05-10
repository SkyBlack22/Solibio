<?php
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);
     }
    require '../database.php';
    $bdd = Database::connect();
    if(!empty($_POST)) 
    {
        
        $id= checkInput($_GET['id']);
        $delcom = $bdd->prepare("DELETE FROM commentaire WHERE id = ?");
        $delcom->execute(array($id));
        header("Location: viewcom.php"); 
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
    <title>Suppression commentaire</title>
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
    <?php
    if(!empty($_SESSION['ID']) AND $_SESSION['ID']==33)
    {
    ?>
       <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer le commentaire</strong></h1>
                <br>
                <form class="form" action="" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                         <button type="submit" class="btn btn-warning">Oui</button>
                         <a class="btn btn-default" href="viewcom.php">Non</a>
                    </div>
                </form>
            </div>
        </div> 
    <?php 
    }
    else
    {
        echo'Vous n\'êtes pas administrateur';
    }
    ?>
       <?php include '../footer.html'; ?>
  </body>
</html>