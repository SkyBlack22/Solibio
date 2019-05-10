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
     
<body>
    
  <form method='post' >
      <div class="container2">
         <img id="ImageConnection" src="images/connection.png" alt="ImageConnection" />
         <div class="form-group row">
             <label class="col-sm-2 col-form-label col-form-label-sm" for="pseudo">Pseudo</label>
              <div class="col-sm-10">
                 <input type="text" placeholder="Entrer Pseudo" name="pseudo" id="pseudo" value="<?php echo $pseudo;?>" required>
              </div>
          </div>
         <div class="form-group row">
            <label class="col-sm-2 col-form-label col-form-label-sm" for="pswd">Mot de Passe</label>
                <div class="col-sm-10">
                    <input type="password" placeholder="Entrer Mot de passe" name="paswd" id="paswd" required>
                    <span class="help-inline"><?php if(!empty($msg_error)){ echo '<br />'.$msg_error; }?></span><br/>
                </div>
          </div>
         <div class="form-group row">
             <div class="col-sm-10">
                <button type="submit" name="Valider" >Login</button>
             </div>
         </div>
         <div class="form-group row">
             <div class="col-sm-10">
                <input type="checkbox" name="rememberme" id="rembercheckbox"><label for="rembercheckbox">Se souvenir de moi</label>
             </div>
         </div>
      </div>
  </form>
  <?php include 'footer.html'; ?>
</body>
</html>




