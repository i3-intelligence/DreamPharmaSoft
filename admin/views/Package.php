<?php
require_once '../includes/auth.php'; // Session Starting file
include '../config/database.php'; // Database connection file
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>



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
              <h1 class="m-0"><?php print $PageLevel = "Package View"; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#modal-default1"
          data-whatever="Package">ADD NEW</button></li>
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item"><a href="added.php">Added Menu</a></li>
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
            
                <?php include("PackageList.php"); ?>
               
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
    
            <h4 class="modal-title"> Package Add </h4>
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
    include("footer.php");
    ?>
  </div>
  <!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include '../views/RequiredFotterContex.php';?>
</body>
<script>
  $('#PackageView').DataTable({
    "fnCreatedRow": function(nRow, aData, iDataIndex) {
      $(nRow).attr('id', aData[0]);
    },
    'serverSide': 'true',
    'processing': 'true',
    'paging': 'true',
    'order': [],
    'ajax': {
      'url': '../actions/PackageViewDataCall.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
        "bSortable": false,
        "aTargets": [5]
      },

    ]
  });

  //Package Add
      $('#modal-default1').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var ID = button.data('whatever') // Extract info from data-* attributes
        var modal = $(this);
        var dataString = 'id=' + ID;
        modal.find('.dash').html('');

        if(ID =='Package'){

          modal.find('.modal-title').text('Package Add');
       
        $.ajax({
          type: "GET",
          url: "../views/ModalPackageInsert.php",
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

      }else if (ID !='Package'){

          modal.find('.modal-title').text('Package Update');
          $.ajax({
          type: "GET",
          url: "../views/ModalPackageUpdate.php",
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
