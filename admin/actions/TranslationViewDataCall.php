<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
include('Function.php');

$output= array();
$sql = "SELECT id, translation_key, en, bn FROM app_translations ";
$total_all_rows = GetTranslationAllRecords($conn);

$columns = array(
	0 => 'id',
	1 => 'translation_key',
	2 => 'en',
	3 => 'bn'
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE translation_key like '%".$search_value."%'";
	$sql .= " OR en like '%".$search_value."%'";
	$sql .= " OR bn like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY id desc";
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

foreach($result as $fetch)
{
	$sub_array = array();
	$sub_array[] = $fetch['id'];
	$sub_array[] = html_entity_decode($fetch["translation_key"]);
	$sub_array[] = html_entity_decode($fetch["en"]);
	$sub_array[] = html_entity_decode($fetch["bn"]);
	
    $sub_array[] = "<a data-title=\"Edit Translation\" class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
                    data-whatever=\"$fetch[id]\">
                    <i class=\"fas fa-pencil-alt\"></i>
                    Edit
                    </a>";
		
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$total_all_rows,
	'recordsFiltered'=> $count_rows,
	'data'=>$data,
);
echo json_encode($output);
?>
