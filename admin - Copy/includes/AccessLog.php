<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<script>
    
              //Auto Logout
        if (typeof (EventSource) !== "undefined") {
            var source = new EventSource("../actions/DuplicateLoginCheck.php?SessionID=<?php print $SessionID; ?>", {
                withCredentials: true
            });

            source.onmessage = function (event) {
                if (event.data == 'logout') {
                    window.location.href = "../actions/Logout.php";
                    // alert(event.data);    
                }else{
                    // alert(event.data);    
                }
            };

        } 
</script>
