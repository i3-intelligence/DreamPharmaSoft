<?php
require_once '../includes/Auth.php'; // Session Starting file
include '../config/Database.php'; // Database connection file
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'Header.php'; ?>



<body class="hold-transition layout-top-nav">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include("navbar.php"); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"><?php print $PageLevel = "Shop View"; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#modal-default1"
          data-whatever="Shop">ADD NEW</button></li>
                <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Added.php">Added Menu</a></li>
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
          <!-- Info boxes -->
          <div class="card card-default">


            <div class="card">
    
              <!-- /.card-header -->
              <div class="card-body" id="LoadCart_list">
            
                <?php include("ShopList.php"); ?>
               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="modal fade" id="modal-default1" role="dialog">
      <div class="modal-dialog modal-xl">

        <div class="modal-content">
          <div class="modal-header">
    
            <h4 class="modal-title"> Shop Add </h4>
          </div>
          <div class="modal-body">

            <div class="dash">
              <!-- Content goes in here -->
            </div>

          </div>

        </div>
      </div>
    </div>
<!-- Custom JS -->

<script src="../views/Insert.JS"></script>
<script src="../views/Update.JS"></script>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php 
    include("Footer.php");
    ?>
  </div>
  </div>
  <!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../views/RequiredFotterContex.php'; ?>
</body>
<script>
  $('#ShopView').DataTable({
    "fnCreatedRow": function(nRow, aData, iDataIndex) {
      $(nRow).attr('id', aData[0]);
    },
    'serverSide': 'true',
    'processing': 'true',
    'paging': 'true',
    'order': [],
    'ajax': {
      'url': '../actions/ShopViewDataCall.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [5]
      },

    ]
  });

  //Shop Add
      $('#modal-default1').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var ID = button.data('whatever') // Extract info from data-* attributes
        var modal = $(this);
        var dataString = 'id=' + ID;
        modal.find('.dash').html('');

        if(ID =='Shop'){

          modal.find('.modal-title').text('Shop Add');
       
        $.ajax({
          type: "GET",
          url: "../views/ModalShopInsert.php",
          data: dataString,
          cache: false,
          success: function (data) {
            console.log(data);
            modal.find('.dash').html(data);
          },
          error: function (err) {
            console.log(err);
          }
        });

      }else if (ID !='Shop'){

          modal.find('.modal-title').text('Shop Update');
          $.ajax({
          type: "GET",
          url: "../views/ModalShopUpdate.php",
          data: dataString,
          cache: false,
          success: function (data) {
            console.log(data);
            modal.find('.dash').html(data);
          },
          error: function (err) {
            console.log(err);
          }
        });
        }else{
          alert(400);
        }

      });

    </script>

</html>
