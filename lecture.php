<?php 
    include 'header.php';
    require('database.php');
    $bdd=Database::connect();
    $recetteParPage=5;
    $recettesTotalesReq=$bdd->query('SELECT id from recettes');
    $recettesTotales= $recettesTotalesReq->rowCount();   
    $pagesTotales = ceil($recettesTotales/$recetteParPage);
    if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
       $_GET['page'] = intval($_GET['page']);
       $pageCourante = $_GET['page'];
    } else {
       $pageCourante = 1;
    }
    $depart = ($pageCourante-1)*$recetteParPage;
?>

 

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    	<title>Les Recettes</title>
    	<link href ="Lecss.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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
                        $statement = $bdd->query('SELECT recettes.id, recettes.nom, recettes.tempsprepa, recettes.tpscuisson, recettes.puissancecuisson  FROM recettes  ORDER BY recettes.id DESC LIMIT '.$depart.','.$recetteParPage);
                        while($item = $statement->fetch()) 
                        {
                            echo '<tr>';
                            echo '<td>'. $item['nom'] . '</td>';
                            echo '<td>'. $item['tempsprepa'] . '</td>';
                            echo '<td>'. $item['tpscuisson']  . '</td>';
                            echo '<td>'. $item['puissancecuisson'] . '</td>';
                            echo '<td width=150>';
                            echo '<a class="btn btn-default" href="view.php?id='.$item['id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
                            echo ' ';
                            echo '</td>';
                            echo '</tr>';
                        }
                        
                      ?>
                  </tbody>
                </table>
            </div>
            <ul class="pagination">
                <li><a href="?page=1">First</a></li>
                <li class="<?php if($pageCourante <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageCourante <= 1){ echo '#'; } else { echo "?page=".($pageCourante - 1); } ?>">Prec</a>
                </li>
                <li class="<?php if($pageCourante >= $pagesTotales){ echo 'disabled'; } ?>">
                <a href="<?php if($pageCourante >= $pagesTotales){ echo '#'; } else { echo "?page=".($pageCourante + 1); } ?>">Next</a>
                </li>
                <li><a href="?page=<?php echo $pagesTotales; ?>">Last</a></li>
            </ul>
        </div>
      <?php include 'footer.html'; ?>
     </body>
</html>
       
       
       
       
       