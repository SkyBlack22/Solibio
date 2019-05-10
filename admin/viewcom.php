<?php
    require('../database.php');
    $bdd= Database::connect();
?>



<!DOCTYPE html">
<html>
     <head><title>Gestion des commentaires</title>
        <link href ="../Lecss.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
     </head>
<body>
    <header>
           <div class="container">
               <h1>Solibio<span class="orange">.</span></h1>
               <nav>
                  <ul>
                    <?php 
                      session_start();
                      if(!empty($_SESSION['ID']))
                      {
                        echo '<li><a href="../deconnexion.php">Déconnexion</a></li>';
                        echo '<li><a href="../compte.php">Mon Compte</a></li>';
                      }
                    ?>
                    <?php 
                      if(empty($_SESSION['ID']))
                      {
                          echo '<li><a href="../connexion.php">Connexion</a></li>';
                          echo'<li><a href="../Inscription.php">Inscription</a></li>';
                      }
                      ?>
                    <li><a href="../index.php">Accueil</a></li>
                   
                  </ul>
               </nav>
            </div>
        </header>

    <?php
    if(!empty($_SESSION['ID']) AND $_SESSION['ID']==33)
    {
    ?>
    <div class="container admin">
            <div class="row">
                <h1><strong>Liste des commentaires</strong></h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Pseudo du posteur</th>
                      <th>Contenu du commentaire</th>
                      <th>Id util</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                    
                  <tbody>
                      <?php
                        $statement = $bdd->query('SELECT utilisateur.ID, utilisateur.PSEUDO, commentaire.id, commentaire.contenu FROM utilisateur, commentaire WHERE utilisateur.ID= commentaire.id_utilisateur  ORDER BY commentaire.id DESC');
                        while($item = $statement->fetch()) 
                        {
                            echo '<tr>';
                            echo '<td>'. $item['PSEUDO'] . '</td>';
                            echo '<td>'. $item['contenu'] . '</td>';
                            echo '<td>'. $item['ID'] . '</td>';
                            echo '<td width=150>';
                            echo '<a class="btn btn-danger" href="delcom.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                      ?>
                  </tbody>
                </table>
            </div>
        </div>
    <?php 
    }
    else
    {
        echo'Vous n\'êtes pas administrateur';
    }
    ?>
<?php include('../footer.html'); ?>
</body>
