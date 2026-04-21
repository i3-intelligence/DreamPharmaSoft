
//Customer Due  Delete
  function CustomerDueReceiveDelete() {
    var PrimaryID = $('#PrimaryID').val(); 
        // BEFORE RESPONSE
        $('#Delete').val('Please Wait...');
    document.getElementById('Delete').disabled = true;

    // use ajax to run the check
    $.post("Delete.php", {
        action: "ReceiveDelete",
        PrimaryID: PrimaryID
      },
      function (result) {
        //if the result is 0
        if (result == 300) {
          //alert(result);
          toastr.success("Customer Due Receive Delete Successful !!!");
          //Form Value Update
          $('#Delete').val('Delete');
          document.getElementById('Delete').disabled = false;
         $('#modal-default1').modal('hide');
          $("#load_cart_list").load("CustomerDueReceiveList.php",function(){
                $('#example2').DataTable();
            });

        } else {
          alert(result);
        }
      });
  }

  //Customer Receive  Delete
  function CustomerReceiveDelete() {
    var PrimaryID = $('#PrimaryID').val(); 
        // BEFORE RESPONSE
        $('#Delete').val('Please Wait...');
    document.getElementById('Delete').disabled = true;

    // use ajax to run the check
    $.post("Delete.php", {
        action: "ReceiveDelete",
        PrimaryID: PrimaryID
      },
      function (result) {
        //if the result is 0
        if (result == 300) {
          //alert(result);
          toastr.success("Customer Receive Delete Successful !!!");
          //Form Value Update
          $('#Delete').val('Delete');
          document.getElementById('Delete').disabled = false;
         $('#modal-default1').modal('hide');
          $("#load_cart_list").load("CustomerReceiveList.php",function(){
                $('#example2').DataTable();
            });

        } else {
          alert(result);
        }
      });
  }

  
  //Supplier Payment Delete
  function SupplierPaymentDelete() {
    var PrimaryID = $('#PrimaryID').val(); 
        // BEFORE RESPONSE
        $('#Delete').val('Please Wait...');
    document.getElementById('Delete').disabled = true;

    // use ajax to run the check
    $.post("Delete.php", {
        action: "PaymentDelete",
        PrimaryID: PrimaryID
      },
      function (result) {
        //if the result is 0
        if (result == 300) {
          //alert(result);
          toastr.success("Supplier Payment Delete Successful !!!");
          //Form Value Update
          $('#Delete').val('Delete');
          document.getElementById('Delete').disabled = false;
         $('#modal-default1').modal('hide');
          $("#load_cart_list").load("SupplierPaymentList.php",function(){
                $('#example2').DataTable();
            });

        } else {
          alert(result);
        }
      });
  }