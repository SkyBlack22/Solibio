<?php
    require 'header.php';
    require 'database.php';
    $bdd=Database::connect();
    if(!empty($_GET['id'])) 
    {
        $id =$_GET['id'];
    }
    $commentaires= $bdd->prepare('SELECT contenu, commentaire.id, commentaire.date_post, commentaire.id_utilisateur FROM commentaire WHERE  id= ?  ORDER BY id DESC');
    $commentaires->execute(array($id));

     if(!empty($_POST)) 
     {
         $contenu=$_POST['contenu'];
         $statement=$bdd->prepare('UPDATE commentaire SET contenu = ? WHERE commentaire.id = ?');
         $statement->execute(array($contenu,$id));
         header("Location: lecture.php");
     }




?>

<html>
    <body>
        <?php while($c = $commentaires->fetch()) { ?>
        <div class="container admin">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="media">
                    <div class="media-left">
                        <img class="align-self-start mr-3 mt-3 rounded-circle" style="width:60px;" src="images/img_avatar.png"  alt="Avatar">
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0"> <small><i> Posté le <?= $c['date_post'] ?>
                            </i></small></h6>
                        <input type="text" name="contenu" value="<?= $c['contenu'] ?>">
                        <button type="submit" class="btn btn-success" value="Valider" id="Valider" name="Valider">Valider</button>
                    </div>
                 </div>
            </form>
        </div>
        
    <?php } ?>
    </body>

</html>
<?php include 'footer.html'; ?>