<?php
    require('../database.php');
    $bdd= Database::connect();
?>



<!DOCTYPE html">
<html>
     <head><title>Suppression utilisateur</title>
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

    
    <div class="container admin">
            <div class="row">
                <h1><strong>Liste des utilisateurs</strong></h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Adresse Mail</th>
                      <th>Date de naissance</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                    
                  <tbody>
                      <?php
                        $statement = $bdd->query('SELECT utilisateur.ID, utilisateur.NOM, utilisateur.PRENOM, utilisateur.MAIL, utilisateur.DATENAISS  FROM utilisateur  ORDER BY utilisateur.ID DESC');
                        while($item = $statement->fetch()) 
                        {
                            echo '<tr>';
                            echo '<td>'. $item['NOM'] . '</td>';
                            echo '<td>'. $item['PRENOM'] . '</td>';
                            echo '<td>'. $item['MAIL']  . '</td>';
                            echo '<td>'. $item['DATENAISS'] . '</td>';
                            echo '<td width=150>';
                            echo '<a class="btn btn-danger" href="deluser.php?id='.$item['ID'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                      ?>
                  </tbody>
                </table>
            </div>
        </div>
<?php include('../footer.html'); ?>
</body>
