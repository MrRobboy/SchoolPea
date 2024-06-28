// Assurez-vous que Stripe est initialisé avec votre clé secrète
var stripe = Stripe('pk_test_51PMPWY04hLVR8JEwaYxYJ3YDycRhKoOm168niuDBafcMgwfVewdHsMszYSCDvwLBPx4UTeTipQXTWBI7mBo6A4R7000FL8jc2N');
///clé test: pk_test_51PMPWY04hLVR8JEwaYxYJ3YDycRhKoOm168niuDBafcMgwfVewdHsMszYSCDvwLBPx4UTeTipQXTWBI7mBo6A4R7000FL8jc2N
///clé public : pk_live_51PMPWY04hLVR8JEwxX6LQLdLVsp7iMDvk9Pst8lVlz0PV5xqY3S4AahKWbeVkvSdWf9KA5DyQtMEcBnFmZSCWAxd00PCDKAU8D
// Configuration de l'élément card
var elements = stripe.elements();
var cardElement = elements.create('card');
cardElement.mount('#card-element');

// Gestion des erreurs de validation de la carte
cardElement.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Gestion de la soumission du formulaire
var form = document.getElementById('subscriptionForm');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
        billing_details: {
            email: document.getElementById('email').value
        }
    }).then(function(result) {
        if (result.error) {
            // Gestion des erreurs
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Envoi des données au serveur (ex: via fetch ou XMLHttpRequest)
            var paymentMethodId = result.paymentMethod.id;
            fetch('create-subscription.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: document.getElementById('email').value,
                    payment_method: paymentMethodId
                })
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                // Gestion de la réponse du serveur (ex: redirection)
                console.log(result);
                window.location.href = 'success.php';
            });
        }
    });
});
