<?php
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
    <body>
    
         <?php include'header.php'; ?>   
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
                <h1><strong>Liste des recettes   </strong><a href="Recette.php" class="btn btn-success btn-lg"><i class="fas fa-plus"></i> Ajouter</a></h1>
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
                        $statement = $bdd->prepare('SELECT recettes.id, recettes.nom, recettes.tempsprepa, recettes.tpscuisson, recettes.puissancecuisson  FROM recettes WHERE id_utilisateur=? ORDER BY recettes.id DESC');
                        $statement->execute(array($_SESSION['ID']));
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
                            echo '<td width=227>';
                            echo '<a class="btn btn-default" href="view.php?id='.$item['id'].'"><i class="fas fa-eye"></i></a>';
                            echo ' ';
                            echo '<a class="btn btn-primary" href="update.php?id='.$item['id'].'"><i class="fas fa-pen"></i> Modifier</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="deletecompte.php?id='.$item['id'].'"><i class="fa fa-trash"></i></a>';
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