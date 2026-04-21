<?php 
require_once("auth.php");
include("db.php");

$output= array();
$sql = "SELECT 
                A.`PackageSizeID`,
                A.`Thickness`,
                A.`Size`,
                CONCAT(B.`Name`,' - ', B.`MobileNo`,' - ', B.`Address`) AS `SupInfo`,
                C.`Name` AS `ItemCategory`,
                A.`LowStock`,
                A.`Status` 
        FROM `PackageSize` A 
        LEFT JOIN `Supplier` B ON (A.`SupplierID` = B.`SupplierID`) 
        LEFT JOIN `ItemCategory` C ON (A.`ItemCategoryID` = C.`ItemCategoryID`) 
        ";
$count = $conn->prepare($sql);
$count->execute();
$total_all_rows = $count->rowCount();

$columns = array(
	0 => 'PackageSizeID',
	1 => 'Thickness',
	2 => 'Size',
	3 => 'ItemCategory',
	4 => 'SupInfo',
	5 => 'LowStock',
	6 => 'Status',
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE 
	A.`PackageSizeID` like '%".$search_value."%'";
    $sql .= " OR A.`Thickness` like '%".$search_value."%'";
    $sql .= " OR A.`Size` like '%".$search_value."%'";
    $sql .= " OR A.`LowStock` like '%".$search_value."%'";
    $sql .= " OR C.`Name` like '%".$search_value."%'";
    $sql .= " OR CONCAT(B.`Name`,' - ', B.`MobileNo`,' - ', B.`Address`) like '%".$search_value."%'";
    $sql .= " OR A.`Status` like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
    $sql .= "ORDER BY A.`Thickness`,A.`Size`,A.`PackageSizeID` ASC";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$count_rows = $statement->rowCount();
$data = array();
$Sl = 1;
foreach($result as $fetch)
{
	$sub_array = array();

	if($fetch['Status']=='Active'){ $status_span = "badge badge-success"; }else{ $status_span = "badge badge-danger"; }
    $sub_array[] = html_entity_decode(sprintf("%03d",$fetch["PackageSizeID"]));
    $sub_array[] = html_entity_decode($fetch["Thickness"]);
    $sub_array[] = html_entity_decode($fetch["Size"]);
    $sub_array[] = html_entity_decode($fetch["ItemCategory"]);
    $sub_array[] = html_entity_decode($fetch["SupInfo"]);
    $sub_array[] = html_entity_decode($fetch["LowStock"]);
	$sub_array[] = "<span class=\"$status_span\">$fetch[Status]</span>";
						$sub_array[] = "<a class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
						data-whatever=\"$fetch[PackageSizeID]\">
						<i class=\"fas fa-pencil-alt\"></i>
						Edit
					  </a>";
		
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
