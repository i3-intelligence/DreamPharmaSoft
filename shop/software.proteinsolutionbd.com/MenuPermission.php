<?php
require_once("auth.php");
include("db.php");

function MenuPermission(int $MenuID, PDO $conn, int $SessionID): int {

    // Prepare and execute the query
    $query = $conn->prepare("SELECT * FROM `MenuPermission` WHERE UserID = :sessionID");
    $query->bindParam(':sessionID', $SessionID, PDO::PARAM_INT);
    $query->execute();
    $FetchMenuData = $query->fetch(PDO::FETCH_ASSOC);

    // Initialize variables
    $navex = [];

    if (!empty($FetchMenuData['MenuId'])) {
        $navex = explode(",", $FetchMenuData['MenuId']); // NAV ACCESS
    }

    // Check for specific permission
    if (!empty($navex[$MenuID]) && $navex[$MenuID] == 1) { 
        return 1; // Permission granted
    }

    return 0; // Permission denied
}

// Example usage

// $MenuID = 2; // Replace with the actual Menu ID to check

// if (MenuPermission(2, $conn, $SessionID) == 1) {
//     print "hi";
// }
?>
