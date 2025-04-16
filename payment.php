<?php
    $page_title = "Payment";
    $custom_css = "payment.css";
    include_once 'header.php'
?>

<!-- Payment Section -->
<div class="payment">
    <h1>Payment Details</h1>
    <div class="payment__container">
        <h2>Order Summary</h2>
        <div class="payment__summary">
            <p>Subtotal: <span id="subtotal">0.00</span></p>
            <p>Tax (10%): <span id="tax">0.00</span></p>
            <p>Total: <span id="total">0.00</span></p>
        </div>
        <h2>Enter Your Payment Information</h2>
        <form class="payment__form" id="payment-form">
            <input type="text" id="card-name" placeholder="Cardholder Name" required>
            <span class="error-message" id="name-error">Please enter a valid name.</span>

            <input type="text" id="card-number" placeholder="Card Number" required>
            <span class="error-message" id="card-error">Please enter a valid 16-digit card number.</span>

            <input type="text" id="expiry-date" placeholder="MM/YY" required>
            <span class="error-message" id="expiry-error">Please enter a valid expiry date (MM/YY).</span>

            <button type="submit">Confirm Payment</button>
        </form>
    </div>
</div>

<?php
    include_once 'footer.php'
?>
