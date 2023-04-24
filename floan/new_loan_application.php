<?php
include('db_connection.php');

// Your PHP code goes here
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Get the form data
	$loanofficerid = $_POST['loanofficerid'];
	$customerssn = $_POST['customerssn'];
	$lastname = $_POST['lastname'];
	$firstname = $_POST['firstname'];
	$street = $_POST['street'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$phonenum = $_POST['phonenum'];
	$primaryincome = $_POST['primaryincome'];
	$secondincome = $_POST['secondincome'];
	$loannum = $_POST['loannum'];
	$loanamount = $_POST['loanamount'];
	$loanterm = $_POST['loanterm'];
	$monthlypay = $_POST['monthlypay'];
	$interestrate = $_POST['interestrate'];
	if (isset($_POST['W2'])) {
		$W2 = $_POST['W2'];
	} else {
		$W2 = 'N';
	}

	if (isset($_POST['taxreturn'])) {
		$taxreturn = $_POST['taxreturn'];
	} else {
		$taxreturn = 'N';
	}

	if (isset($_POST['creditreport'])) {
		$creditreport = $_POST['creditreport'];
	} else {
		$creditreport = 'N';
	}

	if (isset($_POST['bankinfo'])) {
		$bankinfo = $_POST['bankinfo'];
	} else {
		$bankinfo = 'N';
	}

	$loanstatus = $_POST['loanstatus'];
	$underwriterid = $_POST['underwriterid'];

	$applicandate = $_POST['applicandate'];
	$applicandate = date('d-M-Y', strtotime($applicandate)); // convert to expected date format



	$sql1 = "INSERT INTO LOAN (loanofficerid, customerssn, loannum, applicandate, loanamount, loanterm, monthlypay, interestrate, W2, taxreturn, creditreport, bankinfo, loanstatus, underwriterid)
	VALUES (:loanofficerid, :customerssn, :loannum, to_date(:applicandate, 'dd-Mon-yyyy'), :loanamount, :loanterm, :monthlypay, :interestrate, :W2, :taxreturn, :creditreport, :bankinfo, :loanstatus, :underwriterid)";
	$stmt1 = oci_parse($conn, $sql1);

	// Bind parameters for the first statement
	oci_bind_by_name($stmt1, ':loanofficerid', $loanofficerid);
	oci_bind_by_name($stmt1, ':customerssn', $customerssn);
	oci_bind_by_name($stmt1, ':loannum', $loannum);
	oci_bind_by_name($stmt1, ':applicandate', $applicandate);
	oci_bind_by_name($stmt1, ':loanamount', $loanamount);
	oci_bind_by_name($stmt1, ':loanterm', $loanterm);
	oci_bind_by_name($stmt1, ':monthlypay', $monthlypay);
	oci_bind_by_name($stmt1, ':interestrate', $interestrate);
	oci_bind_by_name($stmt1, ':W2', $W2);
	oci_bind_by_name($stmt1, ':taxreturn', $taxreturn);
	oci_bind_by_name($stmt1, ':creditreport', $creditreport);
	oci_bind_by_name($stmt1, ':bankinfo', $bankinfo);
	oci_bind_by_name($stmt1, ':loanstatus', $loanstatus);
	oci_bind_by_name($stmt1, ':underwriterid', $underwriterid);

	// Execute the first statement
	oci_execute($stmt1);

	// Get the number of rows affected by the first statement
	$num_rows1 = oci_num_rows($stmt1);

	// Second INSERT statement for CUSTOMER table
	$sql2 = "INSERT INTO CUSTOMER (customerssn, lastname, firstname, street, city, state, zip, phonenum, primaryincome, secondincome)
	VALUES (:customerssn, :lastname, :firstname, :street, :city, :state, :zip, :phonenum, :primaryincome, :secondincome)";
	$stmt2 = oci_parse($conn, $sql2);

	// Bind parameters for the second statement
	oci_bind_by_name($stmt2, ':customerssn', $customerssn);
	oci_bind_by_name($stmt2, ':lastname', $lastname);
	oci_bind_by_name($stmt2, ':firstname', $firstname);
	oci_bind_by_name($stmt2, ':street', $street);
	oci_bind_by_name($stmt2, ':city', $city);
	oci_bind_by_name($stmt2, ':state', $state);
	oci_bind_by_name($stmt2, ':zip', $zip);
	oci_bind_by_name($stmt2, ':phonenum', $phonenum);
	oci_bind_by_name($stmt2, ':primaryincome', $primaryincome);
	oci_bind_by_name($stmt2, ':secondincome', $secondincome);

	// Execute the second statement
	oci_execute($stmt2);

	// Get the number of rows affected by the second statement
	$num_rows2 = oci_num_rows($stmt2);

	if (oci_num_rows($stmt1) > 0 && oci_num_rows($stmt2) > 0) {
		echo '<p style="color: green;">Form submitted successfully!</p>';
	}
}


?>
<!DOCTYPE html>
<html>

<head>
	<title>New Loan Application Form</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f5f5f5;
		}

		h1 {
			text-align: center;
			margin-top: 50px;
		}

		form {
			max-width: 600px;
			margin: 0 auto;
			background-color: #ffffff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
		}

		label {
			display: block;
			margin-bottom: 10px;
		}

		input[type="text"],
		input[type="date"],
		input[type="checkbox"],
		input[type="number"]{
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border: none;
			border-radius: 3px;
			box-shadow: inset 0px 0px 3px rgba(0, 0, 0, 0.1);
		}

		input[type="checkbox"] {
			width: auto;
			margin-top: 5px;
			margin-bottom: 5px;
		}

		input[type="submit"] {
			background-color: #4CAF50;
			color: #ffffff;
			padding: 10px 20px;
			border: none;
			border-radius: 3px;
			cursor: pointer;
			transition: background-color 0.2s ease;
		}

		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
	</style>
</head>

<body>
	<h1>New Loan Application Form</h1>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<label for="loanofficerid">Loan Officer ID:</label>
		<input type="number" id="loanofficerid" name="loanofficerid">

		<label for="customerssn">Customer SSN:</label>
		<input type="number" id="customerssn" name="customerssn">

		<label for="lastname">Last Name:</label>
		<input type="text" id="lastname" name="lastname">

		<label for="firstname">First Name:</label>
		<input type="text" id="firstname" name="firstname">

		<label for="street">Address:</label>
		<input type="text" id="street" name="street">

		<label for="city">City:</label>
		<input type="text" id="city" name="city">

		<label for="state">State:</label>
		<input type="text" id="state" name="state">

		<label for="zip">Zip:</label>
		<input type="text" id="zip" name="zip">

		<label for="phonenum">Phone:</label>
		<input type="text" id="phonenum" name="phonenum">

		<label for="primaryincome">Primary Income:</label>
		<input type="number" id="primaryincome" name="primaryincome">

		<label for="secondincome">Secondary Income:</label>
		<input type="number" id="secondincome" name="secondincome">

		<label for="loannum">Loan No.:</label>
		<input type="number" id="loannum" name="loannum">

		<label for="loanamount">Loan Amount:</label>
		<input type="text" id="loanamount" name="loanamount">

		<label for="applicandate">Appl. Date:</label>
		<input type="date" id="applicandate" name="applicandate">

		<label for="interestrate">Interest Rate:</label>
		<input type="text" id="interestrate" name="interestrate">

		<label for="loanterm">Loan Term:</label>
		<input type="number" id="loanterm" name="loanterm">

		<label for="monthlypay">Mo. Payment:</label>
		<input type="number" id="monthlypay" name="monthlypay">

		<label for="W2">W2 Form:</label>
		<input type="checkbox" id="W2" name="W2" value="Y">

		<label for="taxreturn">Tax Return:</label>
		<input type="checkbox" id="taxreturn" name="taxreturn" value="Y">

		<label for="creditreport">Credit Report:</label>
		<input type="checkbox" id="creditreport" name="creditreport" value="Y">

		<label for="bankinfo">Bank Info:</label>
		<input type="checkbox" id="bankinfo" name="bankinfo" value="Y">

		<label for="loanstatus">Loan Status:</label>
		<input type="text" id="loanstatus" name="loanstatus">

		<label for="underwriterid">Underwriter ID:</label>
		<input type="number" id="underwriterid" name="underwriterid">



		<input type="submit" value="Submit">
	</form>
</body>

</html>