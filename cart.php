<?php
$page_title = "Shopping Cart";
$custom_css = "cart.css"; // Load cart-specific styles
include_once 'header.php';
?>

    <!-- Shopping Cart Section -->
    <div class="cart">
        <h1>Your Shopping Cart</h1>
        <div class="cart__container" id="cart-items">
            <p class="empty-cart">Your cart is empty.</p>
        </div>
        <div class="cart__actions" id="cart-actions" style="display: none;">
            <h2>Total: <span id="cart-total">RM 0.00</span></h2>
            <button class="checkout-button">Proceed to Checkout</button>
        </div>
    </div>

<?php
    include_once 'footer.php'
?>
