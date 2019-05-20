<?php
     include 'header.php';
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);
     }
    require('database.php');
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
        $statement = $bdd->prepare("DELETE FROM recettes WHERE id = ? AND id_utilisateur= ?");
        $statement->execute(array($id, $_SESSION['ID']));
        header("Location: recettecompte.php"); 
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
  
  <body>
  	
       
       <div class="container admin">
            <div class="col">
                <h1><strong>Supprimer la recette</strong></h1>
                <br>
                <form class="form" action="deletecompte.php" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a class="btn btn-default" href="recettecompte.php">Non</a>
                    </div>
                </form>
            </div>
        </div> 
      
       <?php include 'footer.html'; ?>
  </body>
