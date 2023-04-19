<!DOCTYPE html>
<html>
<head>
	<title>Disbursement</title>
    <style>
		body {
			font-family: Arial, sans-serif;

		}
		h1 {
			font-size: 2em;
			margin: 1em 0;
		}
		form {
			display: flex;
			align-items: center;
			margin-bottom: 1em;
		}
		label {
			font-size: 1.2em;
			margin-right: 1em;
		}
		input[type=date] {
			font-size: 1.2em;
			padding: 0.5em;
			border-radius: 4px;
			border: none;
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);
			margin-right: 1em;
		}
		input[type=submit] {
			background-color: #3498db;
			color: #fff;
			font-size: 1.2em;
			padding: 0.5em 1em;
			border-radius: 4px;
			border: none;
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);
			cursor: pointer;
		}
		input[type=submit]:hover {
			background-color: #2980b9;
		}
		table {
			border-collapse: collapse;
			width: 100%;
		}
		th, td {
			border: 1px solid #ccc;
			padding: 0.5em;
			text-align: left;
		}
		th {
			background-color: #eee;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
	</style>
</head>
<body>
	<h1>Disbursement Report</h1>
	<form method="post" action="">
		<label>Choose Disbursement Date:</label>
		<input type="date" name="dates">
		<input type="submit" name="submit" value="Search">
	</form>

	<?php

        include('db_connection.php');

		// Check if form has been submitted
		if (isset($_POST['submit'])) {
			// Get user input
			// Get user input
            $dates = $_POST['dates'];

            $formatted_date = date("d-M-y", strtotime($dates));

            // Prepare SQL query
            $sql = "SELECT loan.*,  c.*
                    FROM (SELECT * FROM loan WHERE loanreviewdate = TO_DATE(:dates, 'DD-MON-YY') AND loanstatus = 'Approved') loan
                    JOIN customer c ON c.customerssn = CAST(REPLACE(loan.customerssn, '-', '') AS NUMBER)";

            $stmt = oci_parse($conn, $sql);

            oci_bind_by_name($stmt, ':dates', $formatted_date);


            // Execute query and store results
            $r = oci_execute($stmt);


            // Check if there are any results
            if (!$r) {
                $e = oci_error($stmt);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            $i = 1;

            echo '<table>';
            echo '<tr><th>Check No</th><th>Check Amount</th><th>Customer SSN</th><th>Name/Address</th></tr>';

            // Loop through the results and print each row in the table
            while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $row['LOANAMOUNT'] . '</td>';
                echo '<td>' . $row['CUSTOMERSSN'] . '</td>';
                echo '<td>' . $row['LASTNAME'] . ', '. $row['FIRSTNAME'] . '<br>'
                . $row['STREET'] .'<br>'
                . $row['CITY'] . ' ' . $row['STATE'] . ' ' . $row['ZIP'] .
                '</td>';
                echo '</tr>';
            }

            // End the table
            echo '</table>';

            // Free resources and close connection
            oci_free_statement($stmt);
            oci_close($conn);
        }

	?>
</body>
</html>
