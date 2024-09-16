document.getElementById('productForm').addEventListener('submit', function(event) {
    var quantity = document.getElementById('itemQuantity').value;
    var price = document.getElementById('itemPrice').value;
    var quantityError = document.getElementById('quantity-error');
    var priceError = document.getElementById('price-error');
    var formMessage = document.getElementById('form-message');

    quantityError.style.display = 'none';
    priceError.style.display = 'none';
    formMessage.className = 'alert'; // Reset class

    var hasError = false;

    if (quantity < 0) {
        quantityError.innerHTML = "Quantity cannot be negative";
        quantityError.style.display = 'block';
        hasError = true;
    }

    if (price < 0) {
        priceError.innerHTML = "Price cannot be negative";
        priceError.style.display = 'block';
        hasError = true;
    }

    if (hasError) {
        event.preventDefault();
    }
});

function updateCategoryID() {
    const categorySelect = document.getElementById('category');
    const categoryIDLabel = document.getElementById('categoryIDLabel');
    const categoryIDInput = document.getElementById('categoryID');
    
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    const categoryID = selectedOption.value;

    categoryIDLabel.textContent = `Category ID: ${categoryID}`;
    categoryIDInput.value = categoryID;
}

// Display message if set
document.addEventListener('DOMContentLoaded', function() {
    var formMessage = document.getElementById('form-message');
    formMessage.style.display = 'block';
    formMessage.innerHTML = formMessage.dataset.message;
    formMessage.className += ' ' + formMessage.dataset.messageClass;
});