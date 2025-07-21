<?php 
// Db Connection
include('db.php');
?>
<!doctype html>
<html lang="eng">
<?php 
// Header
include('head.php');
?>

<body>
    <!-- ***************************** Head Starts Here *********************************-->
    <div class="head-cover">
        <?php 
// Header
include('header.php');
?>
    </div>
<?php
$Quary = $conn->prepare("SELECT * FROM `Package` WHERE `Id` = '$_GET[id]' ORDER BY `PacakageAmount` ASC");
$Quary->execute();
$FetchData = $Quary->fetch(PDO::FETCH_ASSOC);

    $PackageName = $FetchData['PackageName'];
    $PacakageAmount = $FetchData['PacakageAmount'];
    $PacakageDuration = $FetchData['PacakageDuration'];
    $NumberOfUser = $FetchData['NumberOfUser'];
    $StartDate = date("Y-m");

    if($_GET['id'] == '1'){
        $ExpiryDate = date("Y-m",strtotime( date("Y-m", strtotime( date("Y-m")) ). "+3 Month"));
        $TotalMonth = 3;
    }else{
        $ExpiryDate = date("Y-m",strtotime( date("Y-m", strtotime( date("Y-m")) ). "+1 Month"));
        $TotalMonth = 1;

    }
?>
    <!--  ************************* Page Title Starts Here ************************** -->
    <div class="page-nav no-margin row">
        <div class="container">
            <div class="row">
                <h2>Package Choose</h2>
                <br>
                <br>
                <h5>
                    <p style="color:blue;"><?php print $PackageName; ?> <?php print $PacakageAmount; ?> Tk
                        <?php print $PacakageDuration; ?> <?php print $NumberOfUser; ?> User </p>
                </h5>
            </div>
        </div>
    </div>




    <!--  ************************* Contact Us Starts Here ************************** -->


    <div class="row contact-rooo no-margin">
        <div class="container">
            <form action="Payment.php" method="Post">
                    <input type="hidden" value="<?php print $_GET['id']; ?>" name="PackageId">
                    <input type="hidden" value="<?php print $PackageName; ?>" name="PackageName" id="PackageName">
                    <input type="hidden" value="<?php print $PacakageAmount; ?>" name="PacakageAmount" id="PacakageAmount">
                <div class="row">


                    <div style="padding:20px" class="col-sm-12">
                        <div class="row cont-row">
                            <div class="col-sm-4"><label><b>Start Date</b> (You Can Change Month) </label><span>:</span></div>
                            <div class="col-sm-8">
                                <input type="month" value="<?php print $StartDate; ?>" placeholder="Enter Name"
                                    name="StartDate" id="StartDate" onchange="PaymentCalculation();" <?php if($_GET['id'] == '1'){ print "Readonly"; } ?> class="form-control input-sm"></div>
                        </div>

                        <div class="row cont-row">
                            <div class="col-sm-4"><label><b>End Date</b> (You Can Expand Month) </label><span>:</span></div>
                            <div class="col-sm-8">
                              
                                <input type="month" value="<?php print $ExpiryDate; ?>" onchange="PaymentCalculation();" placeholder="Enter Name"
                                    name="ExpiryDate" id="ExpiryDate" <?php if($_GET['id'] == '1'){ print "Readonly"; } ?> class="form-control input-sm"></div>
                        </div>

                        <div class="row cont-row">
          
                            <div class="col-sm-6">
                                <div class="input-group mb-2">
                                <div class="input-group-text">Total</div>
                                    <input type="text" readonly style="text-align:right;  font-weight: bold;"  class="form-control" name="TotalMonth" id="TotalMonth"  value="<?php print $TotalMonth; ?>">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Month</div>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="col-sm-6">
                                <div class="input-group mb-2">
                                <div class="input-group-text">Total Payment Amount</div>
                                <input type="number" readonly style="text-align:right;  font-weight: bold;" value="<?php print $PacakageAmount; ?>"
                                    placeholder="Enter Name" name="PayemntAmount" id="PayemntAmount" class="form-control input-sm">
                                        <div class="input-group-text">Tk</div>
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div style="margin-top:10px; margin-bottom:10px;" class="row">
                            <div class="col-sm-12">
                            <label>You Can Payment Online </label>
                                <button class="btn btn-success btn-sm">Make Payment</button>
                            </div>
                            <div style="padding-top:10px;" class="col-sm-3"></div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>

<script>
    // Payment Calculation
    function PaymentCalculation(){

        var PacakageAmount = document.getElementById("PacakageAmount").value;
        var StartDate = document.getElementById("StartDate").value;
        var ExpiryDate = document.getElementById("ExpiryDate").value;

        if(StartDate < '<?php print $StartDate; ?>'){
            alert("Please Select Current Date OR Future Date");
            document.getElementById("StartDate").value = '<?php print $StartDate; ?>';
            StartDate = '<?php print $StartDate; ?>';
        }
        if(ExpiryDate <= StartDate){
            alert("Please Make Sure Minimum One Month Duration");
            document.getElementById("StartDate").value = '<?php print $StartDate; ?>';
            document.getElementById("ExpiryDate").value = '<?php print $ExpiryDate; ?>';
            StartDate = '<?php print $StartDate; ?>';
            ExpiryDate = '<?php print $ExpiryDate; ?>';
        }

        var StartDate = new Date(StartDate);
        var ExpiryDate = new Date(ExpiryDate);
        var diff = ExpiryDate.getTime() - StartDate.getTime();
        var days = diff / (1000 * 60 * 60 * 24);
        var TotalMonth =  Math.round(days / 30);
        var TotalAmount =parseFloat(PacakageAmount * TotalMonth).toFixed(2);
        document.getElementById("TotalMonth").value =  Math.round(TotalMonth);
        document.getElementById("PayemntAmount").value = TotalAmount;

    }

</script>
<?php 
// Footer
include('footer.php');
?>


</body>

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/plugins/testimonial/js/owl.carousel.min.js"></script>
<script src="assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js"></script>
<script src="assets/js/script.js"></script>

</html>