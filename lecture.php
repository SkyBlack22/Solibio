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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.6.6/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  
  <body>
   		

        <div class="container">
    <br/>
	<div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <form class="card card-sm" method="get">
                                <div class="card-body row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <i class="fas fa-search h4 text-body"></i>
                                    </div>
                                    <!--end of col-->
                                    <div class="col">
                                        <input class="form-control form-control-lg form-control-borderless" type="search" name="q" placeholder="Rechercher une recette">
                                    </div>
                                    <!--end of col-->
                                    <div class="col-auto">
                                        <button class="btn btn-lg btn-success" type="submit">Search</button>
                                    </div>
                                    <!--end of col-->
                                </div>
                            </form>
                        </div>
                        <!--end of col-->
                    </div>
</div>

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

                        if(isset($_GET['q']) AND !empty($_GET['q'])) 
                        {
                            $q = htmlspecialchars($_GET['q']);
                            $statement = $bdd->query('SELECT recettes.id, recettes.nom, recettes.tempsprepa, recettes.tpscuisson, recettes.puissancecuisson  FROM recettes WHERE recettes.nom LIKE "%'.$q.'%" ORDER BY recettes.id DESC');
                            if($statement->rowCount() == 0) 
                            {
                                $statement = $bdd->query('SELECT titre FROM articles WHERE CONCAT(titre, contenu) LIKE "%'.$q.'%" ORDER BY id DESC');
                            }    
                        }
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
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item"><a class="page-link" href="?page=1">First</a></li>
                    <li class="<?php if($pageCourante <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if($pageCourante <= 1){ echo '#'; } else { echo "?page=".($pageCourante - 1); } ?>">Previous</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="<?php if($pageCourante >= $pagesTotales){ echo '#'; } else { echo "?page=".($pageCourante + 1); } ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $pagesTotales; ?>">Last</a></li>
                </ul>
            </nav>
        </div>
      <?php include 'footer.html'; ?>
     </body>
</html>
       
       
       
       
       