<?php 
require_once("auth.php");
include("db.php");

$output= array();
$sql = "SELECT 
			`BankID`,
			`BranchName`,
			`BankName`,
			`AccountName`,
			`AccountNumber`,
            `OpeningBalance`, 
			`Status` 
		FROM `Bank`";
$count = $conn->prepare($sql);
$count->execute();
$total_all_rows = $count->rowCount();

$columns = array(
	0 => 'BankID',
	1 => 'BranchName',
	2 => 'BankName',
	3 => 'AccountName',
	4 => 'AccountNumber',
	5 => 'OpeningBalance',
	6 => 'Status'
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE 
	`BankID` like '%".$search_value."%'";
    $sql .= " OR `BranchName` like '%".$search_value."%'";
    $sql .= " OR `BankName` like '%".$search_value."%'";
    $sql .= " OR `AccountName` like '%".$search_value."%'";
    $sql .= " OR `AccountNumber` like '%".$search_value."%'";
    $sql .= " OR `OpeningBalance` like '%".$search_value."%'";
    $sql .= " OR `Status` like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
    $sql .= " ORDER BY `BankName`,LPAD(`BankID`, 3, '0') ASC";
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
    $sub_array[] = html_entity_decode(sprintf("%03d",$fetch["BankID"]));
    $sub_array[] = html_entity_decode($fetch["BranchName"]);
    $sub_array[] = html_entity_decode($fetch["BankName"]);
    $sub_array[] = html_entity_decode($fetch["AccountName"]);
    $sub_array[] = html_entity_decode($fetch["AccountNumber"]);
    $sub_array[] = html_entity_decode($fetch["OpeningBalance"]);
	$sub_array[] = "<span class=\"$status_span\">$fetch[Status]</span>";
						$sub_array[] = "<a class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
						data-whatever=\"$fetch[BankID]\">
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
