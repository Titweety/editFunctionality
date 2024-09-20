<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <style>
        p.search {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <a href="addproduct.php">Add Product</a>

    <?php
        require_once 'product.class.php';

        $productObj = new Product();
        $array = $productObj->showAll();
    ?>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Action</th>
        </tr>
        <?php
        $i = 1;

        if (empty($array)){
        
        ?>
        <tr>
            <td colspan="7">
                <p class="search">No Product Found.</p>
            </td>
        </tr>
        <?php
        }
        foreach ($array as $arr){
        ?>
        <tr>
            <td><?= $i?></td>
            <td><?= $arr['name']?></td>
            <td><?= $arr['category']?></td>
            <td><?= $arr['price']?></td>
            <td><?= $arr['availability']?></td>
            <td>
                <a href="editProduct.php?id=<?= $arr['id'] ?>">Edit</a>
            </td>
        </tr>
        <?php
            $i++;
        }
        ?>
    </table>
</body>
</html>