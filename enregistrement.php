
<!DOCTYPE html">
<html>
     <head><title>Enregistrement</title>
        <link rel="stylesheet" href="Lecss.css"/>
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
     </head>
     <body>
          
          
          <?php
          include 'header.php';
          
          $destin = "upload"; // changer ceci par le nom du dossier destinataire souhaité
              if (isset($_POST["drapeau"]))
              { 
                   echo '<h3>Envoi des fichiers ...</h3>';
              //==========================================================================================
                    for($x=0;$x<sizeof($_FILES["srcfic"]["name"]);$x++)
                    { 
                         $nomup = $_FILES['srcfic']['name'][$x];
                         if ($_FILES['srcfic']['error'][$x] >0)
                         {
                              echo 'Erreur sur le fichier :&nbsp;' . $_FILES['srcfic']['error'][$x] . "<br /><br />";
                         }
                         else
                         {
                              if (file_exists("$destin/$nomup")) // si le fichier existe déjà, renommer l'ancien
                              {
                                   $ancienfic = $nomup . microtime() . ".old" ; // certitude de n'avoir pas 2 noms pareils
                                   rename("$destin/$nomup","$destin/$ancienfic");
                                   echo "<br />Le fichier " . $nomup . " existe déjà<br />L'ancien " . $nomup . " sera renommé " . $ancienfic . "<br />";
                              }
                         $siz = round($_FILES['srcfic']['size'][$x] / 1024,2); // calcul de la taille en Ko
                         $typ = $_FILES['srcfic']['type'][$x]; // examen du type MIME
                         echo "Type&nbsp;:&nbsp;$typ<br />Taille&nbsp;:&nbsp;$siz&nbsp;Ko<br />";
                         if($siz > 2256) // si la taille du fichier est supérieure à 2256 Ko
                         {
                              echo "Fichier &quot;$nom&quot; trop volumineux pour l'upload<br /><br />";
                         }
                         else // sinon, filtrer les types MIME admis avant d'uploader
                         {
                              switch ($typ)
                              {
                                   case "image/gif":
                                   case "image/pjpeg":
                                   case "image/jpeg":
                                   case "image/x-png":
                                   case "image/png":
                                   case "image/tiff":
                                   case "image/bmp":
                              if(move_uploaded_file($_FILES['srcfic']['tmp_name'][$x],"$destin/$nomup")) // si tout s'est bien passé
                              {
                                   echo "<strong>Le fichier &quot;" . $_FILES['srcfic']['name'][$x] . "&quot; a été correctement envoyé ";
                                   echo "dans le dossier &quot;$destin/&quot;</strong><br><br />";
                                   chmod("$destin/$nomup",0777);
                              }
                              else // sinon (case restée vide, ou fichier pas passé...)
                              { 
                                   if ($nomup=="") $nomup = "Fichier_Inconnu";
                                   { 
                                        echo "Désolé, je n'ai pas pu envoyer le fichier &quot;$nom&quot; dans le dossier &quot;$destin/&quot; !<br /><br />"; 
                                   }
              }
              break;
              // par défaut: rejeter les fichiers autres qu'images
              default:echo "<br />Fichier &quot;$nom&quot; d'un type incorrect<br /><br />";break;
              } // fermeture de switch(type)
              } // fermeture de if(size>256) else...
              } // fermeture de if(error) else...
              } // fermeture de for(x=0;...)
              //==========================================================================================================
              } // fermeture de if(isset...)
              // Fin de l'upload du fichier
          
          
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