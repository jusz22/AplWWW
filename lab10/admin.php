<?php
require_once 'includes/config.php';
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

function addCategory($name, $parent_id = null) {
    $query = "INSERT INTO categories (name, parent_id) VALUES ('$name', ".($parent_id ? "'$parent_id'" : "NULL").")";
    return mysqli_query($GLOBALS['link'], $query);
}

function deleteCategory($id) {
    $query = "DELETE FROM categories WHERE id = $id";
    return mysqli_query($GLOBALS['link'], $query);
}

function showCategories() {
    $query = "SELECT * FROM categories";
    $result = mysqli_query($GLOBALS['link'], $query);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_array($result)) {
            echo 'ID: ' . $row['id'] . ' - Name: ' . $row['name'] . ' - Parent ID: ' . $row['parent_id'] . '<br />';
        }
    } else {
        echo "No categories found.";
    }
}

function editCategory($id, $name, $parent_id = null) {
    $query = "UPDATE categories SET name = '$name', parent_id = ".($parent_id ? "'$parent_id'" : "NULL")." WHERE id = $id";
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
    if (isset($_POST['add_category'])) {
        $name = $_POST['category_name'];
        $parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : null;
        addCategory($name, $parent_id);
        $_POST['category_name'] = NULL;
        echo "Category added successfully.";
    }

    if (isset($_POST['delete_category'])) {
        $id = $_POST['category_id'];
        deleteCategory($id);
        echo "Category deleted successfully.";
    }

    if (isset($_POST['edit_category'])) {
        $id = $_POST['edit_category_id'];
        $name = $_POST['edit_category_name'];
        $parent_id = $_POST['edit_parent_id'] ? $_POST['edit_parent_id'] : null;
        editCategory($id, $name, $parent_id);
        echo "Category edited successfully.";
    }

    echo '<h2>Categories</h2>';
    showCategories();

    echo '<h2>Add Category</h2>';
    echo '<form method="post" action="">
            <input type="text" name="category_name" placeholder="Category Name" required />
            <input type="text" name="parent_id" placeholder="Parent ID (optional)" />
            <input type="submit" name="add_category" value="Add Category" />
          </form>';

    echo '<h2>Delete Category</h2>';
    echo '<form method="post" action="">
            <input type="number" name="category_id" placeholder="Category ID" required />
            <input type="submit" name="delete_category" value="Delete Category" />
          </form>';

    echo '<h2>Edit Category</h2>';
    echo '<form method="post" action="">
            <input type="number" name="edit_category_id" placeholder="Category ID" required />
            <input type="text" name="edit_category_name" placeholder="New Category Name" required />
            <input type="text" name="edit_parent_id" placeholder="New Parent ID (optional)" />
            <input type="submit" name="edit_category" value="Edit Category" />
          </form>';
} else {
    echo FormularzLogowania();
}
?>