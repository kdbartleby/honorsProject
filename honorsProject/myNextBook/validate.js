// This function provides the regex for validating email
function validateEmail(emailField) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
}

// This function validates the input of a form
function validateForm() {

    // login/signup fields
    var emailField = document.getElementById('email');
    var passwordField = document.getElementById('password');
    var usernameField = document.getElementById('username');
    var confirmPasswordField = document.getElementById('confirmPassword');

    // add book fields
    var titleField = document.getElementById('title');
    var firstnameField = document.getElementById('firstname');
    var lastnameField = document.getElementById('lastname');
    var genreField = document.getElementById('genre');
    var publishYearField = document.getElementById('publish_year');
    var descriptionField = document.getElementById('description');
    var coverField = document.getElementById('cover');

    // regex patterns
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(emailField))
    {
        titleField.style.borderColor = "red";
        return false;
    }


    return true;
}
