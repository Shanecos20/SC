<?php
    // get the data from the form for netpay
    $employee_name = $_POST ['employee_name'];
    $gross_pay = $_POST ['gross_pay'];
    $pension = $_POST['pension'];
    $prsi = $_POST['prsi'];
    $tax = $_POST['tax'];


   
    
    //calculate the deductions
    $pension = $gross_pay * $pension * .01;
    $prsi = $gross_pay * $prsi * .01;
    $tax = $gross_pay * $tax * .01;
    
    // calculate the NET PAY from the gross pay and deductions
    $net_pay = $gross_pay - $pension - $prsi - $tax;
    
    
   
?>
<!DOCTYPE html>
<html>

<head>
    <title>Product Discount Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <main>
        <h1>Net Pay Calculator</h1>

        <label>Name:</label>
        <span><?php echo $employee_name; ?></span>
        <br>
        <br>

        <label>Gross Pay:</label>
        <span><?php echo $gross_pay; ?></span>
        <br>

        <label>Pension Deduction:</label>
        <span><?php echo $pension; ?></span>
        <br>

        <label>PRSI Deduction:</label>
        <span><?php echo $prsi; ?></span>
        <br>

        <label>Tax Deduction:</label>
        <span><?php echo $tax; ?></span>
        <br>

        <br>
        <label>Net Pay:</label>
        <span><?php echo $net_pay; ?></span>
        <br>


    </main>
</body>
</html>
