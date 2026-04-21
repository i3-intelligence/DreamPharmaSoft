<?php
require_once("auth.php");
include("db.php");
include("count.php");
//CAll Permission
include("MenuPermission.php");
if(MenuPermission('31',$conn,$SessionID) == 0){ 
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
              <h1 class="m-0"><?php print $PageLevel = "Delete Cash Memo Menu"; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active"><?php print $PageLevel; ?></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">


          <div class="card">
            <!-- <div class="card-header">
              <h3 class="card-title"> Transaction Menu</h3>
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">

              <!-- Info boxes -->
              <div class="row">

             
            
                
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission(2,$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a data-toggle="modal" data-target="#modal-default"  class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Cash Memo Delete</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    Total Cash Memo Invoice <?php Print $ActiveCashMemoInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                      
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission(2,$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a data-toggle="modal" data-target="#modal-default2"  class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Cash Memo Return Delete</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    Total Cash Memo Return Invoice <?php Print $ActiveCashMemoReturnInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                  
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission(2,$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a data-toggle="modal" data-target="#modal-default3"  class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Customer Receive Delete</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    Total Customer Receive Invoice <?php Print $ActiveCustomerReceiveInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

                   
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission(2,$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a data-toggle="modal" data-target="#modal-default4"  class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Customer Due Delete</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    Total Customer Due Invoice <?php Print $ActiveCustomerDueReceiveInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

              </div>
              <!-- /.row -->

              <!-- Info boxes -->
              <div class="row">

              
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>
                <?php if(MenuPermission(2,$conn,$SessionID) == 1){ ?>
                <div class="col-md-3">
                  <a data-toggle="modal" data-target="#modal-default5"  class="card card-danger">
                    <div class="card-header">
                      <h3 class="card-title">
                        <span class="material-icons">local_offer</span> Supplier Payment Delete</h3>
                      <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    Total Supplier Payment Invoice <?php Print $ActiveSupplierPaymentInvoice; ?>
                    </div>
                    <!-- /.card-body -->
                  </a>

                </div>
                <!-- /.col -->
                <?php } ?>

              </div>
              <!-- /.row --> 
            </div>
          </div>

        </div>
        <!--/. container-fluid -->
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

<!-- Cash Memo Modals -->
<div class="modal fade" id="modal-default" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"> Are You Sure To Delete Cash Memo ?</h4>
            </div>
            <div class="modal-body">

                <div class="dash">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Invoice No</span>
                        </div>
                        <input type="text" class="form-control" id="CashMemoInvoice"  name="CashMemoInvoice" value="" 
                                                <?php print $AutoComplete; ?>
                                                list="CashMemoInvoiceList"
                                                OnKeyUp="CashMemoInvoiceList();">
                                                <datalist id="CashMemoInvoiceList"> </datalist>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                <input type="button" id="CashMemoInvoiceView" onclick="CashMemoInvoiceView();" value="Invoice View" class="btn btn-dark">
                <input type="button" id="CashMemoInvoiceDelete" onclick="CashMemoInvoiceDelete();" value="Delete" class="btn btn-danger">
   
            </div>
        </div>
    </div>
</div>



<!-- Cash Memo Return Modals -->
<div class="modal fade" id="modal-default2" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"> Are You Sure To Delete Cash Memo Return?</h4>
            </div>
            <div class="modal-body">

                <div class="dash">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Invoice No</span>
                        </div>
                        <input type="text" class="form-control" id="CashMemoReturnInvoice"  name="CashMemoReturnInvoice" value="" 
                                                <?php print $AutoComplete; ?>
                                                list="CashMemoReturnInvoiceList"
                                                OnKeyUp="CashMemoReturnInvoiceList();">
                                                <datalist id="CashMemoReturnInvoiceList"> </datalist>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                <input type="button" id="CashMemoReturnInvoiceView" onclick="CashMemoInvoiceReturnView();" value="Invoice View" class="btn btn-dark">
                <input type="button" id="CashMemoReturnInvoiceDelete" onclick="CashMemoReturnInvoiceDelete();" value="Delete" class="btn btn-danger">
   
            </div>
        </div>
    </div>
</div>



<!-- Customer Receive Modals -->
<div class="modal fade" id="modal-default3" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"> Are You Sure To Delete Customer Receive?</h4>
            </div>
            <div class="modal-body">

                <div class="dash">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Invoice No</span>
                        </div>
                        <input type="text" class="form-control" id="CustomerReceiveInvoice"  name="CustomerReceiveInvoice" value="" 
                                                <?php print $AutoComplete; ?>
                                                list="CustomerReceiveInvoiceList"
                                                OnKeyUp="CustomerReceiveInvoiceList();">
                                                <datalist id="CustomerReceiveInvoiceList"> </datalist>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                <input type="button" id="CustomerReceiveInvoiceView" onclick="CustomerReceiveView();" value="Invoice View" class="btn btn-dark">
                <input type="button" id="CustomerReceiveInvoiceDelete" onclick="CustomerReceiveInvoiceDelete();" value="Delete" class="btn btn-danger">
   
            </div>
        </div>
    </div>
</div>


<!-- Customer Receive Modals -->
<div class="modal fade" id="modal-default4" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"> Are You Sure To Delete Customer Due ?</h4>
            </div>
            <div class="modal-body">

                <div class="dash">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Invoice No</span>
                        </div>
                        <input type="text" class="form-control" id="CustomerDueReceiveInvoice"  name="CustomerDueReceiveInvoice" value="" 
                                                <?php print $AutoComplete; ?>
                                                list="CustomerDueReceiveInvoiceList"
                                                OnKeyUp="CustomerDueReceiveInvoiceList();">
                                                <datalist id="CustomerDueReceiveInvoiceList"> </datalist>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                <input type="button" id="CustomerDueReceiveInvoiceView" onclick="CustomerDueReceiveView();" value="Invoice View" class="btn btn-dark">
                <input type="button" id="CustomerDueReceiveInvoiceDelete" onclick="CustomerDueReceiveInvoiceDelete();" value="Delete" class="btn btn-danger">
   
            </div>
        </div>
    </div>
</div>




<!-- Customer Receive Modals -->
<div class="modal fade" id="modal-default5" role="dialog">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"> Are You Sure To Delete Supplier Payment ?</h4>
            </div>
            <div class="modal-body">

                <div class="dash">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Invoice No</span>
                        </div>
                        <input type="text" class="form-control" id="SupplierPaymentInvoice"  name="SupplierPaymentInvoice" value="" 
                                                <?php print $AutoComplete; ?>
                                                list="SupplierPaymentInvoiceList"
                                                OnKeyUp="SupplierPaymentInvoiceList();">
                                                <datalist id="SupplierPaymentInvoiceList"> </datalist>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                <input type="button" id="SupplierPaymentInvoiceView" onclick="SupplierPaymentInvoiceView();" value="Invoice View" class="btn btn-dark">
                <input type="button" id="SupplierPaymentInvoiceDelete" onclick="SupplierPaymentInvoiceDelete();" value="Delete" class="btn btn-danger">
   
            </div>
        </div>
    </div>
</div>

<script>

function CashMemoInvoiceDelete() {
    //get the VALUE

    var CashMemoInvoice = $('#CashMemoInvoice').val();

    if (CashMemoInvoice == '') {
        toastr.error('Please Enter Invoice No !!!');
        playclip_warning();
        $('#CashMemoInvoice').focus();
        return false;
    }

    // BEFORE RESPONSE
    $('#CashMemoInvoiceDelete').val('Please Wait...');
    $('#CashMemoInvoiceDelete').attr('disabled', true);

    // use ajax to run the check
    $.post("InvoiceDelete.php", {
            action: 'CashMemoInvoiceDelete',
            CashMemoInvoice: CashMemoInvoice
        }, function (result) {
            //and after the ajax request ends we check the text returned
            if (result == '300') {
                toastr.success('Cash Memo Delete Successful !!!');
                $('#CashMemoInvoiceDelete').val('Delete');
                $('#CashMemoInvoiceDelete').attr('disabled', false);
            }else if (result == '102') {
                toastr.error('Cash Memo Invoice Not Found !!!');
                $('#CashMemoInvoiceDelete').val('Delete');
                $('#CashMemoInvoiceDelete').attr('disabled', false);
            } else {
                toastr.error(result);
                $('#CashMemoInvoiceDelete').val('Delete');
                $('#CashMemoInvoiceDelete').attr('disabled', false);
            }

        }

    );

}

//Cash Memo Return Invoice Delete
  function CashMemoReturnInvoiceDelete(){
 //get the VALUE

 var CashMemoReturnInvoice = $('#CashMemoReturnInvoice').val();

if (CashMemoReturnInvoice == '') {
    toastr.error('Please Enter Invoice No !!!');
    playclip_warning();
    $('#CashMemoReturnInvoice').focus();
    return false;
}

// BEFORE RESPONSE
$('#CashMemoReturnInvoiceDelete').val('Please Wait...');
$('#CashMemoReturnInvoiceDelete').attr('disabled', true);

// use ajax to run the check
$.post("InvoiceDelete.php", {
        action: 'CashMemoReturnInvoiceDelete',
        CashMemoReturnInvoice: CashMemoReturnInvoice
    }, function (result) {
        //and after the ajax request ends we check the text returned
        if (result == '300') {
            toastr.success('Cash Memo Return Delete Successful !!!');
            $('#CashMemoReturnInvoiceDelete').val('Delete');
            $('#CashMemoReturnInvoiceDelete').attr('disabled', false);
        }else if (result == '102') {
            toastr.error('Cash Memo Return Invoice Not Found !!!');
            $('#CashMemoReturnInvoiceDelete').val('Delete');
            $('#CashMemoInvoiceDelete').attr('disabled', false);
        } else {
            toastr.error(result);
            $('#CashMemoReturnInvoiceDelete').val('Delete');
            $('#CashMemoReturnInvoiceDelete').attr('disabled', false);
        }

    }

);
  }

 

//Customer Receive Invoice Delete
function CustomerReceiveInvoiceDelete(){
 //get the VALUE

 var CustomerReceiveInvoice = $('#CustomerReceiveInvoice').val();

if (CustomerReceiveInvoice == '') {
    toastr.error('Please Enter Invoice No !!!');
    playclip_warning();
    $('#CustomerReceiveInvoice').focus();
    return false;
}

// BEFORE RESPONSE
$('#CustomerReceiveInvoiceDelete').val('Please Wait...');
$('#CustomerReceiveInvoiceDelete').attr('disabled', true);

// use ajax to run the check
$.post("InvoiceDelete.php", {
        action: 'CustomerReceiveInvoiceDelete',
        CustomerReceiveInvoice: CustomerReceiveInvoice
    }, function (result) {
        //and after the ajax request ends we check the text returned
        if (result == '300') {
            toastr.success('Customer Receive Delete Successful !!!');
            $('#CustomerReceiveInvoiceDelete').val('Delete');
            $('#CustomerReceiveInvoiceDelete').attr('disabled', false);
        }else if (result == '102') {
            toastr.error('Customer Receive Invoice Not Found !!!');
            $('#CustomerReceiveInvoiceDelete').val('Delete');
            $('#CashMemoInvoiceDelete').attr('disabled', false);
        } else {
            toastr.error(result);
            $('#CustomerReceiveInvoiceDelete').val('Delete');
            $('#CustomerReceiveInvoiceDelete').attr('disabled', false);
        }

    }

);
  } 

  
//Customer Due Receive Invoice Delete
function CustomerDueReceiveInvoiceDelete(){
 //get the VALUE

 var CustomerDueReceiveInvoice = $('#CustomerDueReceiveInvoice').val();

if (CustomerDueReceiveInvoice == '') {
    toastr.error('Please Enter Invoice No !!!');
    playclip_warning();
    $('#CustomerDueReceiveInvoice').focus();
    return false;
}

// BEFORE RESPONSE
$('#CustomerDueReceiveInvoiceDelete').val('Please Wait...');
$('#CustomerDueReceiveInvoiceDelete').attr('disabled', true);

// use ajax to run the check
$.post("InvoiceDelete.php", {
        action: 'CustomerDueReceiveInvoiceDelete',
        CustomerDueReceiveInvoice: CustomerDueReceiveInvoice
    }, function (result) {
        //and after the ajax request ends we check the text returned
        if (result == '300') {
            toastr.success('Customer Receive Delete Successful !!!');
            $('#CustomerDueReceiveInvoiceDelete').val('Delete');
            $('#CustomerDueReceiveInvoiceDelete').attr('disabled', false);
        }else if (result == '102') {
            toastr.error('Customer Receive Invoice Not Found !!!');
            $('#CustomerDueReceiveInvoiceDelete').val('Delete');
            $('#CashMemoInvoiceDelete').attr('disabled', false);
        } else {
            toastr.error(result);
            $('#CustomerDueReceiveInvoiceDelete').val('Delete');
            $('#CustomerDueReceiveInvoiceDelete').attr('disabled', false);
        }

    }

);
  } 

  
//Supplier Payment Invoice Delete
function SupplierPaymentInvoiceDelete(){
 //get the VALUE

 var SupplierPaymentInvoice = $('#SupplierPaymentInvoice').val();

if (SupplierPaymentInvoice == '') {
    toastr.error('Please Enter Invoice No !!!');
    playclip_warning();
    $('#SupplierPaymentInvoice').focus();
    return false;
}

// BEFORE RESPONSE
$('#SupplierPaymentInvoiceDelete').val('Please Wait...');
$('#SupplierPaymentInvoiceDelete').attr('disabled', true);

// use ajax to run the check
$.post("InvoiceDelete.php", {
        action: 'SupplierPaymentInvoiceDelete',
        SupplierPaymentInvoice: SupplierPaymentInvoice
    }, function (result) {
        //and after the ajax request ends we check the text returned
        if (result == '300') {
            toastr.success('Supplier Payment Delete Successful !!!');
            $('#SupplierPaymentInvoiceDelete').val('Delete');
            $('#SupplierPaymentInvoiceDelete').attr('disabled', false);
        }else if (result == '102') {
            toastr.error('Supplier Payment Invoice Not Found !!!');
            $('#SupplierPaymentInvoiceDelete').val('Delete');
            $('#CashMemoInvoiceDelete').attr('disabled', false);
        } else {
            toastr.error(result);
            $('#SupplierPaymentInvoiceDelete').val('Delete');
            $('#SupplierPaymentInvoiceDelete').attr('disabled', false);
        }

    }

);
  } 

   //Cash Memo Invoice View
   function CashMemoInvoiceView() {
  // alert('hhi');
  var CashMemoInvoice = (document.getElementById('CashMemoInvoice').value);

  if (CashMemoInvoice == '') {
      toastr.error('Please Enter Invoice No!!!');
      playclip_warning();
      $('#CashMemoInvoice').focus();
      return false;
    }
  window.open('CashMemoview.php?CashMemoInvoice='+CashMemoInvoice,'Srarch View','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=800,height=800');
}


//Cash Memo Return Invoice View
function CashMemoInvoiceReturnView() {
  // alert('hhi');
  var CashMemoReturnInvoice = (document.getElementById('CashMemoReturnInvoice').value);

  if (CashMemoInvoice == '') {
      toastr.error('Please Enter Invoice No!!!');
      playclip_warning();
      $('#CashMemoInvoice').focus();
      return false;
    }
  window.open('CashMemoReturnview.php?CashMemoReturnInvoice='+CashMemoReturnInvoice,'Srarch View','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=800,height=800');
}



//Customer Receive Invoice View
function CustomerReceiveView() {
  // alert('hhi');
  var CustomerReceiveInvoice = (document.getElementById('CustomerReceiveInvoice').value);

  if (CustomerReceiveInvoice == '') {
      toastr.error('Please Enter Invoice No!!!');
      playclip_warning();
      $('#CustomerReceiveInvoice').focus();
      return false;
    }
  window.open('CustomerReceiveView.php?CustomerReceiveInvoice='+CustomerReceiveInvoice,'Srarch View','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=800,height=800');
}



//Customer Due Receive Invoice View
function CustomerDueReceiveView() {
  // alert('hhi');
  var CustomerDueReceiveInvoice = (document.getElementById('CustomerDueReceiveInvoice').value);

  if (CustomerDueReceiveInvoice == '') {
      toastr.error('Please Enter Invoice No!!!');
      playclip_warning();
      $('#CustomerDueReceiveInvoice').focus();
      return false;
    }
  window.open('CustomerDueReceiveView.php?CustomerDueReceiveInvoice='+CustomerDueReceiveInvoice,'Srarch View','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=800,height=800');
}



//Customer Due Receive Invoice View
function SupplierPaymentInvoiceView() {
  // alert('hhi');
  var SupplierPaymentInvoice = (document.getElementById('SupplierPaymentInvoice').value);

  if (SupplierPaymentInvoice == '') {
      toastr.error('Please Enter Invoice No!!!');
      playclip_warning();
      $('#SupplierPaymentInvoice').focus();
      return false;
    }
  window.open('SupplierPaymentView.php?SupplierPaymentInvoice='+SupplierPaymentInvoice,'Srarch View','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=800,height=800');
}
</script>
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

</html>