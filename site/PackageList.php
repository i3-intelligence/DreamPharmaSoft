
<?php 
// Db Connection
include("../admin/config/database.php");
?>
           <div class="row mt-5 feature-row">
           <?php
           $Quary = $conn->prepare("SELECT * FROM `package` WHERE `Status` = 'Active' ORDER BY `PacakageAmount` ASC");
           $Quary->execute();
           $FetchData = $Quary->fetchAll(PDO::FETCH_ASSOC);
              foreach ($FetchData as $Fetch) {
           ?>

                <div class="col-md-4">
                    <div class="feature-col">
                       <!-- <img src="assets/images/services/s1.png" alt=""> -->
                        <center>            
                            <h1 style="color:blue;"><?php print $Fetch['PackageName']; ?></h1>
                            <h3><?php print $Fetch['PacakageAmount']; ?> Tk</h3>
                            <b><?php print $Fetch['PacakageDuration']; ?></b>
                            <p style="color: red;" >Number Of User <?php print $Fetch['NumberOfUser']; ?> Person</p>
                            <a style="color: Black;" href="PackageChoose.php?id=<?php print $Fetch['Id']; ?>"  class="btn btn-outline-primary"><b>Buy Now</b></a>
                        </center>
                    </div>
                </div>
<?php } ?>
            </div>