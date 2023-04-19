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
	<h1>Search by SSN</h1>
	<form method="post" action="">
		<label>Enter SSN without dashes:</label>
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
			$sql = "SELECT * from customer where customerssn = :d";

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
                $customerssn =  $row['CUSTOMERSSN'];
                $lastname = $row['LASTNAME'];
                $firstname = $row['FIRSTNAME'];
                $street = $row['STREET'];
                $city = $row['CITY'];
                $state = $row['STATE'];
                $zip = $row['ZIP'];
            }


            // Free resources and close connection
            oci_free_statement($stmt);
            oci_close($conn);
        }

	?>

    <body>
	<h1>New Loan Application Form</h1>
	<form action="customer_update.php" method="post">

		<label for="customerssn">Customer SSN:</label>
		<input type="number" id="customerssn" name="customerssn" disabled value="<?php echo $customerssn ?>">

		<label for="lastname">Last Name:</label>
		<input type="text" id="lastname" name="lastname" value="<?php echo $lastname ?>">

		<label for="firstname">First Name:</label>
		<input type="text" id="firstname" name="firstname" value="<?php echo $firstname ?>">

		<label for="street">Address:</label>
		<input type="text" id="street" name="street" value="<?php echo $street ?>">

		<label for="city">City:</label>
		<input type="text" id="city" name="city" value="<?php echo $city ?>">

		<label for="state">State:</label>
		<input type="text" id="state" name="state" value="<?php echo $state ?>">

		<label for="zip">Zip:</label>
		<input type="text" id="zip" name="zip" value="<?php echo $zip ?>">

		<label for="phonenum">Phone:</label>
		<input type="text" id="phonenum" name="phonenum" value="<?php echo $phonenum ?>">

        <label for="lastupdate">Primary Income:</label>
		<input type="date" id="lastupdate" name="lastupdate" value="<?php echo $lastupdate ?>">


		<input type="submit" value="Submit">
	</form>
</body>
</html>
