<?php
  require_once("auth.php");
  include("db.php");
  include("count.php");
  
  //CAll Permission
  include("MenuPermission.php");
  // print_r($_POST);
if(MenuPermission('1',$conn,$SessionID) == 0){ 
  header("Location: PageNotFound.php");
  exit();
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <?php include("head.php"); ?>

  <body class="hold-transition layout-top-nav">
    <div class="wrapper">

      <!-- Preloader -->
      <?php include("preloader.php"); ?>

      <!-- Navbar -->
      <?php include("navbar.php"); ?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0"><?php print $PageLevel = " Menu Permission"; ?></h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="Report.php">Report</a></li>
                  <li class="breadcrumb-item active"><?php print $PageLevel; ?></li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <se class="content">
          <div class="container-fluid">
            <!-- Info boxes -->

            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <!-- <h3 class="card-title">
  Challan Summary Report
  </h3> -->

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">

                  <div class="col-md-6">
                    <!-- input states -->
                    <div class="form-group">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">User Info</span>
                        </div><select class="form-control select2" id="UserID" name="UserID" REQUIRED
                          onchange="UserIDSearch();">
                          <option value="">Select One</option>
                          <?php
  $query = $conn->prepare("SELECT * FROM `UserInformation` ORDER BY `UserName` ASC");
  $query->execute();
  $FetchSupplierData = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($FetchSupplierData AS $Fetch) {
  ?>
                          <option value="<?php print $Fetch['Id']; ?>"
                            <?php if(!empty($_GET['UserID']) && $_GET['UserID'] == $Fetch['Id']) { print "Selected"; } ?>>
                            <?php print $Fetch['UserName']; ?> |
                            <?php print $Fetch['Phone']; ?> |
                            <?php print $Fetch['Address']; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                    </div>

                  </div>


                </div>


              </div>

            </div>
            <!-- /.row -->

          </div>


          <!--/. container-fluid -->
          <?php 
          if(!empty($_POST['submit']) && $_POST['submit']=='Update Data')
          {
            $UserId =$_POST['pre_id'];
            $value=1;
            for($i=1;$i<=50;$i++)
            {
              if(!empty($_POST["menu_$i"]))
              { 
                $menu = $_POST["menu_$i"];
                @$value = "$value,$menu"; 
              }
              else
              {
                $menu = 0;
                @$value = "$value,$menu"; 
              }
              $menu_id = $value;
            }
              
                $CheckData = $conn->prepare("UPDATE `MenuPermission` SET 
                     
                      `MenuId`='' WHERE `UserId` = '$UserId' ");
                $CheckData->execute();
                  $Update = $conn->prepare("UPDATE `MenuPermission` SET 
                     
                      `MenuId`='$menu_id',
                      `LastUpdate`='$CurrentDateTime' 
                      WHERE `UserId` = '$UserId' ");
                      $Update->execute();
          ?>
          
          <script>
            alert('Add Menu Permission is >> Successfully Done');
            location.replace('MenuPermissionView.php?q=Update&UserID=<?php print $UserId; ?>');
          </script>
          
          <?php	
          
          
          } // IF
          
          
          
          if(!empty($_GET['UserID'])){ ?>
          <div class="container-fluid">
            <!-- Info boxes -->
            
            <?php
$query = $conn->prepare("SELECT * FROM `MenuPermission`  
WHERE UserID = '$_GET[UserID]' ");
$query->execute();
$FetchMenuData = $query->fetch(PDO::FETCH_ASSOC);

	if(!empty($FetchMenuData['MenuId'])){
		$MenuId = $FetchMenuData['MenuId'];
		$navex = explode(",",$FetchMenuData['MenuId']); // NAV ACCESS
	}else{
		$MenuId = '';
	}
?>
            <form action="MenuPermissionView.php" method="post" enctype="multipart/form-data">

<input type="hidden" name="pre_id" value="<?php if(!empty($_GET['q']) and $_GET['q']=='Update'){ print $_GET['UserID']; } ?>">

            <div class="card card-default">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title" title="Last Id : 35"><input type="checkbox" name="checkedAll" id="checkedAll" /><font color=red>Check all</font> / <input <?php if(!empty($navex[1]) && $navex[1]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_1' value='1'> Menu Permission
                </h3>

              </div>
  

              <!-- /.card-header -->
              <div class="card-body">
                <h5 class="mt-4 mb-2">Added Menu</h5>

                <div class="row">
                           
                           <div class="col-md-3">
                                   <!-- input states -->
                                   <div class="form-group">
                                   <ul>
                                   <li><input <?php if(!empty($navex[2]) && $navex[2]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_2' value='1'> Supplier Category View </li>
                                   <li><input <?php if(!empty($navex[3]) && $navex[3]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_3' value='1'>Supplier View </li>
                                   <li><input <?php if(!empty($navex[4]) && $navex[4]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_4' value='1'> Item Category View</li>
                                 
                                   </ul>
                             
                                   </div>

                             </div>
                             <div class="col-md-3">
                                   <!-- input states -->
                                   <div class="form-group">
                                   <ul>
                                   <li><input <?php if(!empty($navex[5]) && $navex[5]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_5' value='1'> Package Size View </li>
                                   <li><input <?php if(!empty($navex[6]) && $navex[6]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_6' value='1'> Customer Category View </li>
                                   <li><input <?php if(!empty($navex[7]) && $navex[7]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_7' value='1'>Customer Sub Category View</li>
                                   </ul>
                             
                                   </div>

                             </div>
                        
                             <div class="col-md-3">
                                   <!-- input states -->
                                   <div class="form-group">
                                   <ul>
                                   <li><input <?php if(!empty($navex[8]) && $navex[8]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_8' value='1'> Customer View </li>
                                   <li><input <?php if(!empty($navex[9]) && $navex[9]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_9' value='1'>Purchase Rate Setup</li>
                                   <li><input <?php if(!empty($navex[10]) && $navex[10]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_10' value='1'>Sales Rate Setup</li>
                                   </ul>
                             
                                   </div>

                             </div>
                        
                             <div class="col-md-3">
                                   <!-- input states -->
                                   <div class="form-group">
                                   <ul>
                                   <li><input <?php if(!empty($navex[11]) && $navex[11]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_11' value='1'>Wallet View</li>
                                   <li><input <?php if(!empty($navex[12]) && $navex[12]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_12' value='1'>Bank View</li>
                                   <li><input <?php if(!empty($navex[13]) && $navex[13]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_13' value='1'>Others Account View</li>
                                   </ul>
                             
                                   </div>

                             </div>
                        
                           </div>   

                          <h5 class="mt-4 mb-2">Receive/Payment/Challan/Cash Memo /Return Menu</h5>
                              <div class="row">
                                
                             <div class="col-md-3">
                                   <!-- input states -->
                                   <div class="form-group">
                                   <ul>
                                   <li><input <?php if(!empty($navex[14]) && $navex[14]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_14' value='1'>Customer Receive</li>
                                    <li><input <?php if(!empty($navex[35]) && $navex[35]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_35' value='1'>Other Receive</li>
                                  
                                   </ul>
                             
                                   </div>
                             </div>
                             
                             <div class="col-md-3">
                                   <!-- input states -->
                                   <div class="form-group">
                                   <ul>
                                   <li><input <?php if(!empty($navex[15]) && $navex[15]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_15' value='1'>Customer Due</li>
                                   <li><input <?php if(!empty($navex[16]) && $navex[16]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_16' value='1'>Supplier Payment</li>    
                                   </ul>
                             
                                   </div>
                             </div>
                             <div class="col-md-3">
                                   <!-- input states -->
                                   <div class="form-group">
                                   <ul>
                                   <li><input <?php if(!empty($navex[17]) && $navex[17]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_17' value='1'>Challan</li>
                                   <li><input <?php if(!empty($navex[18]) && $navex[18]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_18' value='1'>Cash Memo</li>    
                                   </ul>
                             
                                   </div>
                             </div>

                             <div class="col-md-3">
                                   <!-- input states -->
                                   <div class="form-group">
                                   <ul>
                                   <li><input <?php if(!empty($navex[19]) && $navex[19]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_19' value='1'>Challan Return</li>
                                   <li><input <?php if(!empty($navex[20]) && $navex[20]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_20' value='1'>Cash Memo Return</li>    
                                   </ul>
                             
                                   </div>
                             </div>
                              </div>
                              <h5 class="mt-4 mb-2">Report Menu</h5>
                           <div class="row">
                            <div class="col-md-3">
                                    <!-- input states -->
                                    <div class="form-group">
                                    <ul>
                                    <li><input <?php if(!empty($navex[21]) && $navex[21]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_21' value='1'>Challan Report</li>
                                    <li><input <?php if(!empty($navex[22]) && $navex[22]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_22' value='1'>Sales Report</li>    
                                    <li><input <?php if(!empty($navex[23]) && $navex[23]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_23' value='1'>Stock Report</li> 
                                    <li><input <?php if(!empty($navex[24]) && $navex[24]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_24' value='1'>Profit/Loss Report</li> 
                                    </ul>
                              
                                    </div>
                              </div>

                              <div class="col-md-3">
                                    <!-- input states -->
                                    <div class="form-group">
                                    <ul>
                                   
                                    <li><input <?php if(!empty($navex[25]) && $navex[25]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_25' value='1'>Challan Return Report</li> 
                                    
                                    <li><input <?php if(!empty($navex[26]) && $navex[26]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_26' value='1'>Sales Return Report</li> 

                                    </ul>
                              
                                    </div>
                              </div>

                              <div class="col-md-3">
                                    <!-- input states -->
                                    <div class="form-group">
                                    <ul>
                                   
                                    <li><input <?php if(!empty($navex[27]) && $navex[27]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_27' value='1'>Supplier Ledger Report</li> 
                                    
                                    <li><input <?php if(!empty($navex[28]) && $navex[28]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_28' value='1'> Customer Ledger Report</li> 
                                     
                                    <li><input <?php if(!empty($navex[29]) && $navex[29]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_29' value='1'> Wallet Ledger Report</li> 

                                    </ul>
                              
                                    </div>
                              </div>

                              
                              <div class="col-md-3">
                                    <!-- input states -->
                                    <div class="form-group">
                                    <ul>
                                   
                                    <li><input <?php if(!empty($navex[30]) && $navex[30]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_30' value='1'>User View</li> 
                                    
                                    <li><input <?php if(!empty($navex[31]) && $navex[31]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_31' value='1'>Delete</li> 

                                    <li><input <?php if(!empty($navex[32]) && $navex[32]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_32' value='1'>Edit Challan</li> 

                                    <li><input <?php if(!empty($navex[33]) && $navex[33]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_33' value='1'>Balance Summary</li> 

                                    
                                    <li><input <?php if(!empty($navex[34]) && $navex[34]==1){ ?> checked <?php } ?> type='checkbox' class="checkSingle" name='menu_34' value='1'>BackDate</li> 


                                    </ul>
                              
                                    </div>
                              </div>

                           </div> 

                           <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success float-right"  name="submit" value="Update Data">
                                    </div>

                                </div>
                            </div>


              </div>
            </div>
          </div>
</form>
          <?php } ?>
        


      </div>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <?php include("SideBar.php"); ?>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php 
  include("footer.php");
  include("AccessLog.php");
  ?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <?php include("RequiredJS.php");?>
  </body>

  <script>
    // LOAD Sub Item SupplierCategory
    function UserIDSearch() {
      //get the VALUE
      var UserID = $('#UserID').val();
      // alert(UserID);
      window.location.assign("MenuPermissionView.php?q=Update&UserID=" + UserID);


    }


$(document).ready(function() {
  $("#checkedAll").change(function(){
    if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }     
    }else {
      $("#checkedAll").prop("checked", false);
    }
  });
});
</script>

  </html>