<?php

include('db_connection.php');

// Check if form has been submitted
if (isset($_POST['submit'])) {
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
        echo '<h1 class="result"> New Loan Application</h1>';
        echo '<p class="result">Loan Officer: ' . $row['LOFNAME'] . '</p>';
        echo '<p class="result">Customer SSN: ' . $row['CUSTOMERSSN'] . ' </p>';
        echo '<p class="result">Last Name: ' . $row['LASTNAME'] . ' </p>';
        echo '<p class="result">First Name: ' . $row['FIRSTNAME'] . ' </p>';
        echo '<p class="result">Address: ' . $row['STREET'] . ' </p>';
        echo '<p class="result">State: ' . $row['STATE'] . ' </p>';
        echo '<p class="result">Zip: ' . $row['ZIP'] . ' </p>';
        echo '<p class="result">Phone: ' . $row['PHONENUM'] . ' </p>';
        echo '<p class="result">Primary Income: $' . $row['PRIMARYINCOME'] . ' </p>';
        echo '<p class="result">Secondary Income $:' . $row['SECONDINCOME'] . ' </p>';
        echo '<br>';
        echo '<h1 class="result"> Loan Information </h1>';
        echo '<p class="result">Loan No: ' . $row['LOANNUM'] . ' </p>';
        echo '<p class="result">Appl. Date: ' . $row['APPLICANDATE'] . ' </p>';
        echo '<p class="result">Loan Amount: $' . $row['LOANAMOUNT'] . ' </p>';
        echo '<p class="result">Loan Term: ' . $row['LOANTERM'] . ' yr. </p>';
        echo '<p class="result">Interest Rate: ' . $row['INTERESTRATE'] . ' % </p>';
        echo '<p class="result">Mo. Payment: $' . $row['MONTHLYPAY'] . '</p>';
        echo '<br>';
        echo '<h1 class="result"> Documents Received </h1>';
        echo '<p class="result">W2 Form: <span style="text-decoration: underline;">' . $row['W2'] . '</span></p>';
        echo '<p class="result">Tax Return: <span style="text-decoration: underline;">' . $row['TAXRETURN'] . '</span></p>';
        echo '<p class="result">Credit Report: <span style="text-decoration: underline;">' . $row['CREDITREPORT'] . '</span></p>';
        echo '<p class="result">Bank Info: <span style="text-decoration: underline;">' . $row['BANKINFO'] . '</span></p>';
        echo '<p class="result">Loan Status: ' . $row['LOANSTATUS'] . '</p>';
        echo '<p class="result">Assign To Underwriter (Name): ' . $row['UWFNAME'] . '</p>';
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
