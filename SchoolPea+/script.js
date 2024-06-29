var stripe = Stripe('pk_test_51PMPWY04hLVR8JEwaYxYJ3YDycRhKoOm168niuDBafcMgwfVewdHsMszYSCDvwLBPx4UTeTipQXTWBI7mBo6A4R7000FL8jc2N');

// Create an instance of elements
var elements = stripe.elements();

// Create a card element
var cardElement = elements.create('card');

// Mount the card element into the card element container
cardElement.mount('#card-element');

// Handle form submission
document.querySelector('#subscriptionForm').addEventListener('submit', function(e) {
    e.preventDefault();

    stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
    }).then(function(result) {
        if (result.error) {
            // Display errors
            document.getElementById('card-errors').textContent = result.error.message;
        } else {
            // Send PaymentMethod ID to server
            fetch('./create-subscription.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: document.getElementById('email').value, paymentMethodId: result.paymentMethod.id })
            }).then(function(response) {
                return response.json();
            }).then(function(subscription) {
                if (subscription.error) {
                    document.getElementById('card-errors').textContent = subscription.error;
                } else {
                    // Redirect to confirmation page with subscriptionId
                    window.location.href = 'https://schoolpea.com/SchoolPea+/subscription-success.html';
                }
            });
        }
    });
});
