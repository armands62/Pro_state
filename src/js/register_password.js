var password = document.getElementById('password'); //declare variable
var upperCase = document.getElementById('upper'); //declare variable
var lowerCase = document.getElementById('lower'); //declare variable
var digit = document.getElementById('number'); //declare variable
var minLength = document.getElementById('length') //declare variable

password.onfocus = function() {  // function on focus (when click on input field, function start working)
    document.getElementById("validation").style.display = "block"; //validation appears right side of password field
}

password.onblur = function() { //function on blur (when click on field thats not "password field", function start working)
  document.getElementById("validation").style.display = "none"; //validation hides
}

password.onkeyup = function() {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if(password.value.match(lowerCaseLetters)) {  
      lowerCase.classList.remove("invalid");
      lowerCase.classList.add("valid");
    } else {
      lowerCase.classList.remove("valid");
      lowerCase.classList.add("invalid");
    }
    
   // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(password.value.match(upperCaseLetters)) {  
      upperCase.classList.remove("invalid");
      upperCase.classList.add("valid");
    } else {
      upperCase.classList.remove("valid");
      upperCase.classList.add("invalid");
    }
  
    // Validate numbers
    var digits = /[0-9]/g;
    if(password.value.match(digits) ) {
        digit.classList.remove("invalid");
        digit.classList.add("valid");
    } else {
        digit.classList.remove("valid");
        digit.classList.add("invalid");
    }

    // Validate length
    if(password.value.length >= 8) {
      minLength.classList.remove("invalid");
      minLength.classList.add("valid");
    } else {
      minLength.classList.remove("valid");
      minLength.classList.add("invalid");
    }
  }
