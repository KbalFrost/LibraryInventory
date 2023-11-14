window.onload = function () {
window.scrollBy(0, 20);
};

// Function to save new book information to the database
function saveBook() {
    var form = document.getElementById('registrationForm');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert(xhr.responseText);
            form.reset();
            refreshBookTable();
        }
    };

    // Send a POST request to the server-side script for database insertion
    xhr.open("POST", "register_book.php", true);
    xhr.send(formData);

    return false;
}

// Function to refresh the book table after adding a new book
function refreshBookTable() {
    location.reload();
}

// Function to filter and display available books
function showAvailableBooks() {
    filterBooks('available');
}

// Function to filter and display unavailable books
function showUnavailableBooks() {
    filterBooks('unavailable');
}

// Function to filter books based on availability status
function filterBooks(status) {
    var table = document.getElementById('bookTable');
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var statusCell = rows[i].getElementsByTagName('td')[5];
        var currentStatus = statusCell.textContent.trim().toLowerCase();
        rows[i].style.display = (status === 'all' || currentStatus === status) ? '' : 'none';
    }
}

// Function to change the availability status
function changeStatus(ISBN) {
    var dropdown = document.getElementById('statusDropdown' + ISBN);
    var newStatus = dropdown.value;

    var statusCell = document.getElementById('statusCell' + ISBN);
    statusCell.textContent = newStatus;

    // Make an AJAX request to update the database
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
        }
    };
    xhr.open("POST", "update_status.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("ISBN=" + ISBN + "&newStatus=" + newStatus);
}

// Function to open the search dialog
function openSearchDialog() {
    document.getElementById('searchDialog').style.display = 'block';
}

// Function to close the search dialog
function closeSearchDialog() {
    document.getElementById('searchDialog').style.display = 'none';
}

// Function to search books based on name or ISBN number
function searchBooks() {
    var searchTerm = document.getElementById('searchTerm').value;

    // AJAX request to search books
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('bookRow').innerHTML = this.responseText;
            document.getElementById('searchTerm').value = '';
            closeSearchDialog();
        }
    };
    xhttp.open("POST", "search_book.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("searchTerm=" + searchTerm);
}

// Function to open the edit dialog and fill in the form with book data
function editBook(ISBN, title, author, publisher, version, shelf, quantity) {
    document.getElementById('editIsbn').value = ISBN;
    document.getElementById('editTitle').value = title;
    document.getElementById('editAuthor').value = author;
    document.getElementById('editPublisher').value = publisher;
    document.getElementById('editVersion').value = version;
    document.getElementById('editShelf').value = shelf;
    document.getElementById('editQuantity').value = quantity;

    document.getElementById('editDialog').style.display = 'block';
}

// Function to close the edit dialog
function closeEditDialog() {
    document.getElementById('editDialog').style.display = 'none';
}

// Function to save the edited book information
function saveEdit() {
    var isbn = document.getElementById('editIsbn').value;
    var title = document.getElementById('editTitle').value;
    var author = document.getElementById('editAuthor').value;
    var publisher = document.getElementById('editPublisher').value;
    var version = document.getElementById('editVersion').value;
    var shelf = document.getElementById('editShelf').value;
    var quantity = document.getElementById('editQuantity').value;

    // AJAX request to update book information
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            closeEditDialog();
            refreshBookTable();
        }
    };
    xhttp.open("POST", "update_book.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("isbn=" + isbn + "&title=" + title + "&author=" + author + "&publisher=" + publisher + "&version=" + version + "&shelf=" + shelf + "&quantity=" + quantity);
}

function confirmDelete() {
    var confirmDelete = confirm("Are you sure you want to delete this book?");
    if (confirmDelete) {
        deleteBook();
    }
}

// Function to delete the book data
function deleteBook() {
    var isbn = document.getElementById('editIsbn').value;

    // AJAX request to delete the book
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                alert(this.responseText);
                closeEditDialog();
                refreshBookTable();
            } else {
                alert("Error deleting the book. Please try again.");
            }
        }
    };
    xhttp.open("POST", "delete_book.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("isbn=" + isbn);
}