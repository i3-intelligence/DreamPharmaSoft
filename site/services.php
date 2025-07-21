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

    <!--  ************************* Page Title Starts Here ************************** -->
<div class="page-nav no-margin row">
    <div class="container">
        <div class="row">
            <h2>Our Package</h2>
            <ul>
                <li> <a href="#"><i class="fas fa-home"></i> Home</a></li>
                <li><i class="fas fa-angle-double-right"></i> Package</li>
            </ul>
        </div>
    </div>
</div>
   
   

<!--*************** Features Starts Here ***************-->
    <section id="features" class="features pt-0 container-fluid">
        <div class="container">
           
                <?php 
                // Package List
                include('PackageList.php');
                ?>
        </div>
    </section>


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