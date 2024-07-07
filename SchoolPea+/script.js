var stripe = Stripe('pk_test_51PMPWY04hLVR8JEwaYxYJ3YDycRhKoOm168niuDBafcMgwfVewdHsMszYSCDvwLBPx4UTeTipQXTWBI7mBo6A4R7000FL8jc2N');

var elements = stripe.elements();

var cardElement = elements.create('card');

cardElement.mount('#card-element');

document.querySelector('#subscriptionForm').addEventListener('submit', function(e) {
    e.preventDefault();

    stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
    }).then(function(result) {
        if (result.error) {
            document.getElementById('card-errors').textContent = result.error.message;
        } else {
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
                    window.location.href = 'https://schoolpea.com/SchoolPea+/subscription-success.html';
                }
            });
        }
    });
});
