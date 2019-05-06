<?php 
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
  <head>
    <meta charset="utf-8"/>
    <title>Les recettes</title>
    <link href ="Lecss.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
  </head>
  
  <body>
  	<?php include 'header.php'; ?>

  

    <form action="" method="post" enctype="multipart/form-data">
         <div class="container3">
              <img id="ImageInscription" src="images/inscription.png" alt="ImageInscription"/>
              <div class="FofoInscription">
                    <label class="labelConIns" for="prenom">Prénom:</label>
                    <input type="text" name="Prenom" id="Prenom" placeholder="Entrez votre prénom" value="<?php echo $Prenom;?>" required/>
                    <span class="help-inline">*<?php if(!empty($prenom_error)){ echo '<br />'.$prenom_error; }?></span><br/>
              </div>
              <div class="FofoInscription">
                    <label class="labelConIns" for="nom">Nom:</label>
                    <input type="text" name="Nom" id="Nom" placeholder="Entrez votre nom" value="<?php echo $Nom;?>" required/>
                    <span class="help-inline">*<?php if(!empty($name_error)){ echo '<br />'.$name_error; }?></span>
              </div>
              <div class="FofoInscription">
                    <label  class="labelConIns" for="pseudo">Pseudo:</label>
                    <input type="text" name="Pseudo" id="Pseudo" placeholder="Entrez un pseudo" required value="<?php echo $Pseudo;?>"/>
                    <span class="help-inline">* <?php if(!empty($pseudo_error)){ echo '<br />'.$pseudo_error; }?></span><br/>
              </div>
              <div class="FofoInscription">
                    <label  class="labelConIns" for="mail">E-Mail:</label>
                    <input type="text" name="Mail" id="Mail" placeholder="Entrez un e-mail" required value="<?php echo $adresse_mail;?>"/>
                    <span class="help-inline">* <?php if(!empty($mail_error)){ echo '<br />'.$mail_error; }?></span><br/>
              </div>
              <div class="FofoInscription1">
                    <label  class="labelConIns" for="datenaiss">Date de naissance:</label>
                    <input type="date" name="datenaiss" id="datenaiss" placeholder="Entrez votre date de naissance" required value="<?php echo $date_naiss;?>"/><br/>
              </div>
              <div class="FofoInscription1">
                    <label  class="labelConIns" for="mail">Mot de passe:</label>
                    <input type="password" name="MotDePasse" id="MotDePasse" placeholder="Entrez un mot de passe" required/>
                    <span class="help-inline">*<?php if(!empty($mdp_error)){ echo '<br />'.$mdp_error; }?></span><br/>
              </div>
              <div id="TextBox3">
                    <button type="submit" value="Valider" id="Valider" class="Valider" name="Valider">M'inscrire</button>
              </div>
        </div>
    </form>
    <?php 

    ?>
       
    <?php include 'footer.html'; ?>

  </body>



</html>