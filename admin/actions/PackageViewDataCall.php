<?php
require_once '../includes/auth.php'; // Session Starting file
include '../config/database.php'; // Database connection file
include('function.php');

$output= array();
$sql = "SELECT * FROM Package ";
$total_all_rows = GetPackageAllRecords($conn);

$columns = array(
	0 => 'Id',
	1 => 'PackageName',
	2 => 'PacakageDuration',
	3 => 'PacakageAmount',
	4 => 'CreateDate',
	5 => 'LastUpdate',
	6 => 'Status',
	8 => 'NumberOfUser',

);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE PackageName like '%".$search_value."%'";
	$sql .= " OR PacakageDuration like '%".$search_value."%'";
	$sql .= " OR PacakageAmount like '%".$search_value."%'";
	$sql .= " OR CreateDate like '%".$search_value."%'";
	$sql .= " OR LastUpdate like '%".$search_value."%'";
	$sql .= " OR Status like '%".$search_value."%'";
	$sql .= " OR NumberOfUser like '%".$search_value."%'";

}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY NumberOfUser desc";
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
	
	$CreateDate = date("d/m/Y - h:i:s a",strtotime($fetch['CreateDate']));
	if($fetch['Status']=='Active'){ $status_span = "badge badge-success"; }else{ $status_span = "badge badge-danger"; }
	$sub_array[] = html_entity_decode($fetch["PackageName"]);
	$sub_array[] = html_entity_decode($fetch["PacakageDuration"]);
	$sub_array[] = html_entity_decode($fetch["PacakageAmount"]);
	$sub_array[] = html_entity_decode($fetch["NumberOfUser"]);

	$sub_array[] = "<span class=\"$status_span\">$fetch[Status]</span>";
	$sub_array[] = "<details>
					  <summary> $CreateDate</summary>
					  <p>$fetch[LastUpdate]</p>
					</details>";
						$sub_array[] = "<a data-title=\"View To More Details\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
						data-whatever=\"$fetch[Id]\">
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
