
var stripe = Stripe('pk_test_51PMPWY04hLVR8JEwaYxYJ3YDycRhKoOm168niuDBafcMgwfVewdHsMszYSCDvwLBPx4UTeTipQXTWBI7mBo6A4R7000FL8jc2N');
///clé test: pk_test_51PMPWY04hLVR8JEwaYxYJ3YDycRhKoOm168niuDBafcMgwfVewdHsMszYSCDvwLBPx4UTeTipQXTWBI7mBo6A4R7000FL8jc2N
///clé public : pk_live_51PMPWY04hLVR8JEwxX6LQLdLVsp7iMDvk9Pst8lVlz0PV5xqY3S4AahKWbeVkvSdWf9KA5DyQtMEcBnFmZSCWAxd00PCDKAU8D

// Créez une instance de Stripe
// Créez une instance d'elements
var elements = stripe.elements();

// Créez un élément de carte
var cardElement = elements.create('card');

// Montez l'élément de carte dans le conteneur de l'élément de carte
cardElement.mount('#card-element');
// Lorsque l'utilisateur soumet le formulaire
document.querySelector('#subscriptionForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Créez un PaymentMethod avec les détails de la carte
    stripe.createPaymentMethod({
        type: 'card',
        card: document.getElementById('card-element'),
    }).then(function(result) {
        if (result.error) {
            // Affichez les erreurs
            document.getElementById('card-errors').textContent = result.error.message;
        } else {
            // Envoyez l'ID du PaymentMethod au serveur
            fetch('/create-subscription.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: document.getElementById('email').value, paymentMethodId: result.paymentMethod.id })
            }).then(function(response) {
                return response.json();
            }).then(function(subscription) {
                console.log('Subscription created!', subscription);
            });
        }
    });
});
