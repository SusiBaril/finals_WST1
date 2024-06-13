<?php
// Step 1: Database connection

require_once('classes/database.php');
$con = new database();  

// Step 2: Handle request parameters
$categoryId = isset($_GET['cat_id']) && $_GET['cat_id'] != '0' ? filter_input(INPUT_GET, 'cat_id', FILTER_SANITIZE_NUMBER_INT) : null;
$page = isset($_GET['page']) ? filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT) : 1;
$records_per_page = 2;

// Step 3: Fetch products
$products = $con->viewProducts1($categoryId, $page, $records_per_page);

// Step 4: Generate product HTML
foreach ($products as $product) {
    echo "<div class='col-md-4'>\n";
    echo "  <div class='card mb-4'>\n";
    echo "    <img src='" . $product['item_image'] . "' class='card-img-top' alt='" . $product['product_name'] . "'>\n";
    echo "    <div class='card-bodys'>\n";
    echo "      <h5 class='card-titles'>" . $product['product_name'] . "</h5>\n";
    echo "      <p class='card-texts'>" . $product['product_brand'] . "</p>\n";
    echo "      <h2 class='card-prices'>₱" . $product['price'] . "</h2>\n";
    echo "      <div class='checkoutbtns'>\n";
    echo "        <button type='button' class='add-button' data-item-id='" . $product['product_id'] . "' data-image-url='" . $product['item_image'] . "' data-brand='" . $product['product_brand'] . "' data-title='" . $product['product_name'] . "' data-price='" . $product['price'] . "' data-stock='" . $product['stocks'] . "'>Add to Cart</button>\n";
    echo "      </div>\n";
    echo "    </div>\n";
    echo "  </div>\n";
    echo "</div>\n";
}

// Step 5: Pagination links
$total_products = $con->getProductCount($categoryId);
$total_pages = ceil($total_products / $records_per_page);
for ($i = 1; $i <= $total_pages; $i++) {
    // Pagination link HTML
}

// Step 6: AJAX request handling
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Return only the product and pagination HTML
    die();
}
?>