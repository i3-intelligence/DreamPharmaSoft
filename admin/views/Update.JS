//Package Update
function UpdatePackage() {
    //get the VALUE
    var UpdateId = $('#UpdateId').val();
    var PackageName = $('#PackageName2').val();
    var PacakageDuration = $('#PacakageDuration2').val();
    var NumberOfUser = $('#NumberOfUser2').val();
    var PacakageAmount = $('#PacakageAmount2').val();
    var Status = $('#Status').val();
    if (PackageName == '') {
      toastr.error('Please Enter Package Name!!!');
      playclip_warning();
      $('#PackageName2').focus();
      return false;
    }

    if (PacakageDuration == '') {
      toastr.error('Please Select Package Duration!!!');
      playclip_warning();
      $('#PacakageDuration2').focus();
      return false;
    }
    if (NumberOfUser == '') {
      toastr.error('Please Select Package Duration!!!');
      playclip_warning();
      $('#NumberOfUser2').focus();
      return false;
    }

    if (PacakageAmount == '') {
      toastr.error('Please Enter Package Amount!!!');
      playclip_warning();
      $('#PacakageAmount2').focus();
      return false;
    }

    // BEFORE RESPONSE
    $('#UpdatePackage').val('Please Wait...');
    document.getElementById('UpdatePackage').disabled = true;

    //use ajax to run the check
    $.post("../actions/UpdateData.php", {
        action: "Package",
        UpdateId: UpdateId,
        PackageName: PackageName,
        PacakageDuration: PacakageDuration,
        NumberOfUser: NumberOfUser,
        PacakageAmount: PacakageAmount,
        Status: Status

      },
      function (result) {
        //if the result is 1
        if (result == 200) {
          //alert(result);
          toastr.success("["+PackageName + "] Update Successful !!!");
          //Form Value Update
          $('#UpdatePackage').val('Update Data');
          document.getElementById('UpdatePackage').disabled = false;
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
          $('#UpdatePackage').val('Update Data');
          document.getElementById('UpdatePackage').disabled = false;
        } else {
          alert(result);
        }
      });
  }

// Owner Update
function UpdateOwner() {
  //get the VALUE
    var UpdateId = $('#UpdateId').val();
    var OwnerName = $('#OwnerName').val();
    var Phone = $('#Phone').val();
    var ShopName = $('#ShopName').val();
    var ShopAddress = $('#ShopAddress').val();
    var PackageId = $('#PackageId').val();
    var SubscriptionStartDate = $('#SubscriptionStartDate').val();
    var SubscriptionEndDate = $('#SubscriptionEndDate').val();
    var Status = $('#Status').val();
    

    if (OwnerName == '') {
      toastr.error('Please Enter Owner Name!!!');
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
      toastr.error('Please Enter Shop Name!!!');
      playclip_warning();
      $('#ShopName').focus();
      return false;
    }

    if (ShopAddress == '') {
      toastr.error('Please Enter Shop Address!!!');
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
      toastr.error('Please Enter Subscription Start Date!!!');
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
    $('#UpdateOwner').val('Please Wait...');
    document.getElementById('UpdateOwner').disabled = true;

    //use ajax to run the check
    $.post("../actions/UpdateData.php", {
        action: "Owner",
        UpdateId: UpdateId,
        OwnerName: OwnerName,
        Phone: Phone,
        ShopName: ShopName,
        ShopAddress: ShopAddress,
        PackageId: PackageId,
        SubscriptionStartDate: SubscriptionStartDate,
        SubscriptionEndDate: SubscriptionEndDate,
        Status: Status

      },
      function (result) {
        //if the result is 1
        if (result == 200) {
          //alert(result);
          toastr.success("["+ShopName + "] Update Successful !!!");
          //Form Value Update
          $('#UpdateOwner').val('Update Data');
          document.getElementById('UpdateOwner').disabled = false;
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
          $('#UpdateOwner').val('Update Data');
          document.getElementById('UpdateOwner').disabled = false;
        } else {
          alert(result);
        }
      });
  
}  

// Medicine Update
function UpdateMedicine(){
  //get the VALUE
  var UpdateId = $('#UpdateId').val();
  var MedicineName = $('#MedicineName2').val();
  var PurchasePrice = $('#PurchasePrice2').val();
  var PackSize = $('#PackSize2').val();
  var SalePrice = $('#SalePrice2').val();
  var Company = $('#Company2').val();
  var Generic = $('#Generic2').val();
  var Status = $('#Status').val();

  if (MedicineName == '') {
    toastr.error('Please Enter Medicine Name!!!');
    playclip_warning();
    $('#MedicineName2').focus();
    return false;
  }

  if (PurchasePrice == '') {
    toastr.error('Please Enter Purchase Price!!!');
    playclip_warning();
    $('#PurchasePrice2').focus();
    return false;
  }

  if (PackSize == '') {
    toastr.error('Please Enter Pack Size!!!');
    playclip_warning();
    $('#PackSize2').focus();
    return false;
  }


  if (SalePrice == '') {
    toastr.error('Please Enter Sell Price!!!');
    playclip_warning();
    $('#SalePrice2').focus();
    return false;
  }

  if (Company == '') {
    toastr.error('Please Enter Company Name!!!');
    playclip_warning();
    $('#Company2').focus();
    return false;
  }

  if (Generic == '') {
    toastr.error('Please Enter Generic Name!!!');
    playclip_warning();
    $('#Generic2').focus();
    return false;
  }

  // BEFORE RESPONSE
  $('#UpdateMedicine').val('Please Wait...');
  document.getElementById('UpdateMedicine').disabled = true;

  //use ajax to run the check
  $.post("../actions/UpdateData.php", {
    action: "Medicine",
    UpdateId: UpdateId,
    MedicineName: MedicineName,
    PurchasePrice: PurchasePrice,
    PackSize: PackSize,
    SalePrice: SalePrice,
    Company: Company,
    Generic: Generic,
    Status: Status
  },
  function (result) {
  //if the result is 1
  if (result == 200) {
          //alert(result);
          toastr.success("["+MedicineName + "] Update Successful !!!");
          //Form Value Update
          $('#UpdateMedicine').val('Update Data');
          document.getElementById('UpdateMedicine').disabled = false;
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

          toastr.warning("Sorry [" + MedicineName + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#UpdateMedicine').val('Update Data');
          document.getElementById('UpdateMedicine').disabled = false;
        } else {
          alert(result);
        }
      });
      




}
