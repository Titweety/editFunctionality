<?php
    require_once('function.php');
    require_once('product.class.php');

    $name = $category = $price = $availability = '';
    $nameErr = $categoryErr = $priceErr = $availabilityErr = '';
    $productObj = new Product();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $record = $productObj->fetchRecord($id);
            if (!empty($record)) {
                $name = $record['name'];
                $category = $record['category'];
                $price = $record['price'];
                $availability = $record['availability'];
            } else {
                echo 'No product found';
                exit;
            }
        } else {
            echo 'No product found';
            exit;
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = clean_input($_GET['id']);
        $name = clean_input($_POST['name']);
        $category = clean_input($_POST['category']);
        $price = clean_input($_POST['price']);
        $availability = clean_input($_POST['availability']) ? clean_input($_POST['availability']) : '';

        if (empty($name)) {
            $nameErr = 'Name is required';
        }
        if (empty($category)) {
            $categoryErr = 'Category is required';
        }

        if (empty($price)) {
            $priceErr = 'Price is required';
        } elseif (!is_numeric($price)) {
            $priceErr = 'Price should be a number';
        } elseif ($price < 1) {
            $priceErr = 'Price must be greater than 0';
        }

        if (empty($availability)) {
            $availabilityErr = 'Availability is required';
        }

        // Keep this check as requested
        if (empty($codeErr) && empty($nameErr) && empty($priceErr) && empty($categoryErr) && empty($availabilityErr)) {
            $productObj->id = $id;
            $productObj->name = $name;
            $productObj->category = $category;
            $productObj->price = $price;
            $productObj->availability = $availability;

            if ($productObj->edit()) {
                header('Location: product.php');
                exit; // Prevent further execution after redirect
            } else {
                echo 'Something went wrong when updating the product';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form action="?id=<?= $id ?>" method="post">
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
            <option value="">--Select--</option>
            <option value="Gadget" <?= (isset($category) && $category == 'Gadget') ? 'selected' : '' ?>>Gadget</option>
            <option value="Toys" <?= (isset($category) && $category == 'Toys') ? 'selected' : '' ?>>Toys</option>
        </select>
        <br>
        <?php if (!empty($categoryErr)): ?>
            <span class="error"><?= $categoryErr ?></span>
            <br>
        <?php endif; ?>

        <label for="price">Price</label><span class="error">*</span>
        <br>
        <input type="number" name="price" id="price" value="<?= $price ?>">
        <br>
        <?php if (!empty($priceErr)): ?>
            <span class="error"><?= $priceErr ?></span>
            <br>
        <?php endif; ?>

        <label for="availability">Availability</label><span class="error">*</span>
        <br>
        <input type="radio" value="In Stock" name="availability" id="instock" <?= ($availability == 'In Stock') ? 'checked' : '' ?>>
        <label for="instock">In Stock</label>
        <input type="radio" value="No Stock" name="availability" id="nostock" <?= ($availability == 'No Stock') ? 'checked' : '' ?>>
        <label for="nostock">No Stock</label>
        <br>
        <?php if (!empty($availabilityErr)): ?>
            <span class="error"><?= $availabilityErr ?></span>
            <br>
        <?php endif; ?>
        <br>
        <input type="submit" value="Update Product">
    </form>
</body>
</html>
