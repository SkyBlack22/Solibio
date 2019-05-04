<?php 
    include'header.php';
?>
    
<!DOCTYPE html>
<html>
  <head>
        <link href ="Lecss.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>
  
  <body>
   		

       
               
        <div class="container admin">
            <div class="row">
                <h1><strong>Liste des recettes   </strong><a href="Recette.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
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
                        require('database.php');
                        $bdd=Database::connect();
                        $statement = $bdd->prepare('SELECT recettes.id, recettes.nom, recettes.tempsprepa, recettes.tpscuisson, recettes.puissancecuisson  FROM recettes WHERE id_utilisateur=? ORDER BY recettes.id DESC');
                        $statement->execute(array($_SESSION['ID']));
                        
                        while($item = $statement->fetch()) 
                        {
                            echo '<tr>';
                            echo '<td>'. $item['nom'] . '</td>';
                            echo '<td>'. $item['tempsprepa'] . '</td>';
                            echo '<td>'. $item['tpscuisson']  . '</td>';
                            echo '<td>'. $item['puissancecuisson'] . '</td>';
                            echo '<td width=300>';
                            echo '<a class="btn btn-default" href="view.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                            echo ' ';
                            echo '<a class="btn btn-primary" href="update.php?id='.$item['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="deletecompte.php?id='.$item['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                      ?>
                  </tbody>
                </table>
            </div>
        </div>
      <?php include 'footer.html'; ?>
     </body>
</html>