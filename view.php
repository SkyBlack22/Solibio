<?php
include 'header.php';
require('database.php');
if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }
     
    $bdd = Database::connect();
    $statement = $bdd->prepare("SELECT id, nom, recette, tpscuisson, tempsprepa ,data_img FROM recettes  WHERE id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $statement2=$bdd->prepare("SELECT libelle FROM ingredient WHERE id_recette= ?");
    $statement2->execute(array($id));
    
    
    
    


    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    $likes=$bdd->prepare('SELECT id FROM likes WHERE id_recette = ?');
    $likes->execute(array($id));
    $likes= $likes->rowCount();
    $dislikes=$bdd->prepare('SELECT id FROM dislikes WHERE id_recette = ?');
    $dislikes->execute(array($id));
    $dislikes= $dislikes->rowCount();

    
    
    if(isset($_POST['submitcommentaire']))
    {
        if(isset($_SESSION['ID']) AND !empty($_SESSION['ID']))
        {
           $sessionid= $_SESSION['ID'];
           if(isset($_POST['commentaire'])  AND !empty($_POST['commentaire']))
            {
                $commentaire=htmlspecialchars($_POST['commentaire']);
                 $ins= $bdd->prepare('INSERT INTO commentaire(id_recette, id_utilisateur, contenu, date_post) VALUES (?, ?, ?,NOW())');
                 $ins->execute(array($id,$sessionid,$commentaire));
                 $c_msg="Votre commentaire a bien été posté ";

            }
            else
            {
                $c_msg="Erreur: Tous les champs doivent être complétés";
            } 
        }
        else
        {
            $c_msg="Erreur: Vous devez être connecté pour poster un commentaire";
        }
    }
    
$commentaires= $bdd->prepare('SELECT utilisateur.PSEUDO,contenu, commentaire.id, commentaire.date_post FROM commentaire, utilisateur WHERE utilisateur.ID=commentaire.id_utilisateur AND id_recette= ?  ORDER BY id DESC');
$commentaires->execute(array($id));
    
        
    
    
?>
<!DOCTYPE html>
<html>
    <head>
        <link href ="Lecss.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
  
  <body>
   		
      <a href="like.php?t=1&id=<?= $id ?>">J'aime</a>(<?= $likes ?>)
        <br/>
        <a href="like.php?t=2&id=<?= $id ?>">J'aime pas</a>(<?= $dislikes ?>)
        <br/>
       
        <div class="container admin">
            <div class="row">
               <div class="col-sm-6">
                    <h1><strong><?php echo $item['nom'];?></strong></h1>
                    <br>
                    <form>
                      <div class="form-group">
                        <label>Nom:</label><?php echo '  '.$item['nom'];?>
                      </div>
                      <div class="form-group">
                        <label>Ingredients:</label><?php echo '  ';while($ingr = $statement2->fetch()) { echo $ingr['libelle']; echo'; '; } ?>
                      </div>
                      <div class="form-group">
                        <label>Recette:</label><?php echo '  '.$item['recette'];?>
                      </div>
                      <div class="form-group">
                        <label>Temps de Préparation:</label><?php echo '  '.$item['tempsprepa'];?>
                      </div>
                      <div class="form-group">
                        <label>Temps de cuisson:</label><?php echo '  '.$item['tpscuisson'];?>
                      </div>
                      <div class="form-group">
                        <label>Image:</label><img src="<?php echo 'upload/'.$item['data_img'];?>" alt="...">
                      </div>
                    </form>
                    <br>
                    <div class="form-actions">
                      <a class="btn btn-primary" href="lecture.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </div> 
                
            </div>
       </div>
       
       
      
      <h2>Commentaire</h2>
      <form method="POST">
        <textarea name="commentaire" placeholder="Votre commentaire..."></textarea>
        <input type="submit" value="Poster" name="submitcommentaire">
      </form>
              
    <?php if(isset($c_msg)) { echo $c_msg;}?>
    <br />
    
    <?php while($c = $commentaires->fetch()) { ?>
        <b><?= $c['PSEUDO'] ?>:</b> <?= $c['contenu'] ?> <?= $c['date_post'] ?> <br/>
    
<?php } ?>
       <?php include 'footer.html'; ?>
  </body>
</html>