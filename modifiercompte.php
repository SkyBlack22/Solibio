<?php
    include 'header.php';
    require('database.php');
    include_once('cookie.php');
    $bdd=Database::connect();
    if(!empty($_SESSION['ID']))
    {
        
        $requser=$bdd->prepare("SELECT * FROM utilisateur WHERE ID= ?");
        $requser->execute(array($_SESSION['ID']));
        $user = $requser->fetch();
        
        if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['PSEUDO'])
        {
            $newpseudo=htmlspecialchars($_POST['newpseudo']);
            $insertpseudo=$bdd->prepare("UPDATE utilisateur SET PSEUDO = ? WHERE ID= ?");
            $insertpseudo->execute(array($newpseudo, $_SESSION['ID']));
            header("Location: compte.php?id=".$_SESSION['ID']);
        }
        if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1'] AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])))
        {
            $mdp1=md5($_POST['newmdp1']);
            $mdp2=md5($_POST['newmdp2']);
            
            if($mdp1 == $mdp2)
            {
                $insertmdp= $bdd->prepare("UPDATE utilisateur SET MOTDEPASSE = ? WHERE ID= ?");
                $insertmdp->execute(array($mdp1,$_SESSION['ID']));
                header("Location: compte.php?id=".$_SESSION['ID']);
            }
            else
            {
                $msg= "Vos deux mots de passe ne correspondent pas";
                
            }
            
            
        }
        
        if(isset($_POST['newpseudo']) AND $_POST['newpseudo']== $user['PSEUDO'])
        {
            header("Location: compte.php?id=".$_SESSION['ID']);
        }
        
        if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['MAIL'])
        {
            $newmail=htmlspecialchars($_POST['newmail']);
            $insertpseudo=$bdd->prepare("UPDATE utilisateur SET MAIL = ? WHERE ID= ?");
            $insertpseudo->execute(array($newmail, $_SESSION['ID']));
            header("Location: compte.php?id=".$_SESSION['ID']);
        }
    }
    else
    {
        echo 'Vous devez être connecté';
    }
        
    
?>

<!DOCTYPE html">
<html>
<body>
    <div id="Container5">
    <h2>Edition de mon profil</h2>
    <form method="post" action="">
        <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['PSEUDO']; ?>"><br/>
        <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['MAIL']?>"><br/>
        <input type="password" name="newmdp1" placeholder="Mot de passe" ><br/>
        <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe">
        <button type="submit" id="modifbouton">Valider</button>
        <?php if(isset($msg)) { echo $msg; } ?>
    </form>
    </div>
    <?php include 'footer.html'; ?>
</body>
</html>