<!DOCTYPE html>
<html>
<head>
	<title>Search by SSN</title>
    	<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            margin: 40px auto;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }

        h2{
            margin: 40px auto;
            text-align:center;
        }

        form {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        label {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            width: 100%;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #0062cc;
        }

        .result {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            max-width: 500px;
        }

        .result h2 {
            font-size: 24px;
            margin: 0 0 10px;
            text-align: center;
            font-weight: bold;
        }

        .result p {
            font-size: 18px;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .result span {
            text-decoration: underline;
            font-weight: bold;
        }

	</style>
</head>
<body>
	<h1>Customer Account Inquiry</h1>
	<form method="post" action="">
		<label>Enter SSN:</label>
		<input type="number" name="id">
		<input type="submit" name="submit" value="Search">
	</form>

	<?php

        include('db_connection.php');

		// Check if form has been submitted
		if (isset($_POST['submit'])) {
			// Get user input
			$id = $_POST['id'];

            $sql1 = "select * from customer c
            join loan l on c.customerssn = CAST(REPLACE(l.customerssn, '-', '') AS NUMBER)
            where c.customerssn = :id";



            $sql2 = "select b.* from billingstatement b
                    join loan l on l.loannum = b.loannum
                    join customer c on c.customerssn = CAST(REPLACE(l.customerssn, '-', '') AS NUMBER)
         where c.customerssn = :id";


            $stmt1 = oci_parse($conn, $sql1);

            oci_bind_by_name($stmt1, ':id', $id);

            // Execute query and store results
            $r1 = oci_execute($stmt1);

            $stmt2 = oci_parse($conn, $sql2);

            oci_bind_by_name($stmt2, ':id', $id);

            // Execute query and store results
            $r2 = oci_execute($stmt2);


            // Check if there are any results
            if (!$r1) {
                $e = oci_error($stmt1);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            while ($row = oci_fetch_array($stmt1, OCI_ASSOC+OCI_RETURN_NULLS)) {
                echo '<h2> Customer Account Inquiry </h1>';
                echo '<p class="result">Customer SSN: ' . $row['CUSTOMERSSN'] . '</p>';
                echo '<p class="result">Last Name: ' . $row['LASTNAME'] . '</p>';
                echo '<p class="result">first  Name: ' . $row['FIRSTNAME'] .  '</p>';
                echo '<p class="result">Address: ' . $row['STREET'] . ' </p>';
                echo '<p class="result">City: '  . $row['CITY'] . ' </p>';
                echo '<p class="result">State: '.  $row['STATE'] . ' </p>';
                echo '<p class="result">Zip: ' . $row['ZIP'] . ' </p>';
                echo '<p class="result">Primary Income: ' . $row['PRIMARYINCOME'] . ' </p>';
                echo '<p class="result">Secondary Income: ' . $row['SECONDINCOME'] . ' </p>';

                echo '<h2> Loan Summary </h1>';
                echo '<p class="result">Loan Term: ' . $row['LOANTERM'] . '</p>';
                echo '<p class="result">Interest Rate: ' . $row['INTERESTRATE'] . '</p>';
                echo '<p class="result">Principal Balance: ' . $row['PRINCIPLEBAL'] .  '</p>';
                echo '<p class="result">Account Status: current  </p>';
                echo '<p class="result">Loan Amount: ' . $row['LOANAMOUNT'] . '</p>';
                echo '<p class="result">Monthly Payment: ' . $row['MONTHLYPAY'] . '</p>';
                echo '<p class="result">Remaining Payments: ' . $row['REMANINGPAY'] .  '</p>';

            }

             // Check if there are any results
             if (!$r2) {
                $e = oci_error($stmt2);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            echo '<h2> Account Information </h1>';
            while ($row = oci_fetch_array($stmt2, OCI_ASSOC+OCI_RETURN_NULLS)) {
                echo '<p class="result">StmtNo: ' . $row['STMTNUM'] . '</p>';
                echo '<p class="result">Date Due: ' . $row['DATEDUE'] .  '</p>';
                echo '<p class="result">Amount Billed: ' . $row['AMOUNTBILLED'] .' </p>';
                echo '<p class="result">Date Received: ' . $row['DATERECEIVED'] . ' </p>';
                echo '<p class="result">Amount Received: ' . $row['AMOUNTRECEIVED'] . ' </p>';
                echo '<p class="result">Interest Paid: ' . $row['INTERESTPAID'] . ' </p>';
                echo '<p class="result">Principal Applied: ' . $row['PRINCIPALAPPLIED'] . ' </p>';
            }


            // Free resources and close connection
            oci_free_statement($stmt1);
            oci_free_statement($stmt2);
            oci_close($conn);
        }

	?>
</body>
</html>
