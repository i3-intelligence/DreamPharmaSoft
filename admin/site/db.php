<?php
// Database Configuration
$prefix = ""; // For online/offline prefixing (optional)
$servername = "localhost";
$username = $prefix . "root";
$password = ""; // lowercase for consistency
$database = $prefix . "mws_parma_admin";
$port = 3307; // Custom MySQL port

try {
    $conn = new PDO(
        "mysql:host=$servername;port=$port;dbname=$database;charset=utf8",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    // echo "Connected successfully"; // Optional debug
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

//User Information
$company = "MWS Parmna Care System";
$SortName = "MWS Pharmacare";
$c_address = "Dhaka, Bangladesh";
$c_mobile = "Mobile No:+01883008651";
$c_email = "";
$currency = "BDT";
$currency_sym = "Tk";
$NumberValidity = "oninput=\"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');\" ";
$c_logo = "dist/img/logo.png";
$i3_define_date = "2023-01-01";
$maintenance = "01883008651";
$quantity = "Quantity";
$AutoComplete = "AutoComplete=\"off\"";
$QtyCheck = "onfocus=\"if(this.value == '0') { this.value = ''; }\" onblur=\"if(this.value == '') { this.value = '0'; }\"";
$CurrentTime = date("H:i:s");
$CurrentDate = date("Y-m-d");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>