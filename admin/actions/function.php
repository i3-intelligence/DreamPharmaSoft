<?php
function GetPackageAllRecords($conn)
{
	$query = "SELECT * FROM Package";

	$statement = $conn->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}


function GetOwnerAllRecords($conn)
{
	$query = "SELECT * FROM user_data WHERE Owner = 'Yes'";

	$statement = $conn->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}


function GetMedicineAllRecords($conn)
{
	$query = "SELECT * FROM Medicine";

	$statement = $conn->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

?>