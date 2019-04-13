<!DOCTYPE html">
<html>
     <head><title>Connexion</title>
        <link rel="stylesheet" href="Lecss.css"/>
     </head>
<body>
    <header>
       <div class="container">
           <h1>Solibio<span class="orange">.</span></h1>
            <nav>
              <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Something</a></li>
                <li><a href="#">Something</a></li>
               </ul>
           </nav>
         </div>
     </header>
  <form method='post' >
      <div class="container2">
         <img id="ImageConnection" src="images/connection.png" alt="ImageConnection" />



         <div id="TextBox1">
            <label for="uname"><b>Pseudo</b></label>
            <input type="text" placeholder="Entrer Pseudo" name="pseudo" required>
         </div>



         <div id="TextBox2">
            <label for="psw"><b>Mot de Passe</b></label>
            <input type="password" placeholder="Entrer Mot de passe" name="paswd" required>
          </div>



         <div id="TextBox3">
             <button type="submit">Login</button>
         </div>



      </div>
  </form>
</body>
</html>




