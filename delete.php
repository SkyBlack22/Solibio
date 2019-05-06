<?php
     include 'header.php';
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);
     }
    require 'database.php';
    $bdd = Database::connect();
    if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
        $statement2 = $bdd->prepare("DELETE FROM ingredient WHERE id_recette = ?");
        $statement2->execute(array($id));
        $statement = $bdd->prepare("DELETE FROM recettes WHERE id = ?");
        $statement->execute(array($id));
        $statement3 = $bdd->prepare("DELETE FROM likes WHERE id_recette = ?");
        $statement3->execute(array($id));
        $statement4 = $bdd->prepare("DELETE FROM dislikes WHERE id_recette = ?");
        $statement4->execute(array($id));
        header("Location: admin/deleterecette.php"); 
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
    <title>Les recettes</title>
    <link href ="Lecss.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  
  <body> 
      <div class="container admin">
            <div class="col">
                <h1><strong>Supprimer la recette</strong></h1>
                <br>
                <form class="form" action="" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                        <div class="row">
                            <button type="submit" class="btn btn-warning">Oui</button>
                        </div>
                        <div class="row">
                            <a class="btn btn-default" href="admin/deleterecette.php">Non</a>
                        </div> 
                    </div>
                </form>
            </div>
        </div> 
       <?php include 'footer.html'; ?>
  </body>
