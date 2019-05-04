<?php 
include 'header.php';
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
        <script src="js/addInput.js" language="Javascript" type="text/javascript"></script>
    </head>
  
  <body id="bodyRecette">

       

       
       
       <br/>
       <br/>
       <br/>
       <br/>
      <?php 
      if(!empty($_SESSION['ID']))
      {
      ?>
        <h1 id="Enregistrement" align="center"><strong><u>Enregistrement d'une Recette </u></strong></h1>
       <form method="post" action="enregistrement.php" enctype="multipart/form-data" name="uplo">
          <div class="Container4">

            <div class="RecetteClassLabel"  id="ClassR1">
            <label class="labelConIns2" for="nom">Nom : <input type="text" name="nom" id="nom" /></label>
            </div>
               <div class="RecetteClassLabel" id="ClassR2">
               <label  class="labelConIns2" for="puissancecuisson">Puissance de Cuisson : <input class="RecettesLabel" name="puissancecuisson" type="text" id="puissancecuisson" size="15" /></label></div>
            
            <div class="RecetteClassLabel" id="ClassR3">
            <label for="tpscuisson">Temps de Cuisson : <input name="tpscuisson" type="text" id="tpscuisson" size="15" /></label>
            </div>
            <div class="RecetteClassLabel" id="ClassR4">
            <label for="tempsprepa">Temps de Pr&eacute;paration : <input name="tempsprepa" type="text" id="tempsprepa" size="15" /></label>
            </div>
            <div class="RecetteClassLabel" id=dynamicInput>
                Ingredient 1 :<input type="text" name="myInputs[]">
            </div>
            <input type="button" value="Ajouter un nouvel ingrédient" onClick="addInput('dynamicInput');">
            <div id="DivCommentaire" align="center">
                 <br />
                 <br />
                 
                 Recette : <br />
                 
                 <textarea name="recette" cols="58" rows="7"></textarea>
                 <br />
                 <br />
                 
                 Commentaires :<br />
                 <textarea name="commentaire" cols="60" rows="5"></textarea>
                 <br />
                 <br />
                 
                 <input type="hidden" name="drapeau" id="drapeau" value="oui" />
                 Photo: <input id="ChoisirPhoto" name="srcfic[]" type="file" size="40"><br> <!-- j'ai créé un tableau de fichiers à envoyer -->
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