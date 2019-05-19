<?php
     require 'header.php';
     if(!empty($_GET['id'])) 
     {
               $id = checkInput($_GET['id']);#recuperation de l'ID dans l'URL
     }
    require 'database.php';
    $bdd = Database::connect();
    
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
        header("Location: deconnexion.php");#Redirection
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
    <?php
    if(!empty($_SESSION['ID']) AND $_SESSION['ID']==$id)#verification si l'utilisateur est administrateur
    {
    ?>
      <div class="container admin">
            <div class="col">
                <h1><strong>Supprimer votre compte</strong></h1>
                <br>
                <form class="form" action="" role="form" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-warning">Etes vous sur de vouloir supprimer ?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning">Oui</button>
                        <a class="btn btn-default" href="compte.php">Non</a>
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