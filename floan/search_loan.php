<?php
include('db_connection.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Search Results</title>
    <style>
        /* Style for the page header */
        .header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }

        /* Style for the search results section */
        .result {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .container {
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ddd;
        }

        /* Style for the form section */
        form {
            margin-top: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Style for the form header */
        h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Style for the form labels */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Style for the form input fields */
        input[type="checkbox"] {
            margin-right: 5px;
        }

        /* Style for the form submit button */
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
        }

        /* Style for the hidden input field */
        input[type="hidden"] {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    // Check if form has been submitted
    if (isset($_POST['id'])) {
        // Get user input
        $id = $_POST['id'];

        // Prepare SQL query
        $sql = "SELECT loan.*, e.empfname as LOfname, c.*, uw.empfname as UWfname
                FROM (select * from loan where loannum = :id) loan
                join customer c on c.customerssn = CAST(REPLACE(loan.customerssn, '-', '') AS NUMBER)
                join employee e on e.empno = loan.loanofficerid
                join employee uw on uw.empno = loan.underwriterid";

        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':id', $id);

        // Execute query and store results
        $r = oci_execute($stmt);

        // Check if there are any results
        if (!$r) {
            $e = oci_error($stmt);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }


        while ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
            echo '<h1> New Loan Application</h1>';
            echo '<div class="container">';
            echo '<p class="result"><label>Loan Officer:</label> ' . $row['LOFNAME'] . '</p>';
            echo '<p class="result"><label>Customer SSN:</label> ' . $row['CUSTOMERSSN'] . ' </p>';
            echo '<p class="result"><label>Last Name:</label> ' . $row['LASTNAME'] . ' </p>';
            echo '<p class="result"><label>First Name:</label> ' . $row['FIRSTNAME'] . ' </p>';
            echo '<p class="result"><label>Address:</label> ' . $row['STREET'] . ' </p>';
            echo '<p class="result"><label>State:</label> ' . $row['STATE'] . ' </p>';
            echo '<p class="result"><label>Zip:</label> ' . $row['ZIP'] . ' </p>';
            echo '<p class="result"><label>Phone:</label> ' . $row['PHONENUM'] . ' </p>';
            echo '<p class="result"><label>Primary Income:</label> $' . $row['PRIMARYINCOME'] . ' </p>';
            echo '<p class="result"><label>Secondary Income:</label> $' . $row['SECONDINCOME'] . ' </p>';
            echo '<br>';
            echo '<h1 class="result"> Loan Information </h1>';
            echo '<p class="result"><label>Loan No:</label> ' . $row['LOANNUM'] . ' </p>';
            echo '<p class="result"><label>Appl. Date:</label> ' . $row['APPLICANDATE'] . ' </p>';
            echo '<p class="result"><label>Loan Amount:</label> $' . $row['LOANAMOUNT'] . ' </p>';
            echo '<p class="result"><label>Loan Term:</label> ' . $row['LOANTERM'] . ' yr. </p>';
            echo '<p class="result"><label>Interest Rate:</label> ' . $row['INTERESTRATE'] . ' % </p>';
            echo '<p class="result"><label>Mo. Payment:</label> $' . $row['MONTHLYPAY'] . '</p>';
            echo '<br>';
            echo '<h1 class="result"> Documents Received </h1>';
            echo '<p class="result"><label>W2 Form:</label> <span style="text-decoration: underline;">' . $row['W2'] . '</span></p>';
            echo '<p class="result"><label>Tax Return:</label> <span style="text-decoration: underline;">' . $row['TAXRETURN'] . '</span></p>';
            echo '<p class="result"><label>Credit Report:</label> <span style="text-decoration: underline;">' . $row['CREDITREPORT'] . '</span></p>';
        }



    // Free resources and close connection
    oci_free_statement($stmt);


    oci_close($conn);
}

?>

<form method="post" action="pending_loan.php">

<h2>Loan Status</h2>
<label>
    <input type="checkbox" name="loanstatus" value="Approved">Approved
</label>
<br>
<label>
    <input type="checkbox" name="loanstatus" value="Pending">Pending
</label>
<br>
<label>
    <input type="checkbox" name="loanstatus" value="Denied">Denied
</label>

<h2>Risk Factor</h2>
<label>
    <input type="checkbox" name="riskfactor" value="Low">Low
</label>
<br>
<label>
    <input type="checkbox" name="riskfactor" value="Moderate">Moderate
</label>
<br>
<label>
    <input type="checkbox" name="riskfactor" value="High">High
</label>
<br>
<input hidden type="text" name="loannum" value="<?php echo $id  ?>">



<input type="submit" value="Submit">


</form>
</body>
</html>
