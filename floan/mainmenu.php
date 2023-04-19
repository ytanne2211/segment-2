<!DOCTYPE html>
<html>
<head>
	<title>Financial Loan Corporation</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f1f1f1;
			margin: 0;
			padding: 0;
		}
		.container {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
		}
		h1 {
			font-size: 32px;
			margin-bottom: 20px;
			color: #555;
			text-align: center;
		}
		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
		}
		li {
			margin: 10px;
			border: 2px solid #555;
			border-radius: 5px;
			overflow: hidden;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}
		li:hover {
			transform: translateY(-5px);
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
		}
		li a {
			display: block;
			padding: 10px 20px;
			color: #555;
			text-decoration: none;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Main Menu</h1>
		<ul>
			<li><a href="new_loan_application.php">New Loan Application</a></li>
			<li><a href="view_loan.php">View Specific Loan</a></li>
			<li><a href="pending_loan_form.php">Pending Loan Form</a></li>
			<li><a href="monthly_statement.php">View Specific Monthly Statement</a></li>
			<li><a href="disbursement.php">Disbursement </a></li>
			<li><a href="customer_account_inquiry.php">Customer Account Inquiry</a></li>
			<li><a href="update_customer_information.php">Update Customer Information</a></li>
		</ul>
	</div>
</body>
</html>
