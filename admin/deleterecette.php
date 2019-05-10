<?php
    require('../database.php');
    $bdd= Database::connect();
?>

<!DOCTYPE html">
<html>
     <head><title>Suppression Recette</title>
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
                <h1><strong>Liste des recettes   </strong><a href="../Recette.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Temps de préparation</th>
                      <th>Temps de cuisson</th>
                      <th>Puissance de cuisson</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                    
                  <tbody>
                      <?php
                        $statement = $bdd->query('SELECT recettes.id, recettes.nom, recettes.tempsprepa, recettes.tpscuisson, recettes.puissancecuisson  FROM recettes  ORDER BY recettes.id DESC');
                        while($item = $statement->fetch()) 
                        {
                            echo '<tr>';
                            echo '<td>'. $item['nom'] . '</td>';
                            echo '<td>'. $item['tempsprepa'] . '</td>';
                            echo '<td>'. $item['tpscuisson']  . '</td>';
                            echo '<td>'. $item['puissancecuisson'] . '</td>';
                            echo '<td width=300>';
                            echo '<a class="btn btn-default" href="../view.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                            echo ' ';
                            echo '<a class="btn btn-primary" href="../update.php?id='.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="../delete.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
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

