<?php 
    require('database.php');
    $bdd=Database::connect();
    session_start();
    if(isset($_GET['id'],$_GET['t'],$_SESSION['ID']) AND !empty($_GET['id']) AND !empty($_GET['t']) AND !empty($_SESSION['ID']))
    {
        $sessionid= $_SESSION['ID'];
        $getid= (int) $_GET['id'];
        $gett= (int) $_GET['t'];
        $check=$bdd->prepare('SELECT id FROM recettes where id= ?');
        $check->execute(array($getid));
        
        if($check->rowCount() == 1)
        {
            if($gett == 1)
            {
                $check_like=$bdd->prepare('SELECT id FROM likes WHERE id_recette= ? AND id_utilisateur= ?');
                $check_like->execute(array($getid, $sessionid));
                
                $del=$bdd->prepare('DELETE FROM dislikes WHERE id_recette= ? AND id_utilisateur= ?');
                $del->execute(array($getid, $sessionid));
                
                if($check_like->rowCount() == 1)
                {
                    $del=$bdd->prepare('DELETE FROM likes WHERE id_recette= ? AND id_utilisateur= ?');
                    $del->execute(array($getid, $sessionid));
                }
                else{
                    $ins= $bdd->prepare('INSERT INTO likes (id_recette, id_utilisateur) VALUES (?, ?)');
                    $ins->execute(array($getid, $sessionid));
                }
                
            }
            elseif($gett == 2)
            {
                $check_like=$bdd->prepare('SELECT id FROM dislikes WHERE id_recette= ? AND id_utilisateur= ?');
                $check_like->execute(array($getid, $sessionid));
                
                $del=$bdd->prepare('DELETE FROM likes WHERE id_recette= ? AND id_utilisateur= ?');
                $del->execute(array($getid, $sessionid));
                
                if($check_like->rowCount() == 1)
                {
                    $del=$bdd->prepare('DELETE FROM dislikes WHERE id_recette= ? AND id_utilisateur= ?');
                    $del->execute(array($getid, $sessionid));
                }
                else{
                    $ins=$bdd->prepare('INSERT INTO dislikes (id_recette, id_utilisateur) VALUES (?, ?)');
                    $ins->execute(array($getid, $sessionid));    
                }
                 
            }
            header('Location: http://127.0.0.1/try/view.php?id=' .$getid);
        }
        else{
            exit('Erreur fatale');
        }
    }else
    {
        exit('Vous devez être connecté pour aimer une recette. <a href="http://127.0.0.1/try"<a>Retour à l\'accueil</a>');
    }

    