<?php
    require('../database.php');#connexion a la BDD
    $bdd= Database::connect();
    $utilisateurParPage=5;
    $utilisateursTotalesReq=$bdd->query('SELECT id from utilisateur');
    $utilisateursTotales= $utilisateursTotalesReq->rowCount();   
    $pagesTotales = ceil($utilisateursTotales/$utilisateurParPage);
    if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
       $_GET['page'] = intval($_GET['page']);
       $pageCourante = $_GET['page'];
    } else {
       $pageCourante = 1;
    }
    $depart = ($pageCourante-1)*$utilisateurParPage;
?>



<!DOCTYPE html">
<html>
     <head>
        <title>AmicaleFulbert</title>
        <link href ="../Lecss.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Sniglet" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>


    <body data-spy="scroll" data-target=".navbar" data-offset="60">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img id="logo" src="../images/logo.jpg" width="50" height="50" alt="Logo"> AmicaleFulbert</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse"  id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Accueil</a>
                    </li>

                    <?php
                    session_start();
                    if(empty($_SESSION['ID']))
                      { ?>
                          <li class="nav-item"><a class="nav-link" href="../connexion.php">Connexion</a></li>
                          <li class="nav-item"><a class="nav-link" href="../Inscription.php">Inscription</a></li>
                    <?php } ?>
                    <?php 
                    if(!empty($_SESSION['ID']))
                      { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="../compte.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mon Compte</a>
                        <!-- bloc menu déroulant -->
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../modifiercompte.php">Modifier Compte</a>
                            <a class="dropdown-item" href="../recettecompte.php">Vos recettes</a>
                            <a class="dropdown-item" href="../compte.php">Mon Compte</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../deconnexion.php">Se déconnecter</a>
                        </div>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../Contact.php">Contact</a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>
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
                                <input class="form-control form-control-lg form-control-borderless" type="search" name="q" placeholder="Rechercher un utilisateur">
                            </div>
                            <!--end of col-->
                            <div class="col-auto">
                                <button class="btn btn-lg btn-success" type="submit">Search</button>
                            </div>
                            <!--end of col-->
                        </div>
                    </form>
                </div>            <!--end of col-->
            </div>
        </div>
    <?php
    if(!empty($_SESSION['ID']) AND $_SESSION['admin']==1)
    {
    ?>
    
    <div class="container admin">
            <div class="row">
                <h1><strong>Liste des utilisateurs</strong></h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Adresse Mail</th>
                      <th>Statut</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                    
                  <tbody>
                      <?php
                        $statement = $bdd->query('SELECT utilisateur.ID, utilisateur.NOM, utilisateur.PRENOM, utilisateur.MAIL, utilisateur.admin  FROM utilisateur  ORDER BY utilisateur.ID DESC LIMIT '.$depart.','.$utilisateurParPage);#recuperation des utilisateurs
                        if(isset($_GET['q']) AND !empty($_GET['q'])) 
                        {
                            $q = htmlspecialchars($_GET['q']);
                            $statement = $bdd->query('SELECT utilisateur.ID, utilisateur.NOM, utilisateur.PRENOM, utilisateur.MAIL, utilisateur.admin  FROM utilisateur WHERE utilisateur.NOM LIKE "%'.$q.'%" ORDER BY utilisateur.id DESC');
                            if($statement->rowCount() == 0) 
                            {
                                $statement = $bdd->query('SELECT titre FROM recettes WHERE CONCAT(titre, contenu) LIKE "%'.$q.'%" ORDER BY id DESC');
                            }    
                        }
                        while($item = $statement->fetch()) 
                        {
                            echo '<tr>';
                            echo '<td>'. $item['NOM'] . '</td>';
                            echo '<td>'. $item['PRENOM'] . '</td>';
                            echo '<td>'. $item['MAIL']  . '</td>';
                        ?>
                            <td><?php if($item['admin']==1){ echo 'Administrateur'; }else{ echo 'Utiilisateur'; } ?></td>
                    <?php 
                            echo '<td width=290>';
                            echo '<a class="btn btn-primary" href="upadmin.php?id='.$item['ID'].'"><i class="fas fa-user-shield"></i> Promouvoir</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="deluser.php?id='.$item['ID'].'"><i class="fa fa-trash"></i> Supprimer</a>';
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
    <?php 
    }
    else
    {
        echo'<div class="alert alert-warning">
  <strong>Attention</strong> Vous n\'êtes pas administrateur.
</div>';
    }
    ?>
<?php include('../footer.html'); ?>
</body>
