// Function to refresh the user table
function refreshUserTable() {
    location.reload();
}

// Function to open the new user registration dialog
function openNewUserDialog() {
    document.getElementById('newUserDialog').style.display = 'block';
}

// Function to close the new user registration dialog
function closeNewUserDialog() {
    document.getElementById('newUserDialog').style.display = 'none';
}

// Function to save the new user registration
function saveNewUser() {
    var newUsername = document.getElementById('newUsername').value;
    var newFullName = document.getElementById('newFullName').value;
    var newEmail = document.getElementById('newEmail').value;
    var newPhoneNumber = document.getElementById('newPhoneNumber').value;
    var newFavoriteBook = document.getElementById('newFavoriteBook').value;
    var newPassword = document.getElementById('newPassword').value;
    var confirmPassword = document.getElementById('confirmPassword').value;
    var userRole = "admin";

    // Validate password match
    if (newPassword !== confirmPassword) {
        alert("Passwords do not match");
        return;
    }

    // AJAX request to save new user registration
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            closeNewUserDialog();
            refreshUserTable();
        }
    };
    xhttp.open("POST", "register_user_admin.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("newUsername=" + newUsername + "&newFullName=" + newFullName + "&newEmail=" + newEmail + "&newPhoneNumber=" + newPhoneNumber + "&newFavoriteBook=" + newFavoriteBook + "&newPassword=" + newPassword + "&userRole=" + userRole);
}

// Function to open the edit dialog and fill in the form with user data
function editUser(username, fullName, email, phoneNumber, favoriteBook) {
    document.getElementById('editUsername').value = username;
    document.getElementById('editFullName').value = fullName;
    document.getElementById('editEmail').value = email;
    document.getElementById('editPhoneNumber').value = phoneNumber;
    document.getElementById('editFavoriteBook').value = favoriteBook;

    document.getElementById('editUserDialog').style.display = 'block';
}

// Function to close the edit dialog
function closeEditUserDialog() {
    document.getElementById('editUserDialog').style.display = 'none';
}

// Function to save the edited user information
function saveEditUser() {
    var username = document.getElementById('editUsername').value;
    var fullName = document.getElementById('editFullName').value;
    var email = document.getElementById('editEmail').value;
    var phoneNumber = document.getElementById('editPhoneNumber').value;
    var favoriteBook = document.getElementById('editFavoriteBook').value;

    // AJAX request to update user information
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            closeEditUserDialog();
            refreshUserTable();
        }
    };
    xhttp.open("POST", "update_user.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username=" + username + "&fullName=" + fullName + "&email=" + email + "&phoneNumber=" + phoneNumber + "&favoriteBook=" + favoriteBook);
}

// Function to confirm to delete the user data
function confirmDeleteUser() {
    var confirmDeleteUser = confirm("Are you sure you want to delete this user?");
    if (confirmDeleteUser) {
        deleteUser();
    }
}

// Function to delete the user data
function deleteUser() {
    var username = document.getElementById('editUsername').value;

    // AJAX request to delete user data
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            closeEditUserDialog();
            refreshUserTable();
        }
    };
    xhttp.open("POST", "delete_user.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username=" + username);
}