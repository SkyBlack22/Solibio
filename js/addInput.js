var counter = 1;
var limit = 7;
function addInput(divName) {
    if (counter == limit) {
        alert("Vous avez atteint la limite d'ajouts qui est de " + counter + " ajouts");
    }
    else {
        var newdiv = document.createElement('div');
        newdiv.innerHTML = "Ingredient " + (counter + 1) +" :" +" <input type ='text' name='myInputs[]'>";
    
        document.getElementById(divName).appendChild(newdiv);
        counter++
    }
}