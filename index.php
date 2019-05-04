<!DOCTYPE html">
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
        <?php include 'header.php'; ?>

        <section id ="main-image">
              <div class="container">
                    <br><a href="lecture.php" class="button">Découvrez nos recettes.</a>
             </div>
        </section>

        <section id="steps">

          <div class="container">

              <article id="article1">
                  <div class="overlay">
                    <img id="Image1" src="images/Etape1.png" alt="Etape1" />
                      <h4 id="h41">REGARDEZ</h4>
                      <p id="p1"><small>Cherchez la recette qui vous intéresse.</small></p>
                  </div>
              </article>

          
              <article id="article2">
                  <div class="overlay">
                    <img id="Image2" src="images/Etape2.png" alt="Image2" />
                      <h4 id="h42">PREPAREZ</h4>
                      <p id="p2"><small>Suivez les étapes et préparez.</small></p>
                  </div>
              </article>


              <article id="article3">
                  <div class="overlay">
                    <img id="Image3" src="images/Etape3.png" alt="Image3" />
                      <h4 id="h43">MANGEZ</h4>
                      <p id="p3"><small>Régalez-vous !</small></p>
                  </div>
              </article>
          </div>
        </section>

        <?php include 'footer.html'; ?>
    </body>
</html>