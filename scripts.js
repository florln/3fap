document.addEventListener('DOMContentLoaded', function() {
    var stripe = Stripe('pk_test_51PFPjeKp3re07QXISxiYwTiQiAyXgXPdqduzF9ul0nqyaVxfI82USePPscNloRd1BofJtkxpEYRXDZI9uuYyPZMF00LEX4bnvM');
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    var form = document.getElementById('payment-form');
    var submitButton = document.getElementById('submit-payment');
    var errorElement = document.getElementById('card-errors');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        submitButton.disabled = true;

        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                errorElement.textContent = result.error.message;
                submitButton.disabled = false;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {
        // Envoyer le token à votre serveur pour effectuer le paiement
        fetch('traitement_paiement.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                token: token.id
            })
        }).then(function(response) {
            return response.json();
        }).then(function(data) {
            if (data.success) {
                // Rediriger l'utilisateur vers une page de paiement réussi
                window.location.href = 'paiement_reussi.php';
            } else {
                errorElement.textContent = data.error;
                submitButton.disabled = false;
            }
        });
    }
});
