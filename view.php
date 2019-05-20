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
    
$commentaires= $bdd->prepare('SELECT utilisateur.PSEUDO,contenu, commentaire.id, commentaire.date_post, commentaire.id_utilisateur FROM commentaire, utilisateur WHERE utilisateur.ID=commentaire.id_utilisateur AND id_recette= ?  ORDER BY id DESC');
$commentaires->execute(array($id));
    
        
    
    
?>
<!DOCTYPE html>
<html>
	<body>
		<div class="container">
			<div class="row">
				<br />
				<a href="like.php?t=1&id=<?= $id ?>" class="btn btn-success" role="button"><i class="fas fa-thumbs-up"></i></a>
				(
				<?= $likes ?>
				)
				<br/>
				<a href="like.php?t=2&id=<?= $id ?>" class="btn btn-danger" role="button"><i class="fas fa-thumbs-down"></i></a>
				(
				<?= $dislikes ?>
				)
				<br/>
			</div>
		</div>
		<div class="container admin">
			<div class="row">
				<div class="col-sm-6">
					<h1><strong><?php echo $item['nom'];?></strong></h1>
					<br>
					<form>
						<div class="form-group">
							<label>Nom:</label>
							<?php echo '  '.$item['nom'];?>
						</div>
						<div class="form-group">
							<label>Ingredients:</label>
							<?php 
                                echo '  ';
                                while($ingr = $statement2->fetch()) 
                                { 
                                    echo '<li>'.$ingr['libelle'].'</li>'; 
                                } 
                            ?>  
						</div>
						<div class="form-group">
							<label>Recette:</label>
							<?php echo '  '.$item['recette'];?>
						</div>
						<div class="form-group">
							<label>Temps de Préparation:</label>
							<?php echo '  '.$item['tempsprepa'];?>
							<label> mn</label>
						</div>
						<div class="form-group">
							<label>Temps de cuisson:</label>
							<?php echo '  '.$item['tpscuisson'];?>
							<label> mn</label>
						</div>
					</form>
					<br>
				</div>
				<div class="col-sm-6 site">
					<div class="thumbnail">
						<img src="<?php echo 'images/'.$item['data_img'];?>" alt="...">
						<div class="caption">
							<h4><?php echo $item['nom'];?></h4>
							<p>
								<?php echo $item['tempsprepa'];?>
							</p>
						</div>
					</div>
				</div>
				<div class="form-actions">
					<a class="btn btn-primary" href="lecture.php"><i class="fas fa-undo"></i> Retour</a>
				</div>
			</div>
		</div>
		<h2>Commentaire</h2>
		<form method="POST">
			<textarea name="commentaire" placeholder="Votre commentaire..."></textarea>
			<input type="submit" value="Poster" name="submitcommentaire">
		</form>
		<?php while($c = $commentaires->
		fetch()) { ?>
		<ul class="list-unstyled">
			<li class="media border p-3">
				<div class="media-left">
					<img src="images/img_avatar.png"  alt="Avatar" class="align-self-start mr-3 mt-3 rounded-circle" style="width:60px;">
				</div>
				<div class="media-body">
					<h4 class="mt-0">
						<?= $c['PSEUDO'] ?>
						<small>
							<i> Posté le <?= $c['date_post'] ?>
                                <?php 
                                    if(isset($_SESSION['ID']) AND $_SESSION['ID']== $c['id_utilisateur'])
                                    {
                                        echo '<a href="updatecom.php?id='.$c['id'].'"><button class="btn btn-lg btn-success" type="submit"><i class="fa fa-pen"></i></button></a>';
                                        echo '<a href="delcom.php?id='.$c['id'].'"><button class="btn btn-lg btn-danger" type="submit"><i class="fa fa-trash"></i></button></a>';
                                    }
                                ?>
                            </i>
                        </small>
						</h4>
						<?= $c['contenu'] ?>
					</div>
				</li>
			</ul>
			<?php } ?>
			<?php include 'footer.html'; ?>
		</body>
	</html>