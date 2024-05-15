document.addEventListener("DOMContentLoaded", function() {
    // Get the form element
    var orderForm = document.getElementById("orderForm");

    // Add event listener for form submission
    orderForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission
        
        // Perform additional validation or processing if needed
        
        // Display alert message to ensure order has been placed
        alert("Your order has been placed successfully!");
        
        // Submit the form (optional)
        // orderForm.submit();
    });
});