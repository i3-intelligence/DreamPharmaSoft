 //Supplier Category Add
  function AddSupplierCategory(){
    //get the VALUE
    var Name = $('#Name').val();
    if (Name == '') {
      toastr.error('Please Enter Customer Category Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }


    // BEFORE RESPONSE
    $('#AddSupplierCategory').val('Please Wait...');
    document.getElementById('AddSupplierCategory').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "SupplierCategory",
        Name: Name

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("["+Name + "] Save Successful !!!");
          //Form Value Update
          $('#AddSupplierCategory').val('Save Data');
          document.getElementById('AddSupplierCategory').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("SupplierCategoryList.php",function(){

          $('#SupplierCategoryView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("Sorry [ " + Name + " ] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddSupplierCategory').val('Save Data');
          document.getElementById('AddSupplierCategory').disabled = false;
        } else {
          alert(result);
        }
      });
  }


   //Supplier/Customer Add
   function AddSupplier(){
    //get the VALUE
    var Name = $('#Name').val();
    var ColorCode = $('#ColorCode').val();
    var SupplierCategoryID = $('#SupplierCategoryID').val();
    var MobileNo = $('#MobileNo').val();
    var Address = $('#Address').val();
    var ContactPersonInfo = $('#ContactPersonInfo').val();
    var OpeningBalance = $('#OpeningBalance').val();

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
    $('#AddSupplier').val('Please Wait...');
    document.getElementById('AddSupplier').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "Supplier",
        Name: Name,
        ColorCode: ColorCode,
        SupplierCategoryID: SupplierCategoryID,
        MobileNo: MobileNo,
        Address: Address,
        ContactPersonInfo: ContactPersonInfo,
        OpeningBalance: OpeningBalance

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("["+Name + "] Save Successful !!!");
          //Form Value Update
          $('#AddSupplier').val('Save Data');
          document.getElementById('AddSupplier').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("SupplierList.php",function(){

          $('#SupplierView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("Sorry [ Name " + Name + " AND Mobile No " + MobileNo + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddSupplier').val('Save Data');
          document.getElementById('AddSupplier').disabled = false;
        } else {
          alert(result);
        }
      });
  }


  //Customer CategoryAdd
  function AddCustomerCategory(){
    //get the VALUE
    var Name = $('#Name').val();
    if (Name == '') {
      toastr.error('Please Enter Customer Category Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }


    // BEFORE RESPONSE
    $('#AddCustomerCategory').val('Please Wait...');
    document.getElementById('AddCustomerCategory').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "CustomerCategory",
        Name: Name

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("["+Name + "] Save Successful !!!");
          //Form Value Update
          $('#AddCustomerCategory').val('Save Data');
          document.getElementById('AddCustomerCategory').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("CustomerCategoryList.php",function(){

          $('#CustomerCategoryView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("Sorry [ " + Name + " ] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddCustomerCategory').val('Save Data');
          document.getElementById('AddCustomerCategory').disabled = false;
        } else {
          alert(result);
        }
      });
  }


  //Customer CategoryAdd
  function AddCustomerSubCategory(){
    //get the VALUE
    var Name = $('#Name').val();
    if (Name == '') {
      toastr.error('Please Enter Customer Category Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }


    // BEFORE RESPONSE
    $('#AddCustomerSubCategory').val('Please Wait...');
    document.getElementById('AddCustomerSubCategory').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "CustomerSubCategory",
        Name: Name

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("["+Name + "] Save Successful !!!");
          //Form Value Update
          $('#AddCustomerSubCategory').val('Save Data');
          document.getElementById('AddCustomerSubCategory').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("CustomerSubCategoryList.php",function(){

          $('#CustomerSubCategoryView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("Sorry [ " + Name + " ] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddCustomerSubCategory').val('Save Data');
          document.getElementById('AddCustomerSubCategory').disabled = false;
        } else {
          alert(result);
        }
      });
  }


  
  //Item Category Add
  function AddItemCategory(){
    //get the VALUE
    var Name = $('#Name').val();
    var SupplierID = $('#SupplierID').val();

    if (Name == '') {
      toastr.error('Please Enter Item Category Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }

    if (SupplierID == '') {
      toastr.error('Please Select Supplier Name!!!');
      playclip_warning();
      $('#SupplierID').focus();
      return false;
    }

    // BEFORE RESPONSE
    $('#AddItemCategory').val('Please Wait...');
    document.getElementById('AddItemCategory').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "ItemCategory",
        Name: Name,
        SupplierID: SupplierID

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("["+Name + "] Save Successful !!!");
          //Form Value Update
          $('#AddItemCategory').val('Save Data');
          document.getElementById('AddItemCategory').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("ItemCategoryList.php",function(){

          $('#ItemCategoryView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("Sorry [ Name " + Name + " AND Supplier] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddItemCategory').val('Save Data');
          document.getElementById('AddItemCategory').disabled = false;
        } else {
          alert(result);
        }
      });
  }

  
  //Package Size Add
  function AddPackageSize(){
    //get the VALUE
    var Thickness = $('#Thickness').val();
    var Size = $('#Size').val();
    var Thickness = $('#Thickness').val();
    var ItemCategoryID = $('#ItemCategoryID').val();
    var LowStock = $('#LowStock').val();
    var SupplierID = $('#SupplierID').val();

    if (Thickness == '') {
      toastr.error('Please Enter Item Package Size!!!');
      playclip_warning();
      $('#Thickness').focus();
      return false;
    }

    
    if (Size == '') {
      toastr.error('Please Enter Item Package Size!!!');
      playclip_warning();
      $('#Size').focus();
      return false;
    }


    if (SupplierID == '') {
      toastr.error('Please Select Supplier Name!!!');
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
    $('#AddPackageSize').val('Please Wait...');
    document.getElementById('AddPackageSize').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "PackageSize",
        Thickness: Thickness,
        Size: Size,
        ItemCategoryID: ItemCategoryID,
        LowStock: LowStock,
        Size: Size,
        SupplierID: SupplierID

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("["+Thickness + Size + "] Save Successful !!!");
          //Form Value Update
          $('#AddPackageSize').val('Save Data');
          document.getElementById('AddPackageSize').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("PackageSizeList.php",function(){

          $('#PackageSizeView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("Sorry Package Size Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddPackageSize').val('Save Data');
          document.getElementById('AddPackageSize').disabled = false;
        } else {
          alert(result);
        }
      });
  }


  

   //Customer/Customer Add
   function AddCustomer(){
    //get the VALUE
    var Name = $('#Name').val();;
    var CustomerCategoryID = $('#CustomerCategoryID').val();
    var CustomerSubCategoryID = $('#CustomerSubCategoryID').val();
    var MobileNo = $('#MobileNo').val();
    var Address = $('#Address').val();
    var CreditLimit = $('#CreditLimit').val();
    var OpeningBalance = $('#OpeningBalance').val();

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
    $('#AddCustomer').val('Please Wait...');
    document.getElementById('AddCustomer').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "Customer",
        Name: Name,
        CustomerCategoryID: CustomerCategoryID,
        CustomerSubCategoryID: CustomerSubCategoryID,
        MobileNo: MobileNo,
        Address: Address,
        CreditLimit: CreditLimit,
        OpeningBalance: OpeningBalance

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("["+Name + "] Save Successful !!!");
          //Form Value Update
          $('#AddCustomer').val('Save Data');
          document.getElementById('AddCustomer').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("CustomerList.php",function(){

          $('#CustomerView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("Sorry [ Name " + Name + " AND Mobile No " + MobileNo + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddCustomer').val('Save Data');
          document.getElementById('AddCustomer').disabled = false;
        } else {
          alert(result);
        }
      });
  }

   //Walet Add
   function AddWallet(){
    //get the VALUE
    var Name = $('#Name').val();
    var OpeningBalance = $('#OpeningBalance').val();
    if (Name == '') {
      toastr.error('Please Enter Wallet Name!!!');
      playclip_warning();
      $('#Name').focus();
      return false;
    }


    // BEFORE RESPONSE
    $('#AddWallet').val('Please Wait...');
    document.getElementById('AddWallet').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "Wallet",
        Name: Name,
        OpeningBalance: OpeningBalance

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("["+Name + "] Save Successful !!!");
          //Form Value Update
          $('#AddWallet').val('Save Data');
          document.getElementById('AddWallet').disabled = false;
          $('#modal-default1').modal('hide');

          $("#LoadCartList").load("SupplierCategoryList.php",function(){

          $('#SupplierCategoryView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("Sorry [ " + Name + " ] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddWallet').val('Save Data');
          document.getElementById('AddWallet').disabled = false;
        } else {
          alert(result);
        }
      });
  }


  
   //Bank Add
   function AddBank(){
    //get the VALUE
    var BranchName = $('#BranchName').val();
    var BankName = $('#BankName').val();
    var AccountName = $('#AccountName').val();
    var AccountNumber = $('#AccountNumber').val();
    var OpeningBalance = $('#OpeningBalance').val();
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
    $('#AddBank').val('Please Wait...');
    document.getElementById('AddBank').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "Bank",
        BranchName: BranchName,
        BankName: BankName,
        AccountName: AccountName,
        AccountNumber: AccountNumber,
        OpeningBalance: OpeningBalance

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("[" + BranchName + " - " + BankName + " - " + AccountName + " - " + AccountNumber + "] Save Successful !!!");
          //Form Value Update
          $('#AddBank').val('Save Data');
          document.getElementById('AddBank').disabled = false;
          $('#modal-default1').modal('hide');


          $("#LoadCartList").load("BankList.php",function(){

          $('#BankView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("[" + BranchName + " - " + BankName + " - " + AccountName + " - " + AccountNumber + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddBank').val('Save Data');
          document.getElementById('AddBank').disabled = false;
        } else {
          alert(result);
        }
      });
  }

  
   //Others Account Add
   function AddOthersAccount(){
    //get the VALUE
    var SectorName = $('#SectorName').val();
    var OthersAccountName = $('#OthersAccountName').val();
    var MobileNo = $('#MobileNo').val();
    var CreditLimit = $('#CreditLimit').val();
    var Category = $('#Category').val();
    var OpeningBalance = $('#OpeningBalance').val();
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
    $('#AddOthersAccount').val('Please Wait...');
    document.getElementById('AddOthersAccount').disabled = true;

    //use ajax to run the check
    $.post("InsertData.php", {
        action: "OthersAccount",
        SectorName: SectorName,
        OthersAccountName: OthersAccountName,
        MobileNo: MobileNo,
        CreditLimit: CreditLimit,
        Category: Category,
        OpeningBalance: OpeningBalance

      },
      function (result) {
        //if the result is 200
        if (result == 101) {
          //alert(result);
          toastr.success("[" + SectorName + " - " + OthersAccountName + "] Save Successful !!!");
          //Form Value Update
          $('#AddOthersAccount').val('Save Data');
          document.getElementById('AddOthersAccount').disabled = false;
          $('#modal-default1').modal('hide');


          $("#LoadCartList").load("OthersAccountList.php",function(){

          $('#OthersAccountView').DataTable({
          "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
          },
          'serverSide': 'true',
          'processing': 'true',
          'responsive': 'true',
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
          //alert(result);
          toastr.warning("[" + SectorName + " - " + OthersAccountName + "] Already Added !!!");
          playclip_warning();
          //Form Value Update
          $('#AddOthersAccount').val('Save Data');
          document.getElementById('AddOthersAccount').disabled = false;
        } else {
          alert(result);
        }
      });
  }