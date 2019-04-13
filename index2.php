<?php
      
     include 'header.php';
     require('database.php');
     $bdd=Database::connect();
     if(!empty($_SESSION['ID']))
     {
        
        $requser=$bdd->prepare("SELECT * FROM utilisateur WHERE ID= ?");
        $requser->execute(array($_SESSION['ID']));
        $user = $requser->fetch();
     }
     if ($_SESSION['pseudo']=$user['PSEUDO']) 
     {
           
         echo "Vous êtes connecté" ; 
           
     }
     else
     {
          echo " you must be logged in" ; 
     }
 
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    	<title>Confirmation</title>
    	<link href ="Lecss.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
  </head>
  
  <body>
   		
        <?php include 'footer.html'; ?>

  </body>

        
</html>