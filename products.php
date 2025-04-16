<?php
$page_title = "Product Listing";
$custom_css = "products.css";
include_once 'header.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "phone_shop"; // Your DB name

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Brand ID to Name mapping
$brand_names = [
    1 => 'Apple',
    2 => 'iQoo',
    3 => 'Huawei',
    4 => 'Xiaomi'
];

// Get filters
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$brand = isset($_GET['brand']) ? intval($_GET['brand']) : '';

// Build SQL query
$sql = "SELECT * FROM products";
$conditions = [];

if ($search) {
    $conditions[] = "(model_name LIKE '%$search%')";
}
if ($brand) {
    $conditions[] = "brand = $brand";
}
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

if ($sort == "price_asc") {
    $sql .= " ORDER BY price ASC";
} elseif ($sort == "price_desc") {
    $sql .= " ORDER BY price DESC";
}

$result = $conn->query($sql);
$phones = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $phones[] = $row;
    }
}

$conn->close();
?>

<div class="products">
    <h1>Explore Our Phones</h1>

    <!-- Search, Filter & Sort Form -->
    <form method="GET" class="search-sort-form">
        <input type="text" name="search" placeholder="Search phone..." value="<?= htmlspecialchars($search) ?>">

        <select name="brand">
            <option value="">All Brands</option>
            <?php foreach ($brand_names as $id => $name): ?>
                <option value="<?= $id ?>" <?= $brand == $id ? 'selected' : '' ?>><?= $name ?></option>
            <?php endforeach; ?>
        </select>

        <select name="sort">
            <option value="">Sort by</option>
            <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
            <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
        </select>

        <button type="submit">Apply</button>
        <a href="products.php" class="button clear-button">Clear Filters</a>
    </form>

    <div class="products__container">
        <?php if (empty($phones)): ?>
            <p>No products found.</p>
        <?php else: ?>
            <?php foreach ($phones as $phone): ?>
                <div class="product__card">
                    <img src="images/<?= htmlspecialchars($phone['image']) ?>" alt="<?= htmlspecialchars($phone['model_name']) ?>">
                    <h2><?= htmlspecialchars($phone['model_name']) ?></h2>
                    <p>Brand: <?= $brand_names[$phone['brand']] ?? 'Unknown' ?></p>
                    <p>RM <?= number_format($phone['price'], 2) ?></p>
                    <button class="button add-to-cart"
                            data-name="<?= htmlspecialchars($phone['model_name']) ?>"
                            data-price="<?= $phone['price'] ?>"
                            data-image="images/<?= htmlspecialchars($phone['image']) ?>">
                        Add to Cart
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php 
include_once 'footer.php';
?>
