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
    $ingredient = $statement2->fetch();
    
    


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
    <meta charset="utf-8"/>
    	<title>Les Recettes</title>
    	<link rel="stylesheet" href="Lecss.css"/>
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  
  <body>
   		
       
        <div class="container admin">
            <div class="row">
               <div class="col-sm-6">
                    <h1><strong>Voir une recette</strong></h1>
                    <br>
                    <form>
                      <div class="form-group">
                        <label>Nom:</label><?php echo '  '.$item['nom'];?>
                      </div>
                      <div class="form-group">
                        <label>Ingredients:</label><?php echo '  '.$ingredient['libelle'];?>
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
                        <label>Image:</label><?php echo '  '.$item['data_img'];?>
                      </div>
                    </form>
                    <br>
                    <div class="form-actions">
                      <a class="btn btn-primary" href="lecture.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                    </div>
                </div> 
                
            </div>
       </div>
       
       <a href="like.php?t=1&id=<?= $id ?>">J'aime</a>(<?= $likes ?>)
        <br/>
        <a href="like.php?t=2&id=<?= $id ?>">J'aime pas</a>(<?= $dislikes ?>)
        <br/>
      
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