<?php
require_once 'includes/config.php';

$link = $GLOBALS['link'];

/**
 * Stwórz tabele jeśli nie istnieje
 */
function StworzTabele($link)
{
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        creation_date DATE NOT NULL,
        modification_date DATE NOT NULL,
        expiry_date DATE,
        net_price DECIMAL(10, 2) NOT NULL,
        vat DECIMAL(5, 2) NOT NULL,
        stock INT NOT NULL,
        availability_status ENUM('available', 'unavailable') NOT NULL,
        category VARCHAR(100) NOT NULL,
        size VARCHAR(50) NOT NULL,
        image VARCHAR(255) NOT NULL
    )";

    if (mysqli_query($link, $sql)) {
        echo "<p style='color: green;'>Table 'products' created successfully or already exists.</p>\n";
    } else {
        echo "<p style='color: red;'>Error creating table: " . mysqli_error($link) . "</p>\n";
    }
}

/**
 * Dodaj nowy produkt do bazy
 */
function DodajProdukt($link, $title, $description, $creationDate, $modificationDate, $expiryDate, $netPrice, $vat, $stock, $availabilityStatus, $category, $size, $image)
{
    $sql = "INSERT INTO products (title, description, creation_date, modification_date, expiry_date, net_price, vat, stock, availability_status, category, size, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssdidssss', $title, $description, $creationDate, $modificationDate, $expiryDate, $netPrice, $vat, $stock, $availabilityStatus, $category, $size, $image);

    if (mysqli_stmt_execute($stmt)) {
        echo "<p style='color: green;'>Product added successfully!</p>\n";
    } else {
        echo "<p style='color: red;'>Error adding product: " . mysqli_error($link) . "</p>\n";
    }

    mysqli_stmt_close($stmt);
}

/**
 * Usuń produkt z bazy po id
 */
function UsunProdukt($link, $id)
{
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<p style='color: green;'>Product deleted successfully!</p>\n";
    } else {
        echo "<p style='color: red;'>Error deleting product: " . mysqli_error($link) . "</p>\n";
    }

    mysqli_stmt_close($stmt);
}

/**
 * Edytuj produkt w bazie
 */
function EdytujProdukt($link, $id, $fields)
{
    $sql = "UPDATE products SET ";
    $setPart = [];
    

    foreach ($fields as $key => $value) {
        $setPart[] = "$key = '$value'";
    }

    $sql .= implode(", ", $setPart) . " WHERE id = $id";
    
    if (mysqli_query($link, $sql)) {
        echo "<p style='color: green;'>Product updated successfully!</p>\n";
    } else {
        echo "<p style='color: red;'>Error updating product: " . mysqli_error($link) . "</p>\n";
    }
}

/**
 * Pokaż wszystkie produkty w bazie
 */
function PokazProdukty($link)
{
    $sql = "SELECT * FROM products";
    $result = mysqli_query($link, $sql);

    if ($result) {
        echo "<div style='font-family: Arial; font-size: 14px;'>\n";
        while ($product = mysqli_fetch_assoc($result)) {
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>\n";
            echo "<strong>ID:</strong> {$product['id']}<br>\n";
            echo "<strong>Title:</strong> {$product['title']}<br>\n";
            echo "<strong>Description:</strong> {$product['description']}<br>\n";
            echo "<strong>Net Price:</strong> {$product['net_price']}<br>\n";
            echo "<strong>VAT:</strong> {$product['vat']}<br>\n";
            echo "<strong>Stock:</strong> {$product['stock']}<br>\n";
            echo "<strong>Availability:</strong> {$product['availability_status']}<br>\n";
            echo "<strong>Category:</strong> {$product['category']}<br>\n";
            echo "<strong>Size:</strong> {$product['size']}<br>\n";
            echo "<strong>Image:</strong> <img src='{$product['image']}' alt='{$product['title']}' style='max-width: 100px;'><br>\n";
            echo "</div>\n";
        }
        echo "</div>\n";
    } else {
        echo "<p style='color: red;'>Error fetching products: " . mysqli_error($link) . "</p>\n";
    }
}

/**
 * Sprawdź dostępność
 */
function SprawdzDostepnosc($product)
{
    $currentDate = date('Y-m-d');
    return $product['availability_status'] === 'available' &&
           $product['stock'] > 0 &&
           ($product['expiry_date'] === null || $product['expiry_date'] > $currentDate);
}

// Stwórz tabele jesli nie istnieje
StworzTabele($link);
