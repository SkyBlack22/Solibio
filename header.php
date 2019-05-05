    
        <header>
           <div class="container">
               <h1>Solibio<span class="orange">.</span></h1>
               <nav class="navbar navbar-expand-md navbar-light bg-light">
                  <ul class="navbar-nav">
                    <?php 
                      session_start();
                      if(!empty($_SESSION['ID']))
                      {
                        echo '<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="compte.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Mon Compte</a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="modifiercompte.php">Modifier compte</a>
                                    <a class="dropdown-item" href="recettecompte.php">Afficher Recette</a>
                                    <a class="dropdown-item" href="compte.php">Mon Compte</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="deconnexion.php">Se déconnecter</a>
                                </div>
                             </li>';
                      }
                    ?>
                    <?php 
                      if(empty($_SESSION['ID']))
                      {
                          echo '<li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>';
                          echo'<li class="nav-item"><a class="nav-link" href="Inscription.php">Inscription</a></li>';
                      }
                      ?>
                    <li class="nav-item active"><a class="nav-link" href="index.php">Accueil</a></li>
                   
                  </ul>
               </nav>
            </div>
        </header>
