<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form with Real-Time Exchange</title>
    <script>
        async function convertCurrency() {
            const amount = document.getElementById('amount').value;
            const currency = document.getElementById('currency').value;

            if (!amount || amount <= 0) {
                document.getElementById('convertedAmount').innerHTML = "Please enter a valid amount.";
                return;
            }

            // Fetch the exchange rate using Fixer API
            console.log('get exchange rate: ');
                
            var data = {};

            try {
                const response = await fetch('get_exchange_rate.php?currency=' + currency);
                data = await response.json();
                console.log('get exchange rate: ', data);
            } catch (error) {
                console.log('get exchange rate: ERROR ', error);
                
            }


            if (data.success) {
                const rate = data.rate;
                const converted = amount * rate;

                document.getElementById('convertedAmount').innerHTML = 
                    `Converted Amount in USD: ${converted.toFixed(2)} USD`;
            } else {
                document.getElementById('convertedAmount').innerHTML = "Failed to fetch exchange rate.";
            }
        }
    </script>
</head>
<body>

    <h2>Donation Form with Real-Time Exchange Calculation</h2>

    <form action="process_donation.php" method="post">
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

        <!-- Payment Method -->
        <label for="payment_method">Payment Method:</label><br>
        <select id="payment_method" name="payment_method" required>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
        </select><br><br>

        <button type="submit">Donate Now</button>
    </form>

</body>
</html>
