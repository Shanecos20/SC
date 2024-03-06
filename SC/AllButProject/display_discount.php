<?php
    // get the data from the form
    $product_description = $_POST ['product_description'];
    $list_price = $_POST ['list_price'];
    $discount_percent = $_POST['discount_percent'];
    
    // calculate the discount and discounted price
    $discount = $list_price * $discount_percent * .01;
    $discount_price = $list_price - $discount;

   
?>
<!DOCTYPE html>
<html>

<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <main>
        <h1>Product Discount Calculator</h1>

        <label>Product Description:</label>
        <span><?php echo $product_description; ?></span>
        <br>

        <label>List Price:</label>
        <span><?php echo $list_price; ?></span>
        <br>

        <label>Standard Discount:</label>
        <span><?php echo $discount_percent; ?></span>
        <br>

        <label>Discount Amount:</label>
        <span><?php echo $discount; ?></span>
        <br>

        <label>Discount Price:</label>
        <span><?php echo $discount_price; ?></span>
        <br>
    </main>
</body>
</html>