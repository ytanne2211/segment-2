<?php

include('db_connection.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Get the form data
	$customerssn = $_POST['customerssn'];
	$lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phonenum = $_POST['phonenum'];
    $lastupdate = $_POST['lastupdate'];

}

// Second INSERT statement for CUSTOMER table
$sql2 = "UPDATE customer
         SET lastname = :lastname,
             firstname = :firstname,
             street = :street,
             city = :city,
             state = :state,
             zip = :zip,
             phonenum = :phonenum,
             lastupdate = :lastupdate
             WHERE customerssn = :customerssn";
         
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
oci_bind_by_name($stmt2, ':lastupdate', $lastupdate);


// Execute the second statement
oci_execute($stmt2);


?>