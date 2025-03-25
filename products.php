<?php
    $page_title = "Product Listing";
    $custom_css = "products.css";
    include_once 'header.php'
?>

    <!-- Product Listing Section -->
    <div class="products">
        <h1>Explore Our Phones</h1>
        <div class="products__container">
            <div class="product__card">
                <img src="images/S25.jpg" alt="Samsung Galaxy S25 Ultra">
                <h2>Samsung Galaxy S25 Ultra</h2>
                <p>RM 7199</p>
                <button class="button add-to-cart" data-name="Samsung Galaxy S25 Ultra" data-price="7199" data-image="images/S25.jpg">Add to Cart</button>
            </div>
            <div class="product__card">
                <img src="images/Reno13.png" alt="Phone 2">
                <h2>Oppo Reno 13</h2>
                <p>RM 2399</p>
                <button class="button add-to-cart" data-name="Oppo Reno 13" data-price="2399" data-image="images/Reno13.png">Add to Cart</button>
            </div>
            <div class="product__card">
                <img src="images/S24.webp" alt="Phone 3">
                <h2>Samsung Galaxy S24 Ultra</h2>
                <p>RM 4999</p>
                <button class="button add-to-cart" data-name="Samsung Galaxy S24 Ultra" data-price="4999" data-image="images/S24.webp">Add to Cart</button>
            </div>
        </div>
    </div>

<?php
    include_once 'footer.php'
?>