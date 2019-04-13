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
					$bdd = new PDO('mysql:host=127.0.0.1;dbname=projet2', 'root', '');

					if(isset($_POST['Valider']))
					{
						$Nom = htmlspecialchars($_POST['Nom']);
						$Prenom = htmlspecialchars($_POST['Prenom']);
						$Pseudo = htmlspecialchars($_POST['Pseudo']);
						$Mot_de_passe =md5($_POST['MotDePasse']);
						$adresse_mail = htmlspecialchars($_POST['Mail']);
						$date_naiss = htmlspecialchars($_POST['datenaiss']);
						

						

						$bdd->exec("INSERT INTO utilisateur(NOM, PRENOM, PSEUDO, MAIL, MOTDEPASSE, DATENAISS) VALUES('".$Nom."','".$Prenom."','".$Pseudo."','".$adresse_mail."','".$Mot_de_passe."', DATE('".$date_naiss."'))");
					}

					echo("Inscription réussie");
       ?>
    
          <footer>
          <p>YOOOOOOOOOOOOOOOO</p>
          </footer>

  </body>



</html>
