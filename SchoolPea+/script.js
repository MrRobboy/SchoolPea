// Assurez-vous que Stripe est initialisé avec votre clé publique
var stripe = Stripe('pk_test_51PMPWY04hLVR8JEwaYxYJ3YDycRhKoOm168niuDBafcMgwfVewdHsMszYSCDvwLBPx4UTeTipQXTWBI7mBo6A4R7000FL8jc2N');

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
    event.preventDefault(); // Empêche l'envoi du formulaire par défaut

    // Désactive le bouton de soumission pendant le traitement
    form.querySelector('button').disabled = true;

    // Création du paiement avec Stripe
    stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
        billing_details: {
            email: document.getElementById('email').value
        }
    }).then(function(result) {
        if (result.error) {
            // Gestion des erreurs de validation de la carte
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            // Réactivation du bouton de soumission
            form.querySelector('button').disabled = false;
        } else {
            // Récupération de l'ID du moyen de paiement
            var paymentMethodId = result.paymentMethod.id;

            // Envoi des données au serveur via fetch
            fetch('/create-subscription.php', {
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
                // Gestion de la réponse du serveur
                console.log(result);
                if (result.error) {
                    // Gestion des erreurs côté serveur
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error;
                } else {
                    // Redirection vers la page de succès
                    window.location.href = '/success.html';
                }
            }).catch(function(error) {
                // Gestion des erreurs réseau ou autres
                console.error('Error:', error);
                // Réactivation du bouton de soumission
                form.querySelector('button').disabled = false;
            });
        }
    });
});
