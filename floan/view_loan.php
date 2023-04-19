<!DOCTYPE html>
<html>
<head>
	<title>Search by ID</title>
    	<style>
		h1 {
			margin-bottom: 10px;
			font-size: 28px;
			font-weight: bold;
			text-align: center;
		}
		form {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin: 20px auto;
			padding: 20px;
			border: 1px solid black;
			width: 50%;
		}
		label {
			margin-bottom: 10px;
			font-size: 18px;
		}
		input[type="number"] {
			padding: 10px;
			font-size: 16px;
			border-radius: 5px;
			border: 1px solid black;
			margin-bottom: 20px;
		}
		input[type="submit"] {
			padding: 10px 20px;
			font-size: 18px;
			border-radius: 5px;
			border: none;
			background-color: #007bff;
			color: white;
			cursor: pointer;
		}
		input[type="submit"]:hover {
			background-color: #0062cc;
		}
		.result {
			margin: 20px auto;
			padding: 20px;
			border: 1px solid black;
			width: 50%;
		}
		.result h1 {
			font-size: 24px;
			margin-bottom: 10px;
			text-align: center;
		}
		.result p {
			font-size: 18px;
			margin-bottom: 5px;
			line-height: 1.5;
		}
		.result span {
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<h1>Search by ID for Loan</h1>
	<form method="post" action="">
		<label>Enter Loan Number:</label>
		<input type="number" name="id">
		<input type="submit" name="submit" value="Search">
	</form>

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

            while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
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
</body>
</html>
