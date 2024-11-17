function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var passwordError = document.getElementById("passwordError");
 
    if (password !== confirmPassword) {
       passwordError.innerHTML = "Passwords do not match";
       return false;
    } else {
       passwordError.innerHTML = "";
       return true;
    }
 }
