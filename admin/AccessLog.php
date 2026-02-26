<?php
require_once 'Auth.php'; // Session Starting file
include 'Database.php'; // Database connection file
?>
<script>
    
              //Auto Logout
        if (typeof (EventSource) !== "undefined") {
            var source = new EventSource("DuplicateLoginCheck.php?SessionID=<?php print $SessionID; ?>", {
                withCredentials: true
            });

            source.onmessage = function (event) {
                if (event.data == 'logout') {
                    window.location.href = "Login.php?notify=duplicate";

                    // alert(event.data);    
                }else{
                    // alert(event.data);    
                }
            };

        } 
</script>
