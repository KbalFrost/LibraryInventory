// Function to show pop-up message
function showAlert(message) {
    alert(message);
}

//Use function for input validation
// Function to validate the form before submission
function validateForm() {
    var newUsername = document.getElementById("new-username").value;
    var newPassword = document.getElementById("new-password").value;
    var confirmPassword = document.getElementById("confirm-password").value;
    var fullName = document.getElementById("full-name").value;
    var email = document.getElementById("email").value;
    var userRole = "admin";

    if (newUsername.trim() === '' || newPassword.trim() === '' || confirmPassword.trim() === '' || fullName.trim() === '') {
        showAlert("Please fill in all required fields.");
        return false;
    }

    if (newPassword !== confirmPassword) {
        showAlert("Passwords do not match.");
        return false;
    }

    if (email !== '' && !isValidEmail(email)) {
        showAlert("Invalid email format.");
        return false;
    }
    return true;
}

// Function to validate email format
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}