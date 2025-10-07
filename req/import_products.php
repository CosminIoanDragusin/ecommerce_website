<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommercedb";

// Connect
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read JSON
$json = file_get_contents("../products.json");
$data = json_decode($json, true);

// Prepare insert statement
$stmt = $conn->prepare("INSERT INTO products (product_id, category_id, title, name, image, price, less_price, off, ram, hard_drive, screen_size) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($data as $categoryIndex => $categoryData) {
    $category_id = $categoryIndex + 1; // assign category_id starting from 1
    foreach ($categoryData['Products'] as $product) {
        $product_id = $product['ProductId'];
        $title = $product['Title'];
        $name = $product['Name'];
        $image = $product['Image'];

        // Convert price strings to decimal
        $price = floatval(str_replace(['$', ','], '', $product['Price']));
        $less_price = floatval(str_replace(['$', ','], '', $product['LessPrice']));

        $off = $product['Off'] ?? null;
        $ram = $product['Specification']['Ram'] ?? null;
        $hard_drive = $product['Specification']['HardDrive'] ?? null;
        $screen_size = $product['Specification']['ScreenSize'] ?? null;

        // Bind parameters
        $stmt->bind_param(
            "sissddsssss",
            $product_id,
            $category_id,
            $title,
            $name,
            $image,
            $price,
            $less_price,
            $off,
            $ram,
            $hard_drive,
            $screen_size
        );

        $stmt->execute();
    }
}

$stmt->close();
$conn->close();

echo "Products imported successfully!";
?>
