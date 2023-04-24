<?php

include('db_connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Get the form data
	$loanstatus = $_POST['loanstatus'];
	$riskfactor = $_POST['riskfactor'];
    $loannum = $_POST['loannum'];

    // First UPDATE statement for LOAN table
    $sql1 = "UPDATE LOAN
    SET loanstatus = :loanstatus,
    riskfactor = :riskfactor
    WHERE loannum = :loannum";
    $stmt1 = oci_parse($conn, $sql1);

    // Bind parameters for the first statement
    oci_bind_by_name($stmt1, ':loannum', $loannum);
    oci_bind_by_name($stmt1, ':riskfactor', $riskfactor);
    oci_bind_by_name($stmt1, ':loanstatus', $loanstatus);

    // Execute the first statement
    oci_execute($stmt1);

    if (oci_num_rows($stmt1) > 0 ) {
		echo '<p style="color: green;">Form submitted successfully!</p>';
	}




}



?>