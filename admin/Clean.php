<?php
//Function to sanitize values received from the form. Prevents SQL injection
function clean($str)
{ 
  // $str = trim($str);

  while(substr($str, 0,1)==" ") 
    {
        $str = substr($str, 1);
        clean($str);
    }
    while(substr($str, -1)==" ")
    {
        $str = substr($str, 0, -1);
        clean($str);
    }

  // Convert the first character of "hello" to uppercase:
  $str = ucfirst($str);

  // Convert the first character of each word in a string to uppercase: 
  $str = stripslashes($str);


  return addslashes(strip_tags(htmlspecialchars(htmlentities($str))));
}
?>