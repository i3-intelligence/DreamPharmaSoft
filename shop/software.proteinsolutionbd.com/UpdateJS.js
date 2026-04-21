//Supplier Category Update
  function UpdateSupplierCategory(){
    //get the VALUE
    var UpdateId = $('#UpdateId').val();
    var Name = $('#Name').val();
    var Status = $('#Status').val();
  
    if (Name == '') {
      toastr.error('Please Enter Customer Category Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }
    // BEFORE RESPONSE
    $('#UpdateSupplierCategory').val('Please Wait...');
    document.getElementById('UpdateSupplierCategory').disabled = true;
  
    //use ajax to run the check
    $.post("UpdateData.php", {
      action: "SupplierCategory",
      UpdateId: UpdateId,
      Name: Name,
      Status: Status
    },
    function (result) {
    //if the result is 200
    if (result == 200) {
            //alert(result);
            toastr.success("["+Name + "] Update Successful !!!");
            //Form Value Update
            $('#UpdateSupplierCategory').val('Update Data');
            document.getElementById('UpdateSupplierCategory').disabled = false;
            $('#modal-default1').modal('hide');
  
            $("#LoadCartList").load("SupplierCategoryList.php",function(){
  
            $('#SupplierCategoryView').DataTable({
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
            },
            'serverSide': 'true', 
            'processing': 'true',
            'paging': 'true',
            'order': [],
            'ajax': {
            'url': 'SupplierCategoryViewDataCall.php',
            'type': 'post',
            },
            "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [3]
            },
  
            ]
            });
  
            });
  
          } else if (result == 102) {
  
            toastr.warning("Sorry [" + Name + "] Already Added !!!");
            playclip_warning();
            //Form Value Update
            $('#UpdateSupplierCategory').val('Update Data');
            document.getElementById('UpdateSupplierCategory').disabled = false;
          } else {
            alert(result);
          }
        });
  
  }

// Supplier Update
function UpdateSupplier(){
    //get the VALUE
    var UpdateId = $('#UpdateId').val();
    var Name = $('#Name').val();
    var ColorCode = $('#ColorCode').val();
    var SupplierCategoryID = $('#SupplierCategoryID').val();
    var MobileNo = $('#MobileNo').val();
    var Address = $('#Address').val();
    var ContactPersonInfo = $('#ContactPersonInfo').val();
    var OpeningBalance = $('#OpeningBalance').val();
    var Status = $('#Status').val();
  
    if (Name == '') {
      toastr.error('Please Enter Supplier Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }
    if (ColorCode == '') {
      toastr.error('Please Select Color Code!!!');
      playclip_warning();
      $('#ColorCode').focus();
      return false;
    }

    
    if (SupplierCategoryID == '') {
      toastr.error('Please Select Supplier Category!!!');
      playclip_warning();
      $('#SupplierCategoryID').focus();
      return false;
    }

    if (MobileNo == '') {
      toastr.error('Please Enter Mobile No!!!');
      playclip_warning();
      $('#MobileNo').focus();
      return false;
    }
  
  
    // BEFORE RESPONSE
    $('#UpdateSupplier').val('Please Wait...');
    document.getElementById('UpdateSupplier').disabled = true;
  
    //use ajax to run the check
    $.post("UpdateData.php", {
      action: "Supplier",
      UpdateId: UpdateId,
      Name: Name,
      ColorCode: ColorCode,
      SupplierCategoryID: SupplierCategoryID,
      MobileNo: MobileNo,
      Address: Address,
      ContactPersonInfo: ContactPersonInfo,
      OpeningBalance: OpeningBalance,
      Status: Status
    },
    function (result) {
    //if the result is 200
    if (result == 200) {
            //alert(result);
            toastr.success("["+Name + "] Update Successful !!!");
            //Form Value Update
            $('#UpdateSupplier').val('Update Data');
            document.getElementById('UpdateSupplier').disabled = false;
            $('#modal-default1').modal('hide');
  
            $("#LoadCartList").load("SupplierList.php",function(){
  
            $('#SupplierView').DataTable({
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
            },
            'serverSide': 'true', 
            'processing': 'true',
            'paging': 'true',
            'order': [],
            'ajax': {
            'url': 'SupplierViewDataCall.php',
            'type': 'post',
            },
            "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [9]
            },
  
            ]
            });
  
            });
  
          } else if (result == 102) {
  
            toastr.warning("Sorry [" + Name + "] Already Added !!!");
            playclip_warning();
            //Form Value Update
            $('#UpdateSupplier').val('Update Data');
            document.getElementById('UpdateSupplier').disabled = false;
          } else {
            alert(result);
          }
        });
  
  }

  //Customer Category Update
function UpdateCustomerCategory(){
  //get the VALUE
  var UpdateId = $('#UpdateId').val();
  var Name = $('#Name').val();
  var Status = $('#Status').val();

  if (Name == '') {
    toastr.error('Please Enter Customer Category Name!!!');
    playclip_warning();
    $('#Name').focus();
    return false;
  }
  // BEFORE RESPONSE
  $('#UpdateCustomerCategory').val('Please Wait...');
  document.getElementById('UpdateCustomerCategory').disabled = true;

  //use ajax to run the check
  $.post("UpdateData.php", {
    action: "CustomerCategory",
    UpdateId: UpdateId,
    Name: Name,
    Status: Status
  },
  function (result) {
  //if the result is 200
  if (result == 200) {
          //alert(result);
          toastr.success("["+Name + "] Update Successful !!!");
          //Form Value Update
          $('#UpdateCustomerCategory').val('Update Data');
          document.getElementById('UpdateCustomerCategory').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("CustomerCategoryList.php",function(){

          $('#CustomerCategoryView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true', 
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'CustomerCategoryViewDataCall.php',
          'type': 'post',
          },
          "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [3]
          },

          ]
          });

          });

        } else if (result == 102) {

          toastr.warning("Sorry [" + Name + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#UpdateCustomerCategory').val('Update Data');
          document.getElementById('UpdateCustomerCategory').disabled = false;
        } else {
          alert(result);
        }
      });

}


  //Customer Sub Category Update
  function UpdateCustomerSubCategory(){
    //get the VALUE
    var UpdateId = $('#UpdateId').val();
    var Name = $('#Name').val();
    var Status = $('#Status').val();
  
    if (Name == '') {
      toastr.error('Please Enter Customer Category Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }
    // BEFORE RESPONSE
    $('#UpdateCustomerSubCategory').val('Please Wait...');
    document.getElementById('UpdateCustomerSubCategory').disabled = true;
  
    //use ajax to run the check
    $.post("UpdateData.php", {
      action: "CustomerSubCategory",
      UpdateId: UpdateId,
      Name: Name,
      Status: Status
    },
    function (result) {
    //if the result is 200
    if (result == 200) {
            //alert(result);
            toastr.success("["+Name + "] Update Successful !!!");
            //Form Value Update
            $('#UpdateCustomerSubCategory').val('Update Data');
            document.getElementById('UpdateCustomerSubCategory').disabled = false;
            $('#modal-default1').modal('hide');
  
            $("#LoadCartList").load("CustomerSubCategoryList.php",function(){
  
            $('#CustomerSubCategoryView').DataTable({
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
            },
            'serverSide': 'true', 
            'processing': 'true',
            'paging': 'true',
            'order': [],
            'ajax': {
            'url': 'CustomerSubCategoryViewDataCall.php',
            'type': 'post',
            },
            "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [3]
            },
  
            ]
            });
  
            });
  
          } else if (result == 102) {
  
            toastr.warning("Sorry [" + Name + "] Already Added !!!");
            playclip_warning();
            //Form Value Update
            $('#UpdateCustomerSubCategory').val('Update Data');
            document.getElementById('UpdateCustomerSubCategory').disabled = false;
          } else {
            alert(result);
          }
        });
  
  }
  
  
//Item Category Update
  function UpdateItemCategory(){
    //get the VALUE
    var UpdateId = $('#UpdateId').val();
    var Name = $('#Name').val();
    var SupplierID = $('#SupplierID').val();
    var Status = $('#Status').val();
  
    if (Name == '') {
      toastr.error('Please Enter Item Category Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }
  
    if (SupplierID == '') {
      toastr.error('Please Select Supplier Info!!!');
      playclip_warning();
      $('#SupplierID').focus();
      return false;
    }
  
  
    // BEFORE RESPONSE
    $('#UpdateItemCategory').val('Please Wait...');
    document.getElementById('UpdateItemCategory').disabled = true;
  
    //use ajax to run the check
    $.post("UpdateData.php", {
      action: "ItemCategory",
      UpdateId: UpdateId,
      Name: Name,
      SupplierID: SupplierID,
      Status: Status
    },
    function (result) {
    //if the result is 200
    if (result == 200) {
            //alert(result);
            toastr.success("["+Name + "] Update Successful !!!");
            //Form Value Update
            $('#UpdateItemCategory').val('Update Data');
            document.getElementById('UpdateItemCategory').disabled = false;
            $('#modal-default1').modal('hide');
  
            $("#LoadCartList").load("ItemCategoryList.php",function(){
  
            $('#ItemCategoryView').DataTable({
            "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
            },
            'serverSide': 'true', 
            'processing': 'true',
            'paging': 'true',
            'order': [],
            'ajax': {
            'url': 'ItemCategoryViewDataCall.php',
            'type': 'post',
            },
            "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [4]
            },
  
            ]
            });
  
            });
  
          } else if (result == 102) {
  
            toastr.warning("Sorry [" + Name + "] Already Added !!!");
            playclip_warning();
            //Form Value Update
            $('#UpdateItemCategory').val('Update Data');
            document.getElementById('UpdateItemCategory').disabled = false;
          } else {
            alert(result);
          }
        });
  
  }

  
//Item Category Update
function UpdatePackageSize(){
  //get the VALUE
  var UpdateId = $('#UpdateId').val();
  var Thickness = $('#Thickness').val();
  var Size = $('#Size').val();
  var SupplierID = $('#SupplierID').val();
  var ItemCategoryID = $('#ItemCategoryID').val();
  var LowStock = $('#LowStock').val();
  var Status = $('#Status').val();

  if (Thickness == '') {
    toastr.error('Please Enter Package Size!!!');
    playclip_warning();
    $('#Thickness').focus();
    return false;
  }
  if (Size == '') {
    toastr.error('Please Select Mode Of Packet!!!');
    playclip_warning();
    $('#Size').focus();
    return false;
  }

  if (SupplierID == '') {
    toastr.error('Please Select Supplier Info!!!');
    playclip_warning();
    $('#SupplierID').focus();
    return false;
  }

  if (ItemCategoryID == '') {
    toastr.error('Please Select Item Category!!!');
    playclip_warning();
    $('#ItemCategoryID').focus();
    return false;
  }

  // BEFORE RESPONSE
  $('#UpdatePackageSize').val('Please Wait...');
  document.getElementById('UpdatePackageSize').disabled = true;

  //use ajax to run the check
  $.post("UpdateData.php", {
    action: "PackageSize",
    UpdateId: UpdateId,
    Thickness: Thickness,
    Size: Size,
    SupplierID: SupplierID,
    ItemCategoryID: ItemCategoryID,
    LowStock: LowStock,
    Status: Status
  },
  function (result) {
  //if the result is 200
  if (result == 200) {
          //alert(result);
          toastr.success("["+Thickness + Size + "] Update Successful !!!");
          //Form Value Update
          $('#UpdatePackageSize').val('Update Data');
          document.getElementById('UpdatePackageSize').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("PackageSizeList.php",function(){

          $('#PackageSizeView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true', 
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'PackageSizeViewDataCall.php',
          'type': 'post',
          },
          "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [7]
          },

          ]
          });

          });

        } else if (result == 102) {
          toastr.warning("["+Thickness + Size + "] Already Added !!!");
         
          playclip_warning();
          //Form Value Update
          $('#UpdatePackageSize').val('Update Data');
          document.getElementById('UpdatePackageSize').disabled = false;
        } else {
          alert(result);
        }
      });

}


// Customer Update
function UpdateCustomer(){
  //get the VALUE
  var UpdateId = $('#UpdateId').val();
  var Name = $('#Name').val();
  var CustomerCategoryID = $('#CustomerCategoryID').val();
  var CustomerSubCategoryID = $('#CustomerSubCategoryID').val();
  var MobileNo = $('#MobileNo').val();
  var Address = $('#Address').val();
  var CreditLimit = $('#CreditLimit').val();
  var OpeningBalance = $('#OpeningBalance').val();
  var Status = $('#Status').val();

  if (Name == '') {
    toastr.error('Please Enter Customer Name!!!');
    playclip_warning();
    $('#Name').focus();
    return false;
  }
  if (CustomerCategoryID == '') {
    toastr.error('Please Select Customer Category!!!');
    playclip_warning();
    $('#CustomerCategoryID').focus();
    return false;
  }

  if (CustomerSubCategoryID == '') {
    toastr.error('Please Select Customer Sub Category!!!');
    playclip_warning();
    $('#CustomerSubCategoryID').focus();
    return false;
  }

  if (MobileNo == '') {
    toastr.error('Please Enter Mobile No!!!');
    playclip_warning();
    $('#MobileNo').focus();
    return false;
  }


  // BEFORE RESPONSE
  $('#UpdateCustomer').val('Please Wait...');
  document.getElementById('UpdateCustomer').disabled = true;

  //use ajax to run the check
  $.post("UpdateData.php", {
    action: "Customer",
    UpdateId: UpdateId,
    Name: Name,
    CustomerCategoryID: CustomerCategoryID,
    CustomerSubCategoryID: CustomerSubCategoryID,
    MobileNo: MobileNo,
    Address: Address,
  CreditLimit: CreditLimit,
    OpeningBalance: OpeningBalance,
    Status: Status
  },
  function (result) {
  //if the result is 200
  if (result == 200) {
          //alert(result);
          toastr.success("["+Name + "] Update Successful !!!");
          //Form Value Update
          $('#UpdateCustomer').val('Update Data');
          document.getElementById('UpdateCustomer').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("CustomerList.php",function(){

          $('#CustomerView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true', 
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'CustomerViewDataCall.php',
          'type': 'post',
          },
          "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [9]
          },

          ]
          });

          });

        } else if (result == 102) {

          toastr.warning("Sorry [" + Name + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#UpdateCustomer').val('Update Data');
          document.getElementById('UpdateCustomer').disabled = false;
        } else {
          alert(result);
        }
      });

}

//Wallet Update
function UpdateWallet(){
  //get the VALUE
  var UpdateId = $('#UpdateId').val();
  var Name = $('#Name').val();
  var OpeningBalance  = $('#OpeningBalance ').val();
  var Status = $('#Status').val();

  if (Name == '') {
    toastr.error('Please Enter Wallet Name!!!');
    playclip_warning();
    $('#Name').focus();
    return false;
  }
  // BEFORE RESPONSE
  $('#UpdateWallet').val('Please Wait...');
  document.getElementById('UpdateWallet').disabled = true;

  //use ajax to run the check
  $.post("UpdateData.php", {
    action: "Wallet",
    UpdateId: UpdateId,
    Name: Name,
    OpeningBalance: OpeningBalance,
    Status: Status
  },
  function (result) {
  //if the result is 200
  if (result == 200) {
          //alert(result);
          toastr.success("["+Name + "] Update Successful !!!");
          //Form Value Update
          $('#UpdateWallet').val('Update Data');
          document.getElementById('UpdateWallet').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("WalletList.php",function(){

          $('#WalletView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true', 
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'WalletViewDataCall.php',
          'type': 'post',
          },
          "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [4]
          },

          ]
          });

          });

        } else if (result == 102) {

          toastr.warning("Sorry [" + Name + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#UpdateWallet').val('Update Data');
          document.getElementById('UpdateWallet').disabled = false;
        } else {
          alert(result);
        }
      });

}


//Bank  Update
function UpdateBank(){
  //get the VALUE
  var UpdateId = $('#UpdateId').val();
  var BranchName = $('#BranchName').val();
  var BankName = $('#BankName').val();
  var AccountName = $('#AccountName').val();
  var AccountNumber = $('#AccountNumber').val();
  var OpeningBalance  = $('#OpeningBalance ').val();
  var Status = $('#Status').val();
  if (BranchName == '') {
    toastr.error('Please Enter Branch Name!!!');
    playclip_warning();
    $('#BranchName').focus();
    return false;
  }

  if (BankName == '') {
    toastr.error('Please Enter Bank Name!!!');
    playclip_warning();
    $('#BankName').focus();
    return false;
  }

  if (AccountName == '') {
    toastr.error('Please Enter Account Name!!!');
    playclip_warning();
    $('#AccountName').focus();
    return false;
  }

  if (AccountNumber == '') {
    toastr.error('Please Enter Account Number!!!');
    playclip_warning();
    $('#AccountNumber').focus();
    return false;
  }

  // BEFORE RESPONSE
  $('#UpdateBank').val('Please Wait...');
  document.getElementById('UpdateBank').disabled = true;

  //use ajax to run the check
  $.post("UpdateData.php", {
    action: "Bank",
    UpdateId: UpdateId,
    BranchName: BranchName,
    BankName: BankName,
    AccountName: AccountName,
    AccountNumber: AccountNumber,
    OpeningBalance: OpeningBalance,
    Status: Status
  },
  function (result) {
  //if the result is 200
  if (result == 200) {
          //alert(result);
          toastr.success("[" + BranchName + " - " + BankName + " - " + AccountName + " - " + AccountNumber + "] Update Successful !!!");
          //Form Value Update
          $('#UpdateBank').val('Update Data');
          document.getElementById('UpdateBank').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("BankList.php",function(){

          $('#BankView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true', 
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'BankViewDataCall.php',
          'type': 'post',
          },
          "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [7]
          },

          ]
          });

          });

        } else if (result == 102) {

          toastr.warning("[" + BranchName + " - " + BankName + " - " + AccountName + " - " + AccountNumber + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#UpdateBank').val('Update Data');
          document.getElementById('UpdateBank').disabled = false;
        } else {
          alert(result);
        }
      });

}



//Others Account  Update
function UpdateOthersAccount(){
  //get the VALUE
  var UpdateId = $('#UpdateId').val();
  var SectorName = $('#SectorName').val();
  var OthersAccountName = $('#OthersAccountName').val();
  var MobileNo = $('#MobileNo').val();
  var CreditLimit = $('#CreditLimit').val();
  var Category = $('#Category').val();
  var OpeningBalance = $('#OpeningBalance').val();
  var Status = $('#Status').val();
  if (SectorName == '') {
    toastr.error('Please Enter Sector Name!!!');
    playclip_warning();
    $('#SectorName').focus();
    return false;
  }

  if (OthersAccountName == '') {
    toastr.error('Please Enter Account Name!!!');
    playclip_warning();
    $('#OthersAccountName').focus();
    return false;
  }

  // BEFORE RESPONSE
  $('#UpdateOthersAccount').val('Please Wait...');
  document.getElementById('UpdateOthersAccount').disabled = true;

  //use ajax to run the check
  $.post("UpdateData.php", {
    action: "OthersAccount",
    UpdateId: UpdateId,
    SectorName: SectorName,
    OthersAccountName: OthersAccountName,
    MobileNo: MobileNo,
    CreditLimit: CreditLimit,
    Category: Category,
    OpeningBalance: OpeningBalance,
    Status: Status
  },
  function (result) {
  //if the result is 200
  if (result == 200) {
          //alert(result);
          toastr.success("[" + SectorName + " - " + OthersAccountName + "] Update Successful !!!");
          //Form Value Update
          $('#UpdateOthersAccount').val('Update Data');
          document.getElementById('UpdateOthersAccount').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("OthersAccountList.php",function(){

          $('#OthersAccountView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true', 
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'OthersAccountViewDataCall.php',
          'type': 'post',
          },
          "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [8]
          },

          ]
          });

          });

        } else if (result == 102) {

          toastr.warning("[" + SectorName + " - " + OthersAccountName + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#UpdateOthersAccount').val('Update Data');
          document.getElementById('UpdateOthersAccount').disabled = false;
        } else {
          alert(result);
        }
      });

}

//User View Update
function UpdateUser(){
  //get the VALUE
  var UpdateId = $('#UpdateId').val();
  var User = $('#User').val();
  var UserName = $('#UserName').val();
  var DecryptPassword = $('#DecryptPassword').val();
  var Admin = $('#Admin').val();
  var EditAccess = $('#EditAccess').val();
  var DeleteAccess = $('#DeleteAccess').val();
  var Block = $('#Block').val();

  if (UserName == '') {
    toastr.error('Please Enter User Name!!!');
    playclip_warning();
    $('#UserName').focus();
    return false;
  }

  if (User == '') {
    toastr.error('Please Enter User ID!!!');
    playclip_warning();
    $('#User').focus();
    return false;
  }

  
  if (DecryptPassword == '') {
    toastr.error('Please Enter Password!!!');
    playclip_warning();
    $('#DecryptPassword').focus();
    return false;
  }
  

  // BEFORE RESPONSE
  $('#UpdateUser').val('Please Wait...');
  document.getElementById('UpdateUser').disabled = true;

  //use ajax to run the check
  $.post("UpdateData.php", {
    action: "User",
    UpdateId: UpdateId,
    User: User,
    UserName: UserName,
    DecryptPassword: DecryptPassword,
    Admin: Admin,
    EditAccess: EditAccess,
    DeleteAccess: DeleteAccess,
    Block: Block
  },
  function (result) {
  //if the result is 200
  if (result == 200) {
          //alert(result);
          toastr.success("["+User + "] Update Successful !!!");
          //Form Value Update
          $('#UpdateUser').val('Update Data');
          document.getElementById('UpdateUser').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("UserList.php",function(){

          $('#UserView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true', 
          'processing': 'true',
          'paging': 'true',
          'order': [],
          'ajax': {
          'url': 'UserViewDataCall.php',
          'type': 'post',
          },
          "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [3]
          },

          ]
          });

          });

        } else if (result == 102) {

          toastr.warning("Sorry [" + User + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#UpdateUser').val('Update Data');
          document.getElementById('UpdateUser').disabled = false;
        } else {
          alert(result);
        }
      });

}
