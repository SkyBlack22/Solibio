<?php


if(!isset($_SESSION['ID']) AND isset($_COOKIE['pseudo'],$_COOKIE['password']) AND !empty($_COOKIE['pseudo']) AND !empty($_COOKIE['password']))
{
    $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE PSEUDO = ? AND MOTDEPASSE= ?");
    $requser->execute(array($_COOKIE['pseudo'], $_COOKIE['password']));
    $userexist = $requser->rowCount();

    if ($userexist==1)
    {
        $userinfo=$requser->fetch();
        $_SESSION['ID'] = $userinfo['ID'];
        $_SESSION['pseudo'] = $userinfo['PSEUDO'];
    }
}
    