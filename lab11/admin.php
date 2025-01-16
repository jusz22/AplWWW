<?php
require_once 'includes/config.php';
require_once 'products.php';
session_start();

function FormularzLogowania()
{
    $wynik = 
    '<div class="logowanie">
        <h1 class="heading">Panel logowania</h1>
        <div class="logowanie">
        <form method="post" name="loginForm" enctype="multipart/form-data" action="'.($_SERVER["REQUEST_URI"]).'">
            <table class="logowanie">
                <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class ="logowanie" /></td></tr>
                <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class ="logowanie" /></td></tr>
                <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj" /></td></tr>
            </table>
        </form>
        </div>
    </div>';

    return $wynik;
}

$query = "SELECT * FROM categories ORDER BY parent_id, name";
$result = mysqli_query($GLOBALS['link'], $query);

$categories = array();
while ($row = mysqli_fetch_array($result)) {
    $categories[$row['parent_id']][] = $row;
}

function wyswietlDrzewoKategorii($categories, $parent_id = 0, $level = 0)
{
    if (!isset($categories[$parent_id])) {
        return;
    }

    foreach ($categories[$parent_id] as $category) {
        $indent = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level);
        echo $indent . "ID: " . $category['id'] .
            " - Name: " . $category['name'] .
            " - Parent ID: " . $category['parent_id'] . "<br />";
        wyswietlDrzewoKategorii($categories, $category['id'], $level + 1);
    }
}

function addCategory($name, $parent_id = NULL)
{
    $query = "INSERT INTO categories (name, parent_id) VALUES ('$name', " . ($parent_id ? "'$parent_id'" : 0) . ")";
    mysqli_query($GLOBALS['link'], $query);
}

function deleteCategory($id)
{
    $query = "DELETE FROM categories WHERE id = $id";
    return mysqli_query($GLOBALS['link'], $query);
}

function editCategory($id, $name, $parent_id = null)
{
    $query = "UPDATE categories SET name = '$name', parent_id = " . ($parent_id ? "'$parent_id'" : "NULL") . " WHERE id = $id";
    return mysqli_query($GLOBALS['link'], $query);
}

if (isset($_POST['x1_submit'])) {
    $login_email = $_POST['login_email'];
    $login_pass = $_POST['login_pass'];

    if ($login_email === $login && $login_pass === $pass) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_email'] = $login_email;
    } else {
        echo "Błędny login lub hasło.";
        echo FormularzLogowania();
        exit;
    }
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo '<style>
        .section { 
            margin: 20px 0; 
            padding: 20px; 
            border: 1px solid #ccc; 
        }
        form { margin: 10px 0; }
        input, textarea, select { 
            margin: 5px 0; 
            padding: 5px; 
            width: 300px; 
        }
        h1 { 
            background: #f0f0f0; 
            padding: 10px; 
            margin-top: 20px; 
        }
    </style>';

    echo '<h1>Category Management</h1>';
    
    // Obsłuż operacje na kategoriach
    if (isset($_POST['add_category'])) {
        $name = $_POST['category_name'];
        $parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : null;
        addCategory($name, $parent_id);
    }

    if (isset($_POST['delete_category'])) {
        $id = $_POST['category_id'];
        deleteCategory($id);
    }

    if (isset($_POST['edit_category'])) {
        $id = $_POST['edit_category_id'];
        $name = $_POST['edit_category_name'];
        $parent_id = $_POST['edit_parent_id'] ? $_POST['edit_parent_id'] : null;
        editCategory($id, $name, $parent_id);
    }

    // Wyświetl kategorie
    echo '<div class="section">';
    echo '<h2>Current Categories</h2>';
    if (!empty($categories)) {
        wyswietlDrzewoKategorii($categories);
    } else {
        echo "No categories found.";
    }
    echo '</div>';

    echo '<div class="section">';
    echo '<h2>Add Category</h2>';
    echo '<form method="post">
            <input type="text" name="category_name" placeholder="Category Name" required />
            <input type="text" name="parent_id" placeholder="Parent ID (optional)" />
            <input type="submit" name="add_category" value="Add Category" />
          </form>';

    echo '<h2>Delete Category</h2>';
    echo '<form method="post">
            <input type="number" name="category_id" placeholder="Category ID" required />
            <input type="submit" name="delete_category" value="Delete Category" />
          </form>';

    echo '<h2>Edit Category</h2>';
    echo '<form method="post">
            <input type="number" name="edit_category_id" placeholder="Category ID" required />
            <input type="text" name="edit_category_name" placeholder="New Category Name" required />
            <input type="text" name="edit_parent_id" placeholder="New Parent ID (optional)" />
            <input type="submit" name="edit_category" value="Edit Category" />
          </form>';
    echo '</div>';

    echo '<h1>Product Management</h1>';
    
    // Obsłuż operacje na produktach
    if (isset($_POST['add_product'])) {
        DodajProdukt(
            $GLOBALS['link'],
            $_POST['title'],
            $_POST['description'],
            date('Y-m-d'),
            date('Y-m-d'),
            $_POST['expiry_date'],
            $_POST['net_price'],
            $_POST['vat'],
            $_POST['stock'],
            $_POST['availability_status'],
            $_POST['category'],
            $_POST['size'],
            $_POST['image']
        );
    }

    if (isset($_POST['delete_product'])) {
        UsunProdukt($GLOBALS['link'], $_POST['product_id']);
    }

    if (isset($_POST['edit_product'])) {
        $fields = array(
            'title' => $_POST['edit_title'],
            'description' => $_POST['edit_description'],
            'modification_date' => date('Y-m-d'),
            'expiry_date' => $_POST['edit_expiry_date'],
            'net_price' => $_POST['edit_net_price'],
            'vat' => $_POST['edit_vat'],
            'stock' => $_POST['edit_stock'],
            'availability_status' => $_POST['edit_availability_status'],
            'category' => $_POST['edit_category'],
            'size' => $_POST['edit_size'],
            'image' => $_POST['edit_image']
        );
        EdytujProdukt($GLOBALS['link'], $_POST['edit_product_id'], $fields);
    }

    // Wyświetl produkty
    echo '<div class="section">';
    echo '<h2>Current Products</h2>';
    PokazProdukty($GLOBALS['link']);
    echo '</div>';

    echo '<div class="section">';
    echo '<h2>Add Product</h2>';
    echo '<form method="post">
            <input type="text" name="title" placeholder="Product Title" required />
            <textarea name="description" placeholder="Product Description" required></textarea>
            <input type="date" name="expiry_date" />
            <input type="number" step="0.01" name="net_price" placeholder="Net Price" required />
            <input type="number" step="0.01" name="vat" placeholder="VAT %" required />
            <input type="number" name="stock" placeholder="Stock" required />
            <select name="availability_status" required>
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
            <input type="text" name="category" placeholder="Category" required />
            <input type="text" name="size" placeholder="Size" required />
            <input type="text" name="image" placeholder="Image URL" required />
            <input type="submit" name="add_product" value="Add Product" />
          </form>';

    echo '<h2>Delete Product</h2>';
    echo '<form method="post">
            <input type="number" name="product_id" placeholder="Product ID" required />
            <input type="submit" name="delete_product" value="Delete Product" />
          </form>';

    echo '<h2>Edit Product</h2>';
    echo '<form method="post">
            <input type="number" name="edit_product_id" placeholder="Product ID" required />
            <input type="text" name="edit_title" placeholder="New Title" />
            <textarea name="edit_description" placeholder="New Description"></textarea>
            <input type="date" name="edit_expiry_date" />
            <input type="number" step="0.01" name="edit_net_price" placeholder="New Net Price" />
            <input type="number" step="0.01" name="edit_vat" placeholder="New VAT %" />
            <input type="number" name="edit_stock" placeholder="New Stock" />
            <select name="edit_availability_status">
                <option value="available">Available</option>
                <option value="unavailable">Unavailable</option>
            </select>
            <input type="text" name="edit_category" placeholder="New Category" />
            <input type="text" name="edit_size" placeholder="New Size" />
            <input type="text" name="edit_image" placeholder="New Image URL" />
            <input type="submit" name="edit_product" value="Edit Product" />
          </form>';
    echo '</div>';

} else {
    echo FormularzLogowania();
}
?>