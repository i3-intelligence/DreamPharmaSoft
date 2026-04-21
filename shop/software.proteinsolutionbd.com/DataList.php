
<?php
include('db.php');
if (isset($_POST['BranchName'])) {
   $result = array();
   $BranchName = $_POST["BranchName"];
   $query = $conn->prepare("SELECT * FROM `Bank` WHERE `BranchName` LIKE '%" . $BranchName . "%' GROUP BY `BranchName` LIMIT 10");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['BranchName'];
   }

   echo json_encode($result);
}

if (isset($_POST['BankName'])) {
   $result = array();
   $BankName = $_POST["BankName"];
   $query = $conn->prepare("SELECT * FROM `Bank` WHERE `BankName` LIKE '%" . $BankName . "%' GROUP BY `BankName` LIMIT 10");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['BankName'];
   }

   echo json_encode($result);
}

if (isset($_POST['AccountName'])) {
   $result = array();
   $AccountName = $_POST["AccountName"];
   $query = $conn->prepare("SELECT * FROM `Bank` WHERE `AccountName` LIKE '%" . $AccountName . "%' GROUP BY `AccountName` LIMIT 10");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['AccountName'];
   }

   echo json_encode($result);
}

if (isset($_POST['SectorName'])) {
   $result = array();
   $SectorName = $_POST["SectorName"];
   $query = $conn->prepare("SELECT * FROM `OthersAccount` WHERE `SectorName` LIKE '%" . $SectorName . "%' GROUP BY `SectorName` LIMIT 10");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['SectorName'];
   }

   echo json_encode($result);
}

if (isset($_POST['CashMemoInvoice'])) {
   $result = array();
   $CashMemoInvoice = $_POST["CashMemoInvoice"];
   $query = $conn->prepare("SELECT * FROM `CashMemo` WHERE `CashMemoInvoice` LIKE '%" . $CashMemoInvoice . "%' GROUP BY `CashMemoInvoice` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['CashMemoInvoice'];
   }

   echo json_encode($result);
}


if (isset($_POST['CashMemoReturnInvoice'])) {
   $result = array();
   $CashMemoReturnInvoice = $_POST["CashMemoReturnInvoice"];
   $query = $conn->prepare("SELECT * FROM `CashMemoReturn` WHERE `CashMemoReturnInvoice` LIKE '%" . $CashMemoReturnInvoice . "%' GROUP BY `CashMemoReturnInvoice` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['CashMemoReturnInvoice'];
   }

   echo json_encode($result);
}

if (isset($_POST['ChallanInvoice'])) {
   $result = array();
   $ChallanInvoice = $_POST["ChallanInvoice"];
   $query = $conn->prepare("SELECT * FROM `Challan` WHERE `ChallanInvoice` LIKE '%" . $ChallanInvoice . "%' GROUP BY `ChallanInvoice` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['ChallanInvoice'];
   }

   echo json_encode($result);
}

if (isset($_POST['CustomerReceiveInvoice'])) {
   $result = array();
   $CustomerReceiveInvoice = $_POST["CustomerReceiveInvoice"];
   $query = $conn->prepare("SELECT * FROM `Receive` WHERE `CustomerReceiveInvoice` LIKE '%" . $CustomerReceiveInvoice . "%' GROUP BY `CustomerReceiveInvoice` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['CustomerReceiveInvoice'];
   }

   echo json_encode($result);
}

if (isset($_POST['CustomerDueReceiveInvoice'])) {
   $result = array();
   $CustomerDueReceiveInvoice = $_POST["CustomerDueReceiveInvoice"];
   $query = $conn->prepare("SELECT * FROM `Receive` WHERE `CustomerDueReceiveInvoice` LIKE '%" . $CustomerDueReceiveInvoice . "%' GROUP BY `CustomerDueReceiveInvoice` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['CustomerDueReceiveInvoice'];
   }

   echo json_encode($result);
}


if (isset($_POST['SupplierPaymentInvoice'])) {
   $result = array();
   $SupplierPaymentInvoice = $_POST["SupplierPaymentInvoice"];
   $query = $conn->prepare("SELECT * FROM `Payment` WHERE `SupplierPaymentInvoice` LIKE '%" . $SupplierPaymentInvoice . "%' GROUP BY `SupplierPaymentInvoice` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['SupplierPaymentInvoice'];
   }

   echo json_encode($result);
}

if (isset($_POST['CustomerAddress'])) {
   $result = array();
   $Address = $_POST["CustomerAddress"];
   $query = $conn->prepare("SELECT * FROM `Customer` WHERE `Address` LIKE '%" . $Address . "%' GROUP BY `Address` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['Address'];
   }

   echo json_encode($result);
}



if (isset($_POST['CustomerReceiveNote'])) {
   $result = array();
   $ReceiveNote = $_POST["CustomerReceiveNote"];
   $query = $conn->prepare("SELECT * FROM `Receive` WHERE `ReceiveNote` LIKE '%" . $ReceiveNote . "%' AND `ReceiveType` = 'Customer Receive' GROUP BY `ReceiveNote` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['ReceiveNote'];
   }

   echo json_encode($result);
}


if (isset($_POST['CustomerDueReceiveNote'])) {
   $result = array();
   $ReceiveNote = $_POST["CustomerDueReceiveNote"];
   $query = $conn->prepare("SELECT * FROM `Receive` WHERE `ReceiveNote` LIKE '%" . $ReceiveNote . "%' AND `ReceiveType` = 'Customer Due Receive' GROUP BY `ReceiveNote` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['ReceiveNote'];
   }

   echo json_encode($result);
}


if (isset($_POST['SupplierPaymentNote'])) {
   $result = array();
   $PaymentNote = $_POST["SupplierPaymentNote"];
   $query = $conn->prepare("SELECT * FROM `Payment` WHERE `PaymentNote` LIKE '%" . $PaymentNote . "%' AND `PaymentType` = 'Supplier Payment' GROUP BY `PaymentNote` LIMIT 25");
   $query->execute();
   $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
   foreach ($fetch_list as $row) {
      $result[] =  $row['PaymentNote'];
   }

   echo json_encode($result);
}

exit();

?>
