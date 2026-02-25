<?php
function GetpackageAllRecords($conn)
{
	$query = "SELECT * FROM package";

	$statement = $conn->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}


function GetOwnerAllRecords($conn)
{
	$query = "SELECT * FROM user_information WHERE Owner = 'Yes'";

	$statement = $conn->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}


function GetMedicineAllRecords($conn)
{
	$query = "SELECT * FROM medicine";

	$statement = $conn->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

?>