<!DOCTYPE html">
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Les recettes</title>
    <link href ="Lecss.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
  </head>
  
  <body>
  	<?php include 'header.php'; ?>

  

    <form action="cible.php" method="post" enctype="multipart/form-data">
         <div class="container3">
              <img id="ImageInscription" src="images/inscription.png" alt="ImageInscription"/>
              <div class="FofoInscription">
                    <label class="labelConIns" for="prenom">Prénom:</label>
                    <input type="text" name="Prenom" id="Prenom" placeholder="Entrez votre prénom" required/><br/>
              </div>
              <div class="FofoInscription">
                    <label class="labelConIns" for="nom">Nom:</label>
                    <input type="text" name="Nom" id="Nom" placeholder="Entrez votre nom" required/><br/>
              </div>
              <div class="FofoInscription">
                    <label  class="labelConIns" for="pseudo">Pseudo:</label>
                    <input type="text" name="Pseudo" id="Pseudo" placeholder="Entrez un pseudo" required/><br/>
              </div>
              <div class="FofoInscription">
                    <label  class="labelConIns" for="mail">E-Mail:</label>
                    <input type="text" name="Mail" id="Mail" placeholder="Entrez un e-mail" required/><br/>
              </div>
              <div class="FofoInscription1">
                    <label  class="labelConIns" for="datenaiss">Date de naissance:</label>
                    <input type="date" name="datenaiss" id="datenaiss" placeholder="Entrez votre date de naissance" required/><br/>
              </div>
              <div class="FofoInscription1">
                    <label  class="labelConIns" for="mail">Mot de passe:</label>
                    <input type="password" name="MotDePasse" id="MotDePasse" placeholder="Entrez un mot de passe" required/><br/>
              </div>
              <div id="TextBox3">
                    <button type="submit" value="Valider" id="Valider" class="Valider" name="Valider">M'inscrire</button>
              </div>
        </div>
    </form>

    
       
    <?php include 'footer.html'; ?>

  </body>



</html>