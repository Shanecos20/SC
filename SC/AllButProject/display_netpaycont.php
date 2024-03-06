 <?php


// get the data from the form for net pay
$employee_name = $_POST['employee_name'];
$gross_pay = $_POST['gross_pay'];
$pension = $_POST['pension']; // Pension rate is 5%
$prsi = $_POST['prsi']; // PRSI rate is 7.5%
$tax_rate1 = 20; // Tax rate for the first 40,000
$tax_rate2 = 40; // Tax rate for the balance
// Calculate deductions
$pension = $gross_pay * $pension * 0.01;
$prsi = $gross_pay * $prsi * 0.01;

// Calculate tax deductions
if ($gross_pay > 40000) {
    $tax1 = 40000 * $tax_rate1 * 0.01;
    $tax2 = ($gross_pay - 40000) * $tax_rate2 * 0.01;
} else {
    $tax1 = $gross_pay * $tax_rate1 * 0.01;
    $tax2 = 0;
}

// Calculate net pay
$net_pay = $gross_pay - $pension - $prsi - $tax1 - $tax2;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Net Pay Calculator Extended</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <main>
        <h1>Net Pay Calculator Extended</h1>

        <label>Name:</label>
        <span><?php echo $employee_name; ?></span>
        <br><br>

        <label>Gross Pay:</label>
        <span><?php echo $gross_pay; ?></span>
        <br>

        <label>Pension Deduction:</label>
        <span><?php echo $pension; ?></span>
        <br>

        <label>PRSI Deduction:</label>
        <span><?php echo $prsi; ?></span>
        <br>

        <label>20% Tax Deduction:</label>
        <span><?php echo $tax1; ?></span>
        <br>

        <label>40% Tax Deduction:</label>
        <span><?php echo $tax2; ?></span>
        <br>

        <br>
        <label>Net Pay:</label>
        <span><?php echo $net_pay; ?></span>
        <br>
    </main>
</body>
</html>