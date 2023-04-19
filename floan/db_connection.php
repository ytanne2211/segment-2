<?php
$username = "ADMIN";
$password = "OracleDB1234";
$database = "(description= (retry_count=20)(retry_delay=3)(address=(protocol=tcps)(port=1521)(host=adb.us-ashburn-1.oraclecloud.com))(connect_data=(service_name=gae31953582ccc3_oracledb1_low.adb.oraclecloud.com))(security=(ssl_server_dn_match=no)))";

// Create a connection to the database
$conn = oci_connect($username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    $error = oci_error();
    trigger_error(htmlentities($error['message'], ENT_QUOTES), E_USER_ERROR);
}
?>
