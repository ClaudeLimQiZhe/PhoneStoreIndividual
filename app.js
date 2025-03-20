const menu = document.querySelector("#mobile-menu");
const menuLinks = document.querySelector(".navbar__menu");

menu.addEventListener("click", function () {
    menu.classList.toggle("is-active");
    menuLinks.classList.toggle("active");
});

document.addEventListener("DOMContentLoaded", function () {
    console.log("Page Loaded");

    // 🔹 Login System
    const loginForm = document.getElementById("login-form");
    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();
            const userInput = document.getElementById("login_input");
            const passwordInput = document.getElementById("password");

            if (!userInput || !passwordInput) {
                console.error("Missing login fields!");
                return;
            }

            fetch("login.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ login_input: userInput.value, password: passwordInput.value })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert("Login failed: " + data.message);
                }
            })
            .catch(error => console.error("Fetch Error:", error));
        });
    }

    // 🔹 Get Cart from Local Storage
    let cartItems = JSON.parse(localStorage.getItem("cart")) || [];

    function updateLocalStorage() {
        localStorage.setItem("cart", JSON.stringify(cartItems));
    }

    // 🔹 Add to Cart Functionality
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            const name = this.getAttribute("data-name");
            const price = parseFloat(this.getAttribute("data-price"));
            const image = this.getAttribute("data-image");

            if (!name || isNaN(price) || !image) {
                console.error("Invalid product data:", { name, price, image });
                return;
            }

            let existingItem = cartItems.find(item => item.name === name);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cartItems.push({ name, price, image, quantity: 1 });
            }

            updateLocalStorage();
            updateCartDisplay(); // 🔹 Fix: Update UI immediately
            alert(`${name} added to cart!`);
        });
    });

    console.log("Add to Cart buttons initialized.");

    // 🔹 Cart Logic
    const cartContainer = document.getElementById("cart-items");
    const cartActions = document.getElementById("cart-actions"); // Ensure this exists
    const cartTotal = document.getElementById("cart-total");

    function updateCartDisplay() {
        if (!cartContainer) return;

        cartContainer.innerHTML = "";

        if (cartItems.length === 0) {
            cartContainer.innerHTML = '<p class="empty-cart">Your cart is empty.</p>';
            if (cartActions) cartActions.style.display = "none"; // 🔹 Fix: Ensure cartActions exists
            return;
        }

        if (cartActions) cartActions.style.display = "block"; // Show checkout button when cart has items
        let total = 0;

        cartItems.forEach((item, index) => {
            const cartItem = document.createElement("div");
            cartItem.classList.add("cart__item");
            cartItem.innerHTML = `
                <img src="${item.image}" alt="${item.name}">
                <h2>${item.name}</h2>
                <p>RM ${item.price.toFixed(2)}</p>
                <div class="cart__quantity">
                    <button class="quantity-button decrease" data-index="${index}">-</button>
                    <span>${item.quantity}</span>
                    <button class="quantity-button increase" data-index="${index}">+</button>
                </div>
                <button class="button remove-item" data-index="${index}">Remove</button>
            `;
            cartContainer.appendChild(cartItem);
            total += item.price * item.quantity;
        });

        cartTotal.textContent = `RM ${total.toFixed(2)}`;

        // 🔹 Save updated total and subtotal to localStorage
        localStorage.setItem("cartTotal", total.toFixed(2));
        localStorage.setItem("subtotal", total.toFixed(2)); // Store subtotal before tax
    }

    // 🔹 Ensure Cart Updates on Quantity Changes
    if (cartContainer) {
        cartContainer.addEventListener("click", function (e) {
            const index = e.target.getAttribute("data-index");

            if (e.target.classList.contains("increase")) {
                cartItems[index].quantity++;
            } else if (e.target.classList.contains("decrease")) {
                if (cartItems[index].quantity > 1) {
                    cartItems[index].quantity--;
                } else {
                    cartItems.splice(index, 1);
                }
            } else if (e.target.classList.contains("remove-item")) {
                cartItems.splice(index, 1);
            }

            updateLocalStorage();
            updateCartDisplay();
        });

        updateCartDisplay();
    }

    // 🔹 Checkout Process
    const checkoutButton = document.querySelector(".checkout-button");
    if (checkoutButton) {
        checkoutButton.addEventListener("click", function () {
            if (cartItems.length === 0) {
                alert("Your cart is empty!");
                return;
            }

            let subtotal = parseFloat(localStorage.getItem("subtotal")) || 0;
            let tax = subtotal * 0.1;
            let total = subtotal + tax;

            // Save values to localStorage before going to the payment page
            localStorage.setItem("tax", tax.toFixed(2));
            localStorage.setItem("total", total.toFixed(2));

            console.log("Cart total stored:", { subtotal, tax, total });

            window.location.href = "/handphonestore/payment.html";
        });
    }

    // 🔹 Payment Page Logic
    if (document.getElementById("payment-form")) {
        console.log("Payment Page Loaded");

        let subtotalElem = document.getElementById("subtotal");
        let taxElem = document.getElementById("tax");
        let totalElem = document.getElementById("total");

        let subtotal = parseFloat(localStorage.getItem("subtotal")) || 0;
        let tax = parseFloat(localStorage.getItem("tax")) || 0;
        let total = parseFloat(localStorage.getItem("total")) || 0;

        if (subtotalElem && taxElem && totalElem) {
            subtotalElem.textContent = `RM ${subtotal.toFixed(2)}`;
            taxElem.textContent = `RM ${tax.toFixed(2)}`;
            totalElem.textContent = `RM ${total.toFixed(2)}`;
        }

        document.getElementById("payment-form").addEventListener("submit", function (event) {
            event.preventDefault();

            console.log("Submitting Payment:", { subtotal, tax, total });

            fetch("pvalidation.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ total_amount: total })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Payment successful!");
                    localStorage.clear();
                    window.location.href = "/handphonestore/index.html";
                } else {
                    alert("Payment failed: " + data.message);
                }
            })
            .catch(error => console.error("Payment Error:", error));
        });
    }
});
