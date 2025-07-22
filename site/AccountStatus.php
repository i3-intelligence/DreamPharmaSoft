<?php
include("db.php"); ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: black;
}

* {
  box-sizing: border-box;
}

/* Add padding to containers */
.container {
  padding: 16px;
  background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

textarea {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: block;
  border: none;
  background: #f1f1f1;
  height: 100px;
}
/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
</style>
</head>
<body>
<?php
$Quary = $conn->prepare("SELECT A.*,B.`PackageName`,B.`PacakageAmount`,B.`NumberOfUser`
FROM `SslTransaction` A 
LEFT JOIN `Package` B ON (A.`value_a` = B.`Id`)
WHERE A.`val_id` = '$_GET[val_id]'");
$Quary->execute();
$FetchData = $Quary->fetch(PDO::FETCH_ASSOC);
?>
<form action="">
  <div class="container">
    <h1>Register New Shop</h1>
    <h3 style="color:blue"><?php print $FetchData['PackageName']; ?> Package <?php print $FetchData['PacakageAmount']; ?> Tk, <?php print $FetchData['value_d']; ?> Month, Total <?php print $FetchData['amount']; ?> Tk , Date: <?php print date("d/m/y",strtotime($FetchData['value_b'])); ?> To <?php print date("d/m/y",strtotime($FetchData['value_c'])); ?></h3>
    <hr>

    <label><b>Owner Name</b></label>
    <input type="text" onkeyup="check_input();" id="OwnerName" value=""placeholder="Enter Owner Name" >

    <label><b>Owner Mobile Number</b></label>
    <input  type="text" onkeyup="check_input();" id="Phone" value="" placeholder="Enter Owner 11 digit Mobile Number" oninput="this.className = ''" >

    <label><b>Shop Name</b></label>
    <input  type="text" onkeyup="check_input();" id="ShopName" value="" placeholder="Enter Shop Name" oninput="this.className = ''" >

    <label><b>Shop Address</b></label>
    <textarea  onkeyup="check_input();" id="ShopAddress" value="" oninput="this.className = ''" placeholder="Enter Shop Address"></textarea>
    <hr>
    <!-- <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p> -->

    <button type="submit" class="registerbtn">Register</button>
  </div>
  
  <div class="container signin">
    <p>Already have an account? <a href="#">Sign in</a>.</p>
  </div>
</form>
<script>
   function check_input() {
      var OwnerName = $('#OwnerName').val();
      var Phone = $('#Phone').val();

      if (/^[a-zA-Z0-9-  ]*$/.test(OwnerName) == false) {
        // toastr.error('Your Text contains illegal characters.');
        alert('Your Text contains illegal characters.')
        $('#OwnerName').val('');
      }

      if (Phone.length >= 12) {
        // toastr.error('Your Text contains illegal characters.');
        alert('Please Use 11 digit Mobile Number.')
    
        $('#Phone').val('');
      }
      if (/^[0-9-  ]*$/.test(Phone) == false) {
        // toastr.error('Your Text contains illegal characters.');
        alert('Please Use 11 digit Mobile Number.')
    
        $('#Phone').val('');
      }
    }

</script>
</body>
</html>
