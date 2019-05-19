<script>
function goBack() {
    window.history.back();
}
</script>
<?php
    include'header.php';
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);
     }
    require 'database.php';
    $bdd = Database::connect();
    if(!empty($_POST)) 
    {
        
        $id= checkInput($_GET['id']);
        $delcom = $bdd->prepare("DELETE FROM commentaire WHERE id = ?");
        $delcom->execute(array($id));
        header('Location: lecture.php');
        
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

?>

<html>
    <body>
        <?php
        if(!empty($_SESSION['ID']))
        {
        ?>
           <div class="container admin">
                <div class="col">
                    <h1><strong>Supprimer le commentaire</strong></h1>
                    <br>
                    <form class="form" action="" role="form" method="post">
                        <input type="hidden" name="id" value="<?php echo $id;?>"/>
                        <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                        <div class="form-actions">
                             <button type="submit" class="btn btn-warning">Oui</button>
                             <a class="btn btn-default" onclick="goBack();">Non</a>
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
           <?php include 'footer.html'; ?>
  </body>
</html>