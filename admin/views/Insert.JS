//Package Add
function AddPackage() {
    //get the VALUE
    var PackageName = $('#PackageName').val();
    var PacakageDuration = $('#PacakageDuration').val();
    var PacakageAmount = $('#PacakageAmount').val();
    var NumberOfUser = $('#NumberOfUser').val();

    if (PackageName == '') {
      toastr.error('Please Enter Package Name!!!');
      playclip_warning();
      $('#PackageName').focus();
      return false;
    }

    if (PacakageDuration == '') {
      toastr.error('Please Select Package Duration!!!');
      playclip_warning();
      $('#PacakageDuration').focus();
      return false;
    }

    if (PacakageAmount == '') {
      toastr.error('Please Enter Package Amount!!!');
      playclip_warning();
      $('#PacakageAmount').focus();
      return false;
    }

    if (NumberOfUser == '') {
      toastr.error('Please Enter Number Of Users!!!');
      playclip_warning();
      $('#NumberOfUser').focus();
      return false;
    }


    // BEFORE RESPONSE
    $('#AddPackage').val('Please Wait...');
    document.getElementById('AddPackage').disabled = true;

    //use ajax to run the check
    $.post("../actions/InsertData.php", {
        action: "Package",
        PackageName: PackageName,
        PacakageDuration: PacakageDuration,
        NumberOfUser: NumberOfUser,
        PacakageAmount: PacakageAmount

      },
      function (result) {
        //if the result is 1
        if (result == 101) {
          //alert(result);
          toastr.success("["+PackageName + "] Save Successful !!!");
          //Form Value Update
          $('#AddPackage').val('Save Data');
          document.getElementById('AddPackage').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCart_list").load("PackageList.php",function(){

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


          }); 
        } else if (result == 102) {
          //alert(result);
          toastr.warning("Sorry [" + PackageName + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddPackage').val('Save Data');
          document.getElementById('AddPackage').disabled = false;
        } else {
          alert(result);
        }
      });
  }


  //Owner Add
function AddOwner() {
    //get the VALUE
    var OwnerName = $('#OwnerName').val();
    var Phone = $('#Phone').val();
    var ShopName = $('#ShopName').val();
    var ShopAddress = $('#ShopAddress').val();
    var PackageId = $('#PackageId').val();
    var SubscriptionStartDate = $('#SubscriptionStartDate').val();
    var SubscriptionEndDate = $('#SubscriptionEndDate').val();


    if (OwnerName == '') {
      toastr.error('Please Enter Owner Name !!!');
      playclip_warning();
      $('#OwnerName').focus();
      return false;
    }

    if (Phone == '0') {
      toastr.error('Please Enter Owner Moblie No.!!!');
      playclip_warning();
      $('#Phone').focus();
      return false;
    }

      if (/^01[3-9]\d{8}$/g.test(Phone) == false) { 
      toastr.error('Please Enter 11 Digit Owner Moblie No.!!!');
      playclip_warning();
      $('#Phone').focus();
      return false;
    }

    if (ShopName == '') {
      toastr.error('Please Enter Shop Name !!!');
      playclip_warning();
      $('#ShopName').focus();
      return false;
    }

    if (ShopAddress == '') {
      toastr.error('Please Enter Shop Address !!!');
      playclip_warning();
      $('#ShopAddress').focus();
      return false;
    }


    if (PackageId == '') {
      toastr.error('Please Select Package !!!');
      playclip_warning();
      $('#PackageId').focus();
      return false;
    }


    

    if (SubscriptionStartDate == '') {
      toastr.error('Please Enter Subscription Start Date !!!');
      playclip_warning();
      $('#SubscriptionStartDate').focus();
      return false;
    }


    
    if (SubscriptionEndDate == '') {
      toastr.error('Please Enter Subscription End Date!!!');
      playclip_warning();
      $('#SubscriptionEndDate').focus();
      return false;
    }

    // BEFORE RESPONSE
    $('#AddOwner').val('Please Wait...');
    document.getElementById('AddOwner').disabled = true;

    //use ajax to run the check
    $.post("../actions/InsertData.php", {
        action: "Owner",
        OwnerName: OwnerName,
        Phone: Phone,
        ShopName: ShopName,
        ShopAddress: ShopAddress,
        PackageId: PackageId,
        SubscriptionStartDate: SubscriptionStartDate,
        SubscriptionEndDate: SubscriptionEndDate

      },
      function (result) {
        //if the result is 1
        if (result == 101) {
          //alert(result);
          toastr.success("["+ShopName + "] Save Successful !!!");
          //Form Value Update
          $('#AddOwner').val('Save Data');
          document.getElementById('AddOwner').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCart_list").load("OwnerList.php",function(){

          $('#OwnerView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'OwnerViewDataCall.php',
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
          toastr.warning("Sorry [" + Phone + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddOwner').val('Save Data');
          document.getElementById('AddOwner').disabled = false;
        } else {
          alert(result);
        }
      });
  }

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
      toastr.error('Please Enter Pack Size!!!');
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

    if (Generic == '') {
      toastr.error('Please Enter Generic Name!!!');
      playclip_warning();
      $('#Generic').focus();
      return false;
    }

    // BEFORE RESPONSE
    $('#AddMedicine').val('Please Wait...');
    document.getElementById('AddMedicine').disabled = true;

    //use ajax to run the check
    $.post("../actions/InsertData.php", {
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
