<?php
     include 'header.php';
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);
     }
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=projet2', 'root', '');
    include_once('cookie.php');
    if(!empty($_POST)) 
    {
        $id = checkInput($_POST['id']);
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
  <head>
    <meta charset="utf-8"/>
    <title>Les recettes</title>
    <link href ="Lecss.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  
  <body>
  	
       
       <div class="container admin">
            <div class="row">
                <h1><strong>Supprimer un item</strong></h1>
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
