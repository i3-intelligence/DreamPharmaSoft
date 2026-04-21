<?php 
require_once("auth.php");
include("db.php");

$output= array();
$sql = "SELECT 
            `id`,
			`UserName`,
			`User` ,
			`DecryptPassword`,
            `Admin` ,
            `EditAccess`,
            `DeleteAccess`,
            `Block`
		FROM `UserInformation`";
$count = $conn->prepare($sql);
$count->execute();
$total_all_rows = $count->rowCount();

$columns = array(
	0 => 'UserName',
	1 => 'User',
	2 => 'DecryptPassword',
    3 => 'Admin',
    4 => 'EditAccess',
    5 => 'DeleteAccess',
    6 => 'Block',
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE 
	`UserName` like '%".$search_value."%'";
    $sql .= " OR `User` like '%".$search_value."%'";
    $sql .= " OR `DecryptPassword` like '%".$search_value."%'";
    $sql .= " OR `Admin` like '%".$search_value."%'";
    $sql .= " OR `EditAccess` like '%".$search_value."%'";
    $sql .= " OR `DeleteAccess` like '%".$search_value."%'";
    $sql .= " OR `Block` like '%".$search_value."%'";

    
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
    $sql .= " ORDER BY `User` ASC";
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

	if($fetch['Admin']=='No'){ $admin_span = "badge badge-success"; }else{ $admin_span = "badge badge-danger"; }
 
	if($fetch['EditAccess']=='No'){ $EditAccess_span = "badge badge-success"; }else{ $EditAccess_span = "badge badge-danger"; }

    if($fetch['DeleteAccess']=='No'){ $DeleteAccess_span = "badge badge-success"; }else{ $DeleteAccess_span = "badge badge-danger"; }
    
    
    if($fetch['Block']=='No'){ $Block_span = "badge badge-success"; }else{ $Block_span = "badge badge-danger"; }

    $sub_array[] = html_entity_decode($fetch["UserName"]);
    $sub_array[] = html_entity_decode($fetch["User"]);
    $sub_array[] = html_entity_decode($fetch["DecryptPassword"]);

	$sub_array[] = "<span class=\"$admin_span\">$fetch[Admin]</span>";
	$sub_array[] = "<span class=\"$EditAccess_span\">$fetch[EditAccess]</span>";
	$sub_array[] = "<span class=\"$DeleteAccess_span\">$fetch[DeleteAccess]</span>";
	$sub_array[] = "<span class=\"$Block_span\">$fetch[Block]</span>";

						$sub_array[] = "<a class=\"btn btn-warning\" data-toggle=\"modal\" data-target=\"#modal-default1\"
						data-whatever=\"$fetch[id]\">
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
