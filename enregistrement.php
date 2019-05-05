
<!DOCTYPE html">
<html>
     <head><title>Enregistrement</title>
        <link rel="stylesheet" href="Lecss.css"/>
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
     </head>
     <body>
          
          
          <?php
          include 'header.php';
          
          $destin = "upload"; // changer ceci par le nom du dossier destinataire souhai
               require('database.php');
               $bdd=Database::connect();
          
               
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
                                      $idutil=$_SESSION['ID'];

                                   // Variable pour la phote uploader pour recuperer le nom etle repertoire
                                     $img = $nomup;
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
                                   //On execute la requete .
                                        $ins=$bdd->prepare("INSERT INTO recettes (nom, tpscuisson, puissancecuisson, tempsprepa, recette, commentaire, data_img, id_utilisateur) VALUES (?, ?, ?, ? ,? , ?, ? , ?)");
                                        $ins->execute(array($nom,$puissancecuisson,$tpscuisson,$tempsprepa,$recette,$commentaire,$img,$idutil));
                                        $idrecette=$bdd->lastInsertId();
                                        
                                        $myInputs = $_POST["myInputs"];
                                        foreach ($myInputs as $eachInput) 
                                        {
                                            echo $eachInput;
                                            $ins2=$bdd->prepare("INSERT INTO ingredient (libelle,id_recette) VALUES (?,?)");
                                            $ins2->execute(array($eachInput,$idrecette));
                                        }
                             
                                        echo 'Message : La Recette à bien ete enregistre !';  
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
             
         
          
          ?>
          
          
          <?php include 'footer.html'; ?>
     </body>
</html>