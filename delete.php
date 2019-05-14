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
