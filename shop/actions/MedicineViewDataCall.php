<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
include('function.php');

$output= array();
$sql = "SELECT * FROM medicine ";
$total_all_rows = GetMedicineAllRecords($conn);

$columns = array(
	0 => 'MedicineID',
	1 => 'MedicineName',
	2 => 'PurchasePrice',
	3 => 'PackSize',
	4 => 'SalePrice',
	5 => 'Company',
	6 => 'Generic',
	7 => 'Status',

);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE `MedicineName` like '%".$search_value."%'";
	$sql .= " OR `PurchasePrice` like '%".$search_value."%'";
	$sql .= " OR `PackSize` like '%".$search_value."%'";
	$sql .= " OR `SalePrice` like '%".$search_value."%'";
	$sql .= " OR `Status` like '%".$search_value."%'";
	$sql .= " OR `Company` like '%".$search_value."%'";
	$sql .= " OR `OpeningStock` like '%".$search_value."%'";
	$sql .= " OR `Generic` like '%".$search_value."%'";
	$sql .= " OR LPAD(`MedicineID`, 3, '0') like '%".$search_value."%'";

}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY MedicineName,Generic,Company desc";
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
	$sub_array[] = $Sl++;
	
	$PurchasePrice = number_format($fetch['PurchasePrice'], 2, '.', '');
	$SalePrice = number_format($fetch['SalePrice'], 2, '.', '');
	if($fetch['Status']=='Active'){ $status_span = "badge badge-success"; }else{ $status_span = "badge badge-danger"; }
	$sub_array[] = html_entity_decode($fetch["MedicineName"]);
	$sub_array[] = html_entity_decode($PurchasePrice);
	$sub_array[] = html_entity_decode($fetch["PackSize"]);
    $sub_array[] = "$SalePrice";
	$sub_array[] = html_entity_decode($fetch["Company"]);
    $sub_array[] = html_entity_decode($fetch["Generic"]);
    
	$sub_array[] = "<span class=\"$status_span\">$fetch[Status]</span>";

						$sub_array[] = "<a data-title=\"View To More Details\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
						data-whatever=\"$fetch[MedicineID]\">
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
