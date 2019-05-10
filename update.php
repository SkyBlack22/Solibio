<?php
    require 'header.php';
    require 'database.php';
   

    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    $recetteError= $nameError = $tpscuissonError = $puisscuissonError = $tpsprepaError = $imageError = $name = $tpscuisson = $puissancecuisson = $recetteError= $commentaire= $tpsprepa = $image = "";

    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['name']);
        $tpscuisson        = checkInput($_POST['tpscuisson']);
        $puissancecuisson   = checkInput($_POST['puissancecuisson']);
        $tpsprepa           = checkInput($_POST['tpsprepa']);
        $recette          = checkInput($_POST['recette']);
        $image              = checkInput($_FILES["image"]["name"]);
        $imagePath  = 'images/'. basename($image);
        $id_util          =$_SESSION['ID'];
        $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
        $isSuccess          = true;
       
        if(empty($name)) 
        {
            $nameError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($tpscuisson)) 
        {
            $tpscuissonError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($recette)) 
        {
            $recetteError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($puissancecuisson)) 
        {
            $puisscuissonError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        } 
        if(empty($tpsprepa)) 
        {
            $tpsprepaError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($image)) // le input file est vide, ce qui signifie que l'image n'a pas ete update
        {
            $isImageUpdated = false;
        }
        else
        {
            $isImageUpdated = true;
            $isUploadSuccess =true;
            if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .jpeg, .png, .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath)) 
            {
                $imageError = "Le fichier existe deja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) 
            {
                $imageError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) 
                {
                    $imageError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
        }
         
        if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) 
        { 
            $db = Database::connect();
            if($isImageUpdated)
            {
                $statement = $db->prepare("UPDATE recettes  set nom = ?, tpscuisson = ?, puissancecuisson = ?,  tempsprepa = ?, recette= ? , commentaire= ?, data_img = ? WHERE id = ? AND id_utilisateur= ?");
                $statement->execute(array($name,$tpscuisson,$puissancecuisson,$tpsprepa,$recette, $commentaire,$image,$id,$id_util));
                $myInputs = $_POST["ingrInputs"];
                $idingr= $_POST["prodId"];
                foreach ($myInputs as $eachInput) 
                {
                    foreach ($idingr as $myId)
                    {
                        $ins2=$db->prepare("UPDATE ingredient set libelle= ? WHERE id_recette= ? AND id_ingredient= ?");
                        $ins2->execute(array($eachInput,$id,$myId));
                    }
                    
                }
            }
            else
            {
                $statement = $db->prepare("UPDATE recettes  set nom = ?, tpscuisson = ?, puissancecuisson = ?, tempsprepa = ?, recette= ? , commentaire= ? WHERE id = ? AND id_utilisateur=?");
                $statement->execute(array($name,$tpscuisson,$puissancecuisson,$tpsprepa,$recette,$commentaire,$id,$id_util));
                $myInputs = $_POST["ingrInputs"];
                $idingr= $_POST["prodId"];
                foreach ($myInputs as $eachInput) 
                {
                    foreach ($idingr as $myId)
                    {
                        $ins2=$db->prepare("UPDATE ingredient set libelle= ? WHERE id_recette= ? AND id_ingredient= ?");
                        $ins2->execute(array($eachInput,$id,$myId));
                    }
                    
                }
            }
            Database::disconnect();
            header("Location: recettecompte.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT * FROM recettes where id = ?");
            $statement->execute(array($id));
            $item = $statement->fetch();
            $image = $item['data_img'];
            Database::disconnect();
           
        }
    }
    else 
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM recettes where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $name = $item['nom'];
        $tpscuisson = $item['tpscuisson'];
        $puissancecuisson = $item['puissancecuisson'];
        $tempsprepa = $item['tempsprepa'];
        $recette = $item['recette'];
        $commentaire=$item['commentaire'];
        $image   = $item['data_img'];
        Database::disconnect();
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

?>



<!DOCTYPE html>
<html> 
    <body>
      <div class="container admin">
            <div class="row">
                <div class="col-sm-6">
                    <h1><strong>Modifier une recette</strong></h1>
                    <br>
                    <form class="form" action="<?php echo 'update.php?id='.$id;?>" role="form" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name;?>">
                            <span class="help-inline"><?php echo $nameError;?></span>
                            </div>
                        
                        <div class="form-group">
                            <label for="description">Temps de cuisson:</label>
                            <input type="number" class="form-control" id="tpscuisson" name="tpscuisson" placeholder="Temps de cuisson" value="<?php echo $tpscuisson;?>">
                            <span class="help-inline"><?php echo $tpscuissonError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="puissancecuisson">Puissance de cuisson</label>
                            <input type="number" class="form-control" id="puissancecuisson" name="puissancecuisson" placeholder="Puissance de cuisson" value="<?php echo $puissancecuisson;?>">
                            <span class="help-inline"><?php echo $puisscuissonError;?></span>
                        </div>
                        <div class="form-group">
                            <label for="tpsprepa">Temps de préparation</label>
                            <input type="number" class="form-control" id="tpsprepa" name="tpsprepa" placeholder="Temps de préparation" value="<?php echo $puissancecuisson;?>">
                            <span class="help-inline"><?php echo $tpsprepaError;?></span>
                        </div>


                        <div class="form-group">
                            <?php
                               $bdd = Database::connect();
                               $ingredient= $bdd->prepare('SELECT * FROM ingredient WHERE id_recette= ?');
                               $ingredient->execute(array($id));
                               $instance = 1;
                               while ( $ingr = $ingredient->fetch()) 
                               {
                                ?>
                                    <input id="prodId" name="prodId[]" type="hidden" value="<?= $ingr['id_ingredient'] ?>">
                                    <label for="ingredient">Ingredient <?php echo $instance; ?>:</label>
                                    <input type="text" class="form-control" name="ingrInputs[]" placeholder="Ingredient" value="<?php echo $ingr['libelle'];?>">
                               <?php $instance++;
                               }
                               Database::disconnect();
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="recette">Recette:</label>
                            <textarea type="textarea" cols="58" rows="7" class="form-control" id="recette" name="recette" placeholder="Recette" ><?php echo $recette; ?></textarea>
                            <span class="help-inline"><?php echo $recetteError;?></span>
                            </div>
                         <div class="form-group">
                            <label for="commentaire">Commentaire:</label>
                            <textarea type="textarea" cols="58" rows="7" class="form-control" id="commentaire" name="commentaire" placeholder="Commentaire" ><?php echo $commentaire; ?></textarea>
                            </div>
                        
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <p><?php echo $image;?></p>
                            <label for="image">Sélectionner une nouvelle image:</label>
                            <input type="file" id="image" name="image"> 
                            <span class="help-inline"><?php echo $imageError;?></span>
                        </div>
                        <br>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                            <a class="btn btn-primary" href="recettecompte.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                       </div>
                    </form>
                </div>
            </div>
        </div>
        <?php  require 'footer.html'; ?>
    </body>
</html>
