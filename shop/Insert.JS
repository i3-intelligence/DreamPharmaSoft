
  //Medicine Add
  function AddMedicine(){
    //get the VALUE
    var MedicineName = $('#MedicineName').val();
    var PurchasePrice = $('#PurchasePrice').val();
    var PackSize = $('#PackSize').val();
    var SalePrice = $('#SalePrice').val();
    var Company = $('#Company').val();
    var Generic = $('#Generic').val();

    if (MedicineName == '') {
      toastr.error('Please Enter Medicine Name!!!');
      playclip_warning();
      $('#MedicineName').focus();
      return false;
    }

    if (PurchasePrice == '') {
      toastr.error('Please Enter Purchase Price!!!');
      playclip_warning();
      $('#PurchasePrice').focus();
      return false;
    }

    if (PackSize == '') {
      toastr.error('Please Enter Unit Quantity!!!');
      playclip_warning();
      $('#PackSize').focus();
      return false;
    }

    if (SalePrice == '') {
      toastr.error('Please Enter Sales Price!!!');
      playclip_warning();
      $('#SalePrice').focus();
      return false;
    }

    if (Company == '') {
      toastr.error('Please Enter Company Name!!!');
      playclip_warning();
      $('#Company').focus();
      return false;
    }

    // if (Generic == '') {
    //   toastr.error('Please Enter Generic Name!!!');
    //   playclip_warning();
    //   $('#Generic').focus();
    //   return false;
    // }

    // BEFORE RESPONSE
    $('#AddMedicine').val('Please Wait...');
    document.getElementById('AddMedicine').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "Medicine",
        MedicineName: MedicineName,
        PurchasePrice: PurchasePrice,
        PackSize: PackSize,
        SalePrice: SalePrice,
        Company: Company,
        Generic: Generic

      },
      function (result) {
        //if the result is 1
        if (result == 101) {
          //alert(result);
          toastr.success("["+MedicineName + "] Save Successful !!!");
          //Form Value Update
          $('#AddMedicine').val('Save Data');
          document.getElementById('AddMedicine').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCart_list").load("MedicineList.php",function(){

          $('#MedicineView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'MedicineViewDataCall.php',
          'type': 'post',
          },
          "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [5]
          },

          ]
          });

          });
        } else if (result == 102) {
          //alert(result);
          toastr.warning("Sorry [" + MedicineName + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddMedicine').val('Save Data');
          document.getElementById('AddMedicine').disabled = false;
        } else {
          alert(result);
        }
      });
  }
