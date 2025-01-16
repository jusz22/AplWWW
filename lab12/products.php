<?php
require_once 'includes/config.php';

$link = $GLOBALS['link'];

// Initialize or retrieve the basket from the session
session_start();
if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = [];
}

/**
 * Add item to the basket
 */
function DodajDoKoszyka($productId, $productTitle, $priceAfterVat)
{
    if (!isset($_SESSION['basket'][$productId])) {
        $_SESSION['basket'][$productId] = [
            'title' => $productTitle,
            'priceAfterVat' => $priceAfterVat,
            'quantity' => 1,
        ];
    } else {
        $_SESSION['basket'][$productId]['quantity']++;
    }
}

/**
 * Update item quantity in the basket
 */
function ZaktualizujKoszyk($productId, $quantity)
{
    if (isset($_SESSION['basket'][$productId])) {
        if ($quantity > 0) {
            $_SESSION['basket'][$productId]['quantity'] = $quantity;
        } else {
            unset($_SESSION['basket'][$productId]); // Remove the item if quantity is zero
        }
    }
}

/**
 * Display the basket
 */
function PokazKoszyk()
{
    echo "<h2>Basket</h2>";
    if (empty($_SESSION['basket'])) {
        echo "<p>Your basket is empty.</p>";
    } else {
        echo "<form method='post' action=''>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>Title</th>
                <th>Price (after VAT)</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
              </tr>";
        foreach ($_SESSION['basket'] as $productId => $item) {
            $total = $item['priceAfterVat'] * $item['quantity'];
            echo "<tr>
                    <td>{$item['title']}</td>
                    <td>{$item['priceAfterVat']}</td>
                    <td>
                        <input type='number' name='quantities[{$productId}]' value='{$item['quantity']}' min='0'>
                    </td>
                    <td>{$total}</td>
                    <td>
                        <button type='submit' name='update_basket' value='{$productId}'>Update</button>
                    </td>
                  </tr>";
        }
        echo "</table>";
        echo "<button type='submit' name='update_all'>Update All</button>";
        echo "</form>";
    }
}


/**
 * Show all products in the database with "Add to Basket" buttons
 */
function PokazProdukty($link)
{
    $sql = "SELECT * FROM products";
    $result = mysqli_query($link, $sql);

    if ($result) {
        echo "<div style='font-family: Arial; font-size: 14px;'>\n";
        while ($product = mysqli_fetch_assoc($result)) {
            $priceAfterVat = $product['net_price'] + ($product['net_price'] * $product['vat'] / 100);
            echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>\n";
            echo "<strong>ID:</strong> {$product['id']}<br>\n";
            echo "<strong>Title:</strong> {$product['title']}<br>\n";
            echo "<strong>Description:</strong> {$product['description']}<br>\n";
            echo "<strong>Net Price:</strong> {$product['net_price']}<br>\n";
            echo "<strong>VAT:</strong> {$product['vat']}<br>\n";
            echo "<strong>Price (After VAT):</strong> {$priceAfterVat}<br>\n";
            echo "<strong>Stock:</strong> {$product['stock']}<br>\n";
            echo "<strong>Availability:</strong> {$product['availability_status']}<br>\n";
            echo "<strong>Category:</strong> {$product['category']}<br>\n";
            echo "<strong>Size:</strong> {$product['size']}<br>\n";
            echo "<strong>Image:</strong> <img src='{$product['image']}' alt='{$product['title']}' style='max-width: 100px;'><br>\n";
            echo "<form method='post' action=''>
                    <input type='hidden' name='product_id' value='{$product['id']}'>
                    <input type='hidden' name='product_title' value='{$product['title']}'>
                    <input type='hidden' name='price_after_vat' value='{$priceAfterVat}'>
                    <button type='submit' name='add_to_basket'>Add to Basket</button>
                  </form>";
            echo "</div>\n";
        }
        echo "</div>\n";
    } else {
        echo "<p style='color: red;'>Error fetching products: " . mysqli_error($link) . "</p>\n";
    }
}

// Handle "Add to Basket" button submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_basket'])) {
        $productId = (int)$_POST['product_id'];
        $productTitle = $_POST['product_title'];
        $priceAfterVat = (float)$_POST['price_after_vat'];

        DodajDoKoszyka($productId, $productTitle, $priceAfterVat);

        // Redirect to the same page to prevent resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Handle updating a single item's quantity
    if (isset($_POST['update_basket'])) {
        $productId = (int)$_POST['update_basket'];
        $quantities = $_POST['quantities'];
        if (isset($quantities[$productId])) {
            ZaktualizujKoszyk($productId, (int)$quantities[$productId]);
        }

        // Redirect to the same page to prevent resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Handle updating all quantities in the basket
    if (isset($_POST['update_all']) && isset($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $productId => $quantity) {
            ZaktualizujKoszyk((int)$productId, (int)$quantity);
        }

        // Redirect to the same page to prevent resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Create the table if it doesn't exist
StworzTabele($link);

// Display the basket at the top of the page
PokazKoszyk();

// Display all products with "Add to Basket" buttons
PokazProdukty($link);



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


