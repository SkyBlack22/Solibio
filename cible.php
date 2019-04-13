<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    	<title>Confirmation</title>
        <link href ="Lecss.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  </head>
  
  <body>
   		
       <?php 
                
                    include 'header.php';
					require 'database.php';
                    $bdd=Database::connect();

					if(isset($_POST['Valider']))
					{
						$Nom = htmlspecialchars($_POST['Nom']);
						$Prenom = htmlspecialchars($_POST['Prenom']);
						$Pseudo = htmlspecialchars($_POST['Pseudo']);
						$Mot_de_passe =md5($_POST['MotDePasse']);
						$adresse_mail = htmlspecialchars($_POST['Mail']);
						$date_naiss = htmlspecialchars($_POST['datenaiss']);
						

						

						$ins=$bdd->prepare("INSERT INTO utilisateur(NOM, PRENOM, PSEUDO, MAIL, MOTDEPASSE, DATENAISS) VALUES(?, ?, ?, ?, ?, ?)");
                        $ins->execute(array($Nom, $Prenom, $Pseudo, $adresse_mail,$Mot_de_passe,$date_naiss));
					}

					echo("Inscription réussie");
       ?>
    
          <?php include 'footer.html'; ?>

  </body>



</html>
