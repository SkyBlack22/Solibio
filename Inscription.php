<?php 
 include 'header.php'; 
require 'database.php';
        $bdd=Database::connect();
        $mdp_error=$prenom_error=$name_error= $mail_error= $pseudo_error = $Nom = $Prenom = $Pseudo = $adresse_mail = $date_naiss = "";
        if(isset($_POST['Valider']))
        {
            if(!empty($_POST['Nom']) && !empty($_POST['Prenom']) && !empty($_POST['Pseudo']) && !empty($_POST['Mail']) && !empty($_POST['MotDePasse']) && !empty($_POST['datenaiss']))
            {
                $Nom = htmlspecialchars($_POST['Nom']);
                $Prenom = htmlspecialchars($_POST['Prenom']);
                $Pseudo = htmlspecialchars($_POST['Pseudo']);
                $Mot_de_passe =htmlspecialchars($_POST['MotDePasse']);
                $adresse_mail = htmlspecialchars($_POST['Mail']);
                $date_naiss = htmlspecialchars($_POST['datenaiss']);
                $isSuccess = true;
                
                if (!preg_match("/^[a-zA-Z ]*$/",$Nom)) 
                {
                    $name_error = "Seul lettres et espaces autorisés";
                    $isSuccess = false;
                }
                if (!preg_match("/^[a-zA-Z ]*$/",$Prenom)) 
                {
                    $prenom_error = "Seul lettres et espaces autorisés";
                    $isSuccess = false;
                }
                if (!filter_var($adresse_mail, FILTER_VALIDATE_EMAIL)) 
                {
                    $mail_error = "Format email invalide";
                    $isSuccess = false;
                }
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,}$/', $Mot_de_passe)) 
                {
                    $mdp_error='Mot de passe non conforme';
	            }
                $reqmail = $bdd->prepare("SELECT * FROM utilisateur WHERE MAIL = ?");
                $reqmail->execute(array($adresse_mail));
                $mailexist = $reqmail->rowCount();
                if($mailexist > 0 ) 
                {
                     $mail_error='Ce mail est déjà utilisé';
                     $isSuccess = false;
                }
                $reqpseudo = $bdd->prepare("SELECT * FROM utilisateur WHERE PSEUDO = ?");
                $reqpseudo->execute(array($Pseudo));
                $pseudoexist = $reqpseudo->rowCount();

                if($pseudoexist > 0)
                {
                    $pseudo_error='Ce pseudo est déjà utilisé';
                    $isSuccess = false;
                }
                if($isSuccess)
                {
                    $Mot_de_passe =md5($_POST['MotDePasse']);
                    $ins=$bdd->prepare("INSERT INTO utilisateur(NOM, PRENOM, PSEUDO, MAIL, MOTDEPASSE, DATENAISS) VALUES(?, ?, ?, ?, ?, ?)");
                    $ins->execute(array($Nom, $Prenom, $Pseudo, $adresse_mail,$Mot_de_passe,$date_naiss));
                    echo("Inscription réussie");
                }

            }
        }
?>
<!DOCTYPE html">
<html>
    <body>
    <form action="" method="post" enctype="multipart/form-data">
         <div class="container3">
              <img id="ImageInscription" src="images/inscription.png" alt="ImageInscription"/>
              <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="Prenom">Prénom:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" name="Prenom" id="Prenom" placeholder="Entrez votre prénom" value="<?php echo $Prenom;?>" required/><span class="help-inline">*<?php if(!empty($prenom_error)){ echo '<br />'.$prenom_error; }?></span>
                    </div>
              </div>
              <div class="form-group row">
                    <label class="col-sm-2 col-form-label col-form-label-sm" for="Nom">Nom:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" name="Nom" id="Nom" placeholder="Entrez votre nom" value="<?php echo $Nom;?>" required/>
                        <span class="help-inline">*<?php if(!empty($name_error)){ echo '<br />'.$name_error; }?></span>
                    </div>
              </div>
              <div class="form-group row">
                    <label  class="col-sm-2 col-form-label col-form-label-sm" for="Pseudo">Pseudo:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" name="Pseudo" id="Pseudo" placeholder="Entrez un pseudo" required value="<?php echo $Pseudo;?>"/>
                        <span class="help-inline">* <?php if(!empty($pseudo_error)){ echo '<br />'.$pseudo_error; }?></span>
                    </div>
              </div>
              <div class="form-group row">
                    <label  class="col-sm-2 col-form-label col-form-label-sm" for="Mail">E-Mail:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" name="Mail" id="Mail" placeholder="Entrez un e-mail" required value="<?php echo $adresse_mail;?>"/><span class="help-inline">* <?php if(!empty($mail_error)){ echo '<br />'.$mail_error; }?></span>
                    </div>
              </div>
              <div class="form-group row">
                    <label  class="col-sm-2 col-form-label col-form-label-sm" for="datenaiss">Date de naissance:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control form-control-sm" name="datenaiss" id="datenaiss" placeholder="Entrez votre date de naissance" required value="<?php echo $date_naiss;?>"/>
                    </div>
              </div>
              <div class="form-group row">
                    <label  class="col-sm-2 col-form-label col-form-label-sm" for="MotDePasse">Mot de passe:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control form-control-sm" name="MotDePasse" id="MotDePasse" placeholder="Entrez un mot de passe" required/>
                        <span class="help-inline">*<?php if(!empty($mdp_error)){ echo '<br />'.$mdp_error; }?></span>
                    </div>
              </div>
              <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" value="Valider" id="Valider" name="Valider">M'inscrire</button>
                    </div>
             </div>
        </div>
        
    </form>
    <?php 

    ?>
       
    <?php include 'footer.html'; ?>

  </body>



</html>