<?php
include "database_connection.php";

// Fetch categories
$cat_stmt = $conn->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

$Products = [];

foreach ($categories as $cat) {
    // Fetch products for this category
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->execute([$cat['id']]);
    $prods = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $formatted_products = [];
    foreach ($prods as $p) {
        $formatted_products[] = [
            "ProductId" => $p['product_id'],
            "Title" => $p['title'],
            "Name" => $p['name'],
            "Image" => $p['image'],
            "Price" => "$".$p['price'],
            "LessPrice" => "$".$p['less_price'],
            "Off" => $p['off'],
            "Specification" => [
                "Ram" => $p['ram'],
                "HardDrive" => $p['hard_drive'],
                "ScreenSize" => $p['screen_size']
            ]
        ];
    }

    $Products[] = [
        "category" => $cat['name'],
        "Products" => $formatted_products
    ];
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($Products, JSON_PRETTY_PRINT);
?>
