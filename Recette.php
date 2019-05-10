<?php 
    include 'header.php';
    require('database.php');
               $bdd=Database::connect();
          
               $nom=$puissancecuisson=$tpscuisson=$tempsprepa=$recette=$commentaire=$nameError=$recetteError=$tpsprepError=$imageError="";
               if(!empty($_SESSION['ID']))
               {
                  if (isset($_POST['inscription']))
                  {
                         //Si les variables contenant les informations obligatoires et qu'elles ne sont pas vides:
                         if (isset($_POST['nom'], $_POST['tpscuisson'], $_POST['tempsprepa'], $_POST['recette']) && !empty($_POST['nom']) &&  !empty($_POST['tpscuisson']) && !empty($_POST['tempsprepa']) && !empty($_POST['recette']))
                             {

                                      $nom = htmlspecialchars($_POST['nom']);
                                      $puissancecuisson = htmlspecialchars($_POST['puissancecuisson']);
                                      $tpscuisson = htmlspecialchars($_POST['tpscuisson']);
                                      $tempsprepa = htmlspecialchars($_POST['tempsprepa']);
                                      $recette = stripslashes(nl2br($_POST['recette']));
                                      $commentaire = stripslashes(nl2br($_POST['commentaire']));
                                      $image  = checkInput($_FILES["image"]["name"]);
                                      $imagePath  = 'images/'. basename($image);
                                      $imageExtension = pathinfo($imagePath,PATHINFO_EXTENSION);
                                      $idutil=$_SESSION['ID'];
                                      $isUploadSuccess= false;
                                      $isSuccess = true;
                             

                                    if(empty($nom)) 
                                    {
                                        $nameError = 'Ce champ ne peut pas Ãªtre vide';
                                        $isSuccess = false;
                                    }
                                    if(empty($recette)) 
                                    {
                                        $recetteError = 'Ce champ ne peut pas Ãªtre vide';
                                        $isSuccess = false;
                                    } 
                                    if(empty($tempsprepa)) 
                                    {
                                        $tpsprepError = 'Ce champ ne peut pas Ãªtre vide';
                                        $isSuccess = false;
                                    } 

                                    if(empty($image)) 
                                    {
                                        $imageError = 'Ce champ ne peut pas être vide';
                                        $isSuccess = false;
                                    }
                                    else
                                    {
                                        $isUploadSuccess = true;
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
                                   //On execute la requete 
                                    if($isUploadSuccess && $isSuccess)
                                    {
                                        $ins=$bdd->prepare("INSERT INTO recettes (nom, tpscuisson, puissancecuisson, tempsprepa, recette, commentaire, data_img, id_utilisateur) VALUES (?, ?, ?, ? ,? , ?, ? , ?)");
                                        $ins->execute(array($nom,$puissancecuisson,$tpscuisson,$tempsprepa,$recette,$commentaire,$image,$idutil));
                                        $idrecette=$bdd->lastInsertId();
                                        
                                        $myInputs = $_POST["myInputs"];
                                        foreach ($myInputs as $eachInput) 
                                        {
                                            $ins2=$bdd->prepare("INSERT INTO ingredient (libelle,id_recette) VALUES (?,?)");
                                            $ins2->execute(array($eachInput,$idrecette));
                                        }
                             
                                        echo 'Message : La Recette à bien ete enregistre !';  
                                    }
                             }

                         else
                         {
                                   echo 'Erreur : Tu n\'as pas rempli les informations minimum( Nom, Type, Ingredient 1, Ingredient 2, Temps de cuisson, Temps de Préparation et Recette)';
                         }



                  }
               }
               else
               {
                   echo 'Vous devez vous connecter pour pouvoir ajouter une recette';
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
       <br/>
       <br/>
       <br/>
       <br/>
    <body>
      <?php 
      if(!empty($_SESSION['ID']))
      {
      ?>
        <h1 id="Enregistrement" align="center"><strong><u>Enregistrement d'une Recette </u></strong></h1>
       <form method="post" action="" enctype="multipart/form-data" name="uplo">
          <div class="Container4">

            <div class="RecetteClassLabel"  id="ClassR1">
            <label class="labelConIns2" for="nom">Nom : <input type="text" name="nom" id="nom" value="<?php echo $nom;?>"/></label>
            </div>
               <div class="RecetteClassLabel" id="ClassR2">
               <label  class="labelConIns2" for="puissancecuisson">Puissance de Cuisson : <input class="RecettesLabel" name="puissancecuisson" type="text" id="puissancecuisson" size="15" value="<?php echo $puissancecuisson;?>" /></label></div>
            
            <div class="RecetteClassLabel" id="ClassR3">
            <label for="tpscuisson">Temps de Cuisson : <input name="tpscuisson" type="text" id="tpscuisson" size="15" value="<?php echo $tpscuisson;?>" /></label>
            </div>
            <div class="RecetteClassLabel" id="ClassR4">
            <label for="tempsprepa">Temps de Pr&eacute;paration : <input name="tempsprepa" type="text" id="tempsprepa" size="15" value="<?php echo $tempsprepa;?>"/></label>
            </div>
            <div class="conteneur">
                <div class="RecetteClassLabel" id=dynamicInput>
                    Ingredient 1 :<input type="text" name="myInputs[]">
                </div>
            </div>
            <input type="button" value="Ajouter un nouvel ingrédient" onClick="addInput('conteneur');">
            <input type="button" value="Enlever un nouvel ingrédient" onClick="delInput('conteneur');">
            <div id="DivCommentaire" align="center">
                 <br />
                 <br />
                 
                 Recette : <br />
                 
                 <textarea name="recette" cols="58" rows="7" ><?php echo $recette;?></textarea>
                 <br />
                 <br />
                 
                 Commentaires :<br />
                 <textarea name="commentaire" cols="60" rows="5" ><?php echo $commentaire;?></textarea>
                 <br />
                 <br />
                 
                 <div class="form-group">
                        <label for="image">Sélectionner une image:</label>
                        <input type="file" id="image" name="image"> 
                        <span class="help-inline"><?php echo $imageError;?></span>
                </div> 
                 <input id="Enregistrer" class="Valider" type="submit" name="inscription" value="Enregistrer" />
            </div>
          </div>
        </form>;
      <?php }
      else 
      {
          echo'Vous devez être connecté pour ajouter une recette';
          echo '<div class="form-actions">
                         <a class="btn btn-primary" href="lecture.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                         </div>';
      }
      ?>
       
       
      <?php include 'footer.html'; ?>
  </body>
</html>