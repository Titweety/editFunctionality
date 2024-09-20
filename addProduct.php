<?php
require_once('function.php');
require_once('product.class.php');

$name = $category = $price = $availability = '';
$nameErr = $categoryErr = $priceErr = $availabilityErr = ''; // Fixed typo here

$productObj = new Product();

if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty("ddd")) { // Retained the condition

    $name = clean_input($_POST['name']);
    $category = clean_input($_POST['category']);
    $price = clean_input($_POST['price']);
    $availability = clean_input($_POST['availability']) ? clean_input($_POST['availability']) : ''; // Ensured availability is set

    if (empty($name)) {
        $nameErr = 'Name is required';
    }

    if (empty($category)) {
        $categoryErr = 'Category is required';
    }

    if (empty($price)) {
        $priceErr = 'Price is required';
    } else if (!is_numeric($price)) {
        $priceErr = 'Price should be a number';
    } else if ($price < 1) {
        $priceErr = 'Price must be greater than 0';
    }

    if (empty($availability)) {
        $availabilityErr = 'Available is required'; // Fixed typo here
    }

    if (empty($codeErr) && empty($nameErr) && empty($categoryErr) && empty($priceErr) && empty($availabilityErr)) { // Retained $codeErr

        $productObj->name = $name;
        $productObj->category = $category;
        $productObj->price = $price;
        $productObj->availability = $availability;

        if ($productObj->add()) {
            header('Location: product.php');
            exit();
        } else {
            echo 'Something went wrong when adding the new product.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <span class="error">* are required fields</span>
        <br>
        <label for="name">Name</label><span class="error">*</span>
        <br>
        <input type="text" name="name" id="name" value="<?= $name ?>">
        <br>
        <?php if (!empty($nameErr)): ?>
            <span class="error"><?= $nameErr ?></span>
            <br>
        <?php endif; ?>

        <label for="category">Category</label><span class="error">*</span>
        <br>
        <select name="category" id="category">
            <option value="">--Select Category--</option>
            <option value="Gadget" <?= (isset($category) && $category == 'Gadget') ? 'selected' : ''?>>Gadget</option>
            <option value="Toys" <?= (isset($category) && $category == 'Toys') ? 'selected' : ''?>>Toy</option>
        </select>
        <br>
        <?php if (!empty($categoryErr)): ?>
            <span class="error"><?= $categoryErr ?></span>
            <br>
        <?php endif; ?>

        <label for="price">Price</label><span class="error">*</span>
        <br>
        <input type="text" name="price" id="price" value="<?= $price ?>"> <!-- Price input added -->
        <br>
        <?php if (!empty($priceErr)): ?>
            <span class="error"><?= $priceErr ?></span>
            <br>
        <?php endif; ?>

        <label for="availability">Availability</label><span class="error">*</span>
        <br>
        <input type="radio" value="In Stock" name="availability" id="instock" <?= ($availability == 'In Stock') ? 'checked' : ''?>>
        <label for="instock">In Stock</label>
        <input type="radio" value="No Stock" name="availability" id="nostock" <?= ($availability == 'No Stock') ? 'checked' : ''?>>
        <label for="nostock">No Stock</label>
        <br>
        <?php if (!empty($availabilityErr)): ?>
            <span class="error"><?= $availabilityErr ?></span>
            <br>
        <?php endif; ?>
        <br>
        <input type="submit" value="Save Product">
    </form>
</body>
</html>
