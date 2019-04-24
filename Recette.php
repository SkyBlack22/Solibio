<?php 
include 'header.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Les recettes</title>
    <link href ="Lecss.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
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
                 
                 <textarea name="recette" cols="70" rows="10"></textarea>
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
      }
      ?>
       
       
      <?php include 'footer.html'; ?>
  </body>
</html>