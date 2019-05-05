<?php
  include 'header.php';
  require('database.php');
  $bdd=Database::connect();
  include_once('cookie.php');
  $pseudo="";
  if (isset($_POST['Valider'])) {

    $pseudo=htmlspecialchars($_POST['pseudo']);
    $mdp=md5($_POST['paswd']);
    if(!empty($pseudo) AND !empty($mdp))
    {
      $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE PSEUDO = ? AND MOTDEPASSE= ?");
      $requser->execute(array($pseudo, $mdp));
    
      $userexist = $requser->rowCount();

      if ($userexist==1)
        {
            if(isset($_POST['rememberme']))
            {
                setcookie('pseudo',$pseudo,time()+365*24*3600,null,null,false,true);
                setcookie('password',$mdp,time()+365*24*3600,null,null,false,true);
            }
            $userinfo=$requser->fetch();
            $_SESSION['ID'] = $userinfo['ID'];
            $_SESSION['pseudo'] = $userinfo['PSEUDO'];
            header("Location: index.php?id=".$_SESSION['ID']);
        }
       
      else {
          $msg_error='Mauvais identifiant ou mot de passe !';
      }
      
    }
      
}
    
?>   

<!DOCTYPE html">
<html>
     <head><title>Connexion</title>
        <link href ="Lecss.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
     </head>
<body>
    
  <form method='post' >
      <div class="container2">
         <img id="ImageConnection" src="images/connection.png" alt="ImageConnection" />



         <div id="TextBox1">
            <label class="labelConIns" for="uname"><b>Pseudo</b></label>
            <input type="text" placeholder="Entrer Pseudo" name="pseudo" value="<?php echo $pseudo;?>" required>
         </div>



         <div id="TextBox2">
            <label class="labelConIns" for="psw"><b>Mot de Passe</b></label>
            <input type="password" placeholder="Entrer Mot de passe" name="paswd" required>
            <span class="help-inline"><?php if(!empty($msg_error)){ echo '<br />'.$msg_error; }?></span><br/>
          </div>
          



         <div id="TextBox3">
             <button type="submit" name="Valider" class="Valider">Login</button>
         </div>
          
         <div id="CheckBox">
            <input type="checkbox" name="rememberme" id="rembercheckbox"><label for="rembercheckbox">Se souvenir de moi</label>
         </div>



      </div>
  </form>
  <?php include 'footer.html'; ?>
</body>
</html>




