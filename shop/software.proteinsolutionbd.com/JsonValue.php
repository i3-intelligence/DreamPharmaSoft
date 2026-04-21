<?php
include("auth.php");
include("db.php");
include_once("clean.php");
header('Content-Type: application/json');

# LOAD Item Category
if(!empty($_POST['SupplierID'])){

        $SupplierID = clean($_POST['SupplierID']);
        $loadItemCategory = " <div class=\"input-group mb-3\">
		<div class=\"input-group-prepend\">
		<span class=\"input-group-text\">Item Category
</span>
		</div>
		<select class=\"form-control select2\"name=\"ItemCategoryID\" id=\"ItemCategoryID\" required>
		<option value=\"\">Select One</option>

		";
		
        $query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `SupplierID` = '$SupplierID' AND `Status` = 'Active' "); 
        $query->execute();
        $fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($fetch_list AS $fetch) { 
                                    

		$loadItemCategory.= "<option value=\"$fetch[ItemCategoryID]\"> $fetch[Name] </option>";
	}					
	$loadItemCategory.= "</select></div>";

	$data['loadItemCategory'] = $loadItemCategory;
	echo json_encode ($data);
}


# LOAD Item Category 2
if(!empty($_POST['SupplierID2'])){

	$SupplierID2 = clean($_POST['SupplierID2']);
	$loadItemCategory = " <div class=\"input-group mb-3\">
	<div class=\"input-group-prepend\">
	<span class=\"input-group-text\">Item Category
</span>
	</div>
	<select class=\"form-control select2\"name=\"ItemCategoryID2\" id=\"ItemCategoryID2\" required>
	<option value=\"All\">Select All</option>

	";
	
	$query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `SupplierID` = '$SupplierID2' AND `Status` = 'Active' "); 
	$query->execute();
	$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($fetch_list AS $fetch) { 
								

	$loadItemCategory.= "<option value=\"$fetch[ItemCategoryID]\"> $fetch[Name] </option>";
}					
$loadItemCategory.= "</select></div>";

$data['loadItemCategory'] = $loadItemCategory;
echo json_encode ($data);
}


# LOAD Item Category 2
if(!empty($_POST['SupplierID3'])){

	$SupplierID3 = clean($_POST['SupplierID3']);
	$loadItemCategory = " <div class=\"input-group mb-3\">
	<div class=\"input-group-prepend\">
	<span class=\"input-group-text\">Item Category
</span>
	</div>
	<select class=\"form-control select2\"name=\"ItemCategoryID\" id=\"ItemCategoryID\" required>
	<option value=\"All\">Select All</option>

	";
	
	$query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `SupplierID` = '$SupplierID3' AND `Status` = 'Active' "); 
	$query->execute();
	$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($fetch_list AS $fetch) { 
								

	$loadItemCategory.= "<option value=\"$fetch[ItemCategoryID]\"> $fetch[Name] </option>";
}					
$loadItemCategory.= "</select></div>";

$data['loadItemCategory'] = $loadItemCategory;
echo json_encode ($data);
}


# LOAD Item Category Multiple
if(!empty($_POST['SupplierIDMultiple'])){

	$SupplierIDMultiple = clean($_POST['SupplierIDMultiple']);
	$loadItemCategory = "<div class=\"input-group mb-3\">
	<div class=\"input-group-prepend\">
	<span class=\"input-group-text\">Item Category</span>
	</div><select class=\"form-control select2\" multiple name=\"ItemCategoryID[]\" REQUIRED id=\"ItemCategoryID\">
	";
	
	$query = $conn->prepare("SELECT * FROM `ItemCategory` WHERE `SupplierID` = '$SupplierIDMultiple' AND `Status` = 'Active' ORDER BY `Name` ASC "); 
	$query->execute();
	$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($fetch_list AS $fetch) { 
								

	$loadItemCategory.= "<option value=\"$fetch[ItemCategoryID]\"> $fetch[Name] </option>";
}					
$loadItemCategory.= "</select></div>";

$query2 = $conn->prepare("SELECT * FROM `Supplier` WHERE `SupplierID` = '$SupplierIDMultiple' AND `Status` = 'Active' ORDER BY `Name` ASC "); 
$query2->execute();
$FetchSupplier = $query2->fetch(PDO::FETCH_ASSOC);

$data['ChallanInvoice'] = current(explode(' ',$FetchSupplier['Name']));

$data['loadItemCategory'] = $loadItemCategory;
echo json_encode ($data);
}


# LOAD Item Category Multiple Seles
if(!empty($_POST['SupplierIDMultipleSeles'])){

	$SupplierIDMultipleSeles = clean($_POST['SupplierIDMultipleSeles']);

	$loadItemCategory = "<div class=\"input-group mb-3\">
	<div class=\"input-group-prepend\">
	<span class=\"input-group-text\">Item Category</span>
	</div><select class=\"form-control select2\" multiple name=\"ItemCategoryID[]\" REQUIRED id=\"ItemCategoryID\">
	";
	
	$query = $conn->prepare("SELECT A.* FROM `ItemCategory` A
	JOIN (SELECT * FROM `Challan` WHERE `Status` = 'Active' AND `Cart` = 'Yes' AND `Quantity` != '0' GROUP BY `ItemCategoryID` ) B ON (A.`ItemCategoryID` = B.`ItemCategoryID`) 
	 WHERE A.`Status` = 'Active' AND  A.`SupplierID` = '$SupplierIDMultipleSeles' ORDER BY A.`Name` ASC "); 
	$query->execute();
	$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($fetch_list AS $fetch) { 
								

	$loadItemCategory.= "<option value=\"$fetch[ItemCategoryID]\"> $fetch[Name] </option>";
}					
$loadItemCategory.= "</select></div>";

$query2 = $conn->prepare("SELECT * FROM `Supplier` WHERE `SupplierID` = '$SupplierIDMultipleSeles' AND `Status` = 'Active' ORDER BY `Name` ASC "); 
$query2->execute();
$FetchSupplier = $query2->fetch(PDO::FETCH_ASSOC);

$data['ChallanInvoice'] = current(explode(' ',$FetchSupplier['Name']));

$data['loadItemCategory'] = $loadItemCategory;
echo json_encode ($data);
}


//Sales Type
if(!empty($_POST['SalesType'])){

	$SalesType = clean($_POST['SalesType']);
	
	if($SalesType == 'Cash'){
		$SalesCategoryLoad = "
		<div class=\"col-md-6\">
		<div class=\"form-group\">
		<div class=\"input-group mb-3\">
		<div class=\"input-group-prepend\">
		<span class=\"input-group-text\">Customer Name</span>
		</div>
		<input type=\"text\" class=\"form-control\"  pattern=\"\S(.*\S)?\" required name=\"CustomerName\" placeholder=\"Enter Customer Name\" value=\"Cash Customer\"></div>
	</div>
	</div>
	";
	$SalesCategoryLoad .= "
	<div class=\"col-md-6\">
	<div class=\"form-group\">
	<div class=\"input-group mb-3\">
<div class=\"input-group-prepend\">
<span class=\"input-group-text\">Customer Address</span>
</div>
<input type=\"text\" class=\"form-control\" required name=\"CustomerAddress\" placeholder=\"Enter Customer Address\" value=\"Store\">
</div>
	</div>
	</div>
	<input type=\"hidden\" name=\"CustomerBalance\" Value=\"0\">
	";

	}else if($SalesType == 'Due'){
		$SalesCategoryLoad = "
		<div class=\"col-md-6\">
		<div class=\"form-group\">
		<div class=\"input-group mb-3\">
		<div class=\"input-group-prepend\">
		<span class=\"input-group-text\">Customer Name</span>
		</div>
		<select class=\"form-control select2\" name=\"CustomerID\" id=\"CustomerID\" required>
		<option >Select One</option>";

		$query = $conn->prepare("SELECT * FROM `Customer` WHERE `Status` = 'Active' ORDER BY `Name` ASC"); 
		$query->execute();
		$fetch_list = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach($fetch_list AS $fetch) { 

		$SalesCategoryLoad .= "<option value=\"$fetch[CustomerID]\">
			$fetch[CustomerID] -
			$fetch[Name] -
			$fetch[MobileNo] -
			$fetch[Address]
			</option>";
		} 
 $SalesCategoryLoad .="</select></div>
 </div>
 </div>";

}
$data['SalesCategoryLoad'] = $SalesCategoryLoad;
echo json_encode ($data);
}