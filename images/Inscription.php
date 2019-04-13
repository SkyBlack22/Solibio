<!DOCTYPE html">
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Les recettes</title>
    <link rel="stylesheet" href="Lecss.css"/>
  </head>
  
  <body>
  	<nav id="menu">
     	<ul>
        	<li><a href="PageAccueil.php">Accueil</a></li>
        	<li><a href="Contact.php">Contact</a></li>
        	<li><a href="Recette.php">Les recettes</a></li>
          <li><a href="Inscription.php">Inscription</a></li>
    	</ul>
	</nav>
  

    <form action="cible.php" method="post" enctype="multipart/form-data">
        
        <p>
          <label for="prenom">Prénom:</label>
          <input type="text" name="Prenom" id="Prenom" placeholder="Entrez votre prénom"/><br/>

          <label for="nom">Nom:</label>
          <input type="text" name="Nom" id="Nom" placeholder="Entrez votre nom"/><br/>

          <label for="pseudo">Pseudo:</label>
          <input type="text" name="Pseudo" id="Pseudo" placeholder="Entrez un pseudo"/><br/>

          <label for="mail">E-Mail:</label>
          <input type="text" name="Mail" id="Mail" placeholder="Entrez un e-mail"/><br/>

         

          <label for="mail">Mot de passe:</label>
          <input type="password" name="MotDePasse" id="MotDePasse" placeholder="Entrez un mot de passe"/><br/>

          <input type="submit" value="Valider" id="valider" name="Valider"/>
          

        </p>
      
    </form>
       
       

  </body>



</html>