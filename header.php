        <header>
           <div class="container">
               <h1>Solibio<span class="orange">.</span></h1>
               <nav>
                  <ul>
                    <?php 
                      session_start();
                      if(!empty($_SESSION['ID']))
                      {
                        echo '<li><a href="deconnexion.php">Déconnexion</a></li>';
                        echo '<li><a href="compte.php">Mon Compte</a></li>';
                      }
                    ?>
                    <?php 
                      if(empty($_SESSION['ID']))
                      {
                          echo '<li><a href="connexion.php">Connexion</a></li>';
                          echo'<li><a href="Inscription.php">Inscription</a></li>';
                      }
                      ?>
                    <li><a href="index.php">Accueil</a></li>
                   
                  </ul>
               </nav>
            </div>
        </header>
