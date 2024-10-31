<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form with PayPal and Stripe</title>
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency=USD"></script> <!-- PayPal SDK -->
    <script src="https://js.stripe.com/v3/"></script> <!-- Stripe SDK -->
    
    <script>
        async function convertCurrency() {
            const amount = document.getElementById('amount').value;
            const currency = document.getElementById('currency').value;

            if (!amount || amount <= 0) {
                document.getElementById('convertedAmount').innerHTML = "Please enter a valid amount.";
                return;
            }

            // Fetch the exchange rate using PHP API
            const response = await fetch('get_exchange_rate.php?currency=' + currency);
            const data = await response.json();

            if (data.success) {
                const rate = data.rate;
                const converted = amount * rate;
                document.getElementById('convertedAmount').innerHTML = 
                    `Converted Amount in USD: ${converted.toFixed(2)} USD`;

                // Update PayPal and Stripe amounts
                updatePayPalButton(converted);
                updateStripeButton(converted);
            } else {
                document.getElementById('convertedAmount').innerHTML = "Failed to fetch exchange rate.";
            }
        }

        // PayPal setup
        function updatePayPalButton(amount) {
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: amount.toFixed(2) // USD amount
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Transaction completed by ' + details.payer.name.given_name);
                    });
                }
            }).render('#paypal-button-container'); // Display PayPal button
        }

        // Stripe setup
        function updateStripeButton(amount) {
            const stripe = Stripe('YOUR_STRIPE_PUBLISHABLE_KEY');
            const checkoutButton = document.getElementById('stripe-button');

            checkoutButton.addEventListener('click', function() {
                fetch('create_stripe_session.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        amount: amount
                    }),
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(sessionId) {
                    return stripe.redirectToCheckout({ sessionId: sessionId });
                })
                .then(function(result) {
                    if (result.error) {
                        alert(result.error.message);
                    }
                });
            });
        }

        window.onload = function() {
            // Initialize PayPal and Stripe buttons with default amount
            updatePayPalButton(1); // Default to $1
            updateStripeButton(1); // Default to $1
        };
    </script>
</head>
<body>

    <h2>Donation Form with Real-Time Exchange Calculation</h2>

    <form>
        <!-- Donor Details -->
        <label for="name">Full Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <!-- Donation Amount and Currency -->
        <label for="amount">Donation Amount:</label><br>
        <input type="number" id="amount" name="amount" required oninput="convertCurrency()"><br><br>

        <label for="currency">Currency:</label><br>
        <select id="currency" name="currency" onchange="convertCurrency()">
            <option value="USD">USD - United States Dollar</option>
            <option value="EUR">EUR - Euro</option>
            <option value="GBP">GBP - British Pound</option>
            <!-- Add more currencies as needed -->
        </select><br><br>

        <!-- Converted Amount Display -->
        <div id="convertedAmount"></div><br>

        <!-- PayPal Button -->
        <div id="paypal-button-container"></div><br>

        <!-- Stripe Button -->
        <button type="button" id="stripe-button">Donate with Stripe</button>

    </form>

</body>
</html>
