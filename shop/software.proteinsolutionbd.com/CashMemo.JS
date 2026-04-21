//auto Cash Memo Invoice load      
if (typeof (EventSource) !== "undefined") {
    var source = new EventSource("CashMemoInvoice.php", {
        withCredentials: true
    });
    source.onmessage = function (event) {
        var arr = event.data.split("~");
        document.getElementById("CashMemoInvoice").value = arr[0];
        CalculateAmount();

    };

} else {
    document.getElementById("CashMemoInvoice").value = "";
}



//Invoice View
function InvoiceView() {
    //get the VALUE
    var SalesType = $('#SalesType').val();
    var CustomerID = $('#CustomerID').val();
    var CustomerName = $('#CustomerName').val();
    var CustomerAddress = $('#CustomerAddress').val();
    var SupplierID = $('#SupplierID').val();
    var ItemCategoryID = $('#ItemCategoryID').val();
    var CashMemoInvoice = $('#CashMemoInvoice').val();
    var PreviousBalance = $('#PreviousBalance').val();
    var TotalAmount = $('#TotalAmount').val();
    var TransactionType = $('#TransactionType').val();
    var GetWalletID = $('#GetWalletID').val();
    var GetBankID = $('#GetBankID').val();
    var ReceiveName = $('#ReceiveName').val();
    var DiscountPercentage = $('#DiscountPercentage').val();
    var Discount = $('#Discount').val();
    var ReceiveAmount = $('#ReceiveAmount').val();
    var TotalDue = $('#TotalDue').val();
    var CashMemoDate = $('#CashMemoDate').val();
    var Remarks = $('#Remarks').val();

    window.open('CashMemoPreview.php?SupplierID=' + SupplierID + '&ItemCategoryID=' + ItemCategoryID + '&SalesType=' + SalesType + '&CustomerName=' + CustomerName + '&CustomerAddress=' + CustomerAddress + '&CustomerID=' + CustomerID + '&CashMemoInvoice=' + CashMemoInvoice + '&PreviousBalance=' + PreviousBalance + '&TotalAmount=' + TotalAmount + '&TransactionType=' + TransactionType + '&GetWalletID=' + GetWalletID + '&GetBankID=' + GetBankID + '&ReceiveName=' + ReceiveName + '&ReceiveAmount=' + ReceiveAmount + '&DiscountPercentage=' + DiscountPercentage + '&Discount=' + Discount + '&TotalDue=' + TotalDue + '&CashMemoDate=' + CashMemoDate + '&Remarks=' + Remarks, 'CASH MEMO PREVIEW', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=1200,height=600');
}

//Create Memo
function CreateMemo() {
    //get the VALUE
    var SalesType = $('#SalesType').val();
    var CustomerCategoryID = $('#CustomerCategoryID').val();
    var CustomerID = $('#CustomerID').val();
    var CustomerName = $('#CustomerName').val();
    var CustomerAddress = $('#CustomerAddress').val();
    var CashMemoInvoice = $('#CashMemoInvoice').val();
    var PreviousBalance = $('#PreviousBalance').val();
    var TotalAmount = $('#TotalAmount').val();
    var TransactionType = $('#TransactionType').val();
    var WalletID = $('#GetWalletID').val();
    var BankID = $('#GetBankID').val();
    var ReceiveName = $('#ReceiveName').val();
    var DiscountPercentage = $('#DiscountPercentage').val();
    var Discount = $('#Discount').val();
    var ReceiveAmount = $('#ReceiveAmount').val();
    var TotalDue = $('#TotalDue').val();
    var CashMemoDate = $('#CashMemoDate').val();
    var Remarks = $('#Remarks').val();



    if (SalesType == '') {
        toastr.error('Please Select Sales Type !!!');
        playclip_warning();
        $('#SalesType').focus();
        return false;
    }
    if (CustomerID == '' && SalesType == 'Due') {
        toastr.error('Please Select Customer Name !!!');
        playclip_warning();
        $('#CustomerID').focus();
        return false;
    }

    if (CustomerName == '' && SalesType == 'Cash') {
        toastr.error('Please Select Customer Name !!!');
        playclip_warning();
        $('#CustomerID').focus();
        return false;
    }

   
    if (CashMemoInvoice == '') {
        toastr.error('Please Select Cash Memo Invoice !!!');
        playclip_warning();
        $('#CashMemoInvoice').focus();
        return false;
    }
    if (PreviousBalance == '') {
        toastr.error('Please Select Previous Balance !!!');
        playclip_warning();
        $('#PreviousBalance').focus();
        return false;
    }
    if (TotalAmount == '') {
        toastr.error('Please Select Total Amount !!!');
        playclip_warning();
        $('#TotalAmount').focus();
        return false;
    }
    if (TransactionType == '') {
        toastr.error('Please Select Transaction Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        return false;
    }
    
    if (ReceiveAmount == '') {
        toastr.error('Please Select Receive Amount !!!');
        playclip_warning();
        $('#ReceiveAmount').focus();
        return false;
    }
    
    if (TotalDue == '') {
        toastr.error('Please Select Total Due !!!');
        playclip_warning();
        $('#TotalDue').focus();
        return false;
    }

    if (CashMemoDate == '') {
        toastr.error('Please Select Cash Memo Date !!!');
        playclip_warning();
        $('#CashMemoDate').focus();
        return false;
    }
    
    if ((TransactionType != 'Due') && ((WalletID + BankID) == '')) {
        toastr.error('Please Check Transaction Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        $('#TransactionType').val('');
        return false;
    }

    if (Remarks == '') {
        toastr.error('Please Enter Remarks !!!');
        playclip_warning();
        $('#Remarks').focus();
        return false;
    }
    
// alert(TransactionType);
//     return false;

    document.getElementById("CreateMemo").disabled = true;
    document.getElementById("CreateMemo").value = 'Processing...';
    //use ajax to run the check
    $.post("CashMemoCreate.php", {
            SalesType: SalesType,
            CustomerCategoryID: CustomerCategoryID,
            CustomerID: CustomerID,
            CustomerName: CustomerName,
            CustomerAddress: CustomerAddress,
            CashMemoInvoice: CashMemoInvoice,
            PreviousBalance: PreviousBalance,
            TotalAmount: TotalAmount,
            TransactionType: TransactionType,
            WalletID: WalletID,
            BankID: BankID,
            ReceiveName: ReceiveName,
            ReceiveAmount: ReceiveAmount,
            DiscountPercentage: DiscountPercentage,
            Discount: Discount,
            TotalDue: TotalDue,
            CashMemoDate: CashMemoDate,
            Remarks: Remarks
        },
        function (result) {
            document.getElementById("CreateMemo").disabled = false;
            document.getElementById("CreateMemo").value = 'Create Memo';
            if (result == 200) {
                toastr.success('Cash Memo Successfully Created !!!');
                window.open('CashMemoview.php?CashMemoInvoice='+CashMemoInvoice, 'CASH MEMO', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=1200,height=600');
                window.location.href = 'CashMemo.php';

            } else if (result == 408) {
                toastr.error('Cash Customer Can Not Sale in Due !!!');   

            }else if (result == 407) {
                toastr.error('Please Paid Full Amount For Cash Customer !!!');

            }else if (result == 406) {
                toastr.error('This Customer Credit Limit Is Over!!!');

            }else if (result == 404) {
                toastr.error('Cash Memo Cart  Not Found !!!');
            }else {
                toastr.error(result);
                // window.location.href = 'CashMemo.php';
            }
        }
    );

}
  // LOAD Sub Item SupplierCategory
  function SupItemCategory() {
    //get the VALUE
    var SupplierIDMultipleSeles = $('#SupplierID').val();
    // alert(SupplierID);

    document.getElementById('loadItemCategory').innerHTML = 'Loading...';
    //use ajax to run the check
    $.post("JsonValue.php", {
        SupplierIDMultipleSeles: SupplierIDMultipleSeles
        },
        function (result) {
            document.getElementById('loadItemCategory').innerHTML = result['loadItemCategory'];
            $("#ItemCategoryID").select2();

            // alert(result);
        });
}

// LOAD Sales Category
function SalesCategory() {
    //get the VALUE
    var SalesType = $('#SalesType').val();
    // alert(SalesType);
    document.getElementById('SalesCategoryLoad').innerHTML = '';
    document.getElementById('SalesCategoryLoad').innerHTML = 'Loading...';
    //use ajax to run the check
    $.post("JsonValue.php", {
            SalesType: SalesType
        },
        function (result) {
            document.getElementById('SalesCategoryLoad').innerHTML = result['SalesCategoryLoad'];
            $("#CustomerID").select2();
        });
}

// Sales Calculation
function CalculateCartAmount(ChallanID) {
    //get the VALUE
    var SalesQuantity = parseFloat(document.getElementById('SalesQuantity' + ChallanID).value);
    var SalesRate = parseFloat(document.getElementById('SalesRate' + ChallanID).value);
    var Rate = parseFloat(document.getElementById('Rate' + ChallanID).value);
    var StockQty = parseFloat(document.getElementById('StockQty' + ChallanID).value);

    var StockBalance = Math.round(StockQty - SalesQuantity, 2);

    if (StockBalance < 0) {
        toastr.warning("Sales Quantity Can't be more than Stock Quantity " + StockQty);

        $('#Balance' + ChallanID).val(0);
        $('#SalesQuantity' + ChallanID).val(StockQty);
        $('#SalesAmount' + ChallanID).val(parseFloat(SalesQuantity * SalesRate).toFixed(3));

    } else {
        $('#Balance' + ChallanID).val(StockBalance);
        var SalesAmount = parseFloat(SalesQuantity * SalesRate).toFixed(3);
        $('#SalesAmount' + ChallanID).val(SalesAmount);
    }

}

function ReceiveMode() {
    $('#GetWalletID').val('');
    $('#GetBankID').val('');

    var TransactionType = document.getElementById('TransactionType').value;
    document.getElementById('ReceiveAmount').value = '0';
    document.getElementById('ReceiveAmount').disabled = false;


    if (TransactionType == 'Wallet') {
        $('#modal-default3').modal({
            backdrop: 'static',
            keyboard: false
        });

        $("#modal-default3").modal('show');
        document.getElementById('ReceiveAmount').value = '0';
        document.getElementById('ReceiveAmount').disabled = false;


    } else if (TransactionType == 'Bank') {
        $('#modal-default7').modal({
            backdrop: 'static',
            keyboard: false
        });
        document.getElementById('ReceiveAmount').value = '0';
        document.getElementById('ReceiveAmount').disabled = false;
        $("#modal-default7").modal('show');

    }
}

//Calculate Discount %
function CalculateDiscountPercentage()
{
var DiscountPercentage = Math.round((document.getElementById('TotalAmount').value * document.getElementById('DiscountPercentage').value)/100);	
document.getElementById('Discount').value = DiscountPercentage
CalculateAmount();
}

function CalculateAmount() {
        //get the VALUE
        var PreviousBalance = parseFloat(document.getElementById('PreviousBalance').value);
        var TotalAmount = parseFloat(document.getElementById('TotalAmount').value);
        var ReceiveAmount = parseFloat(document.getElementById('ReceiveAmount').value);
        var Discount = parseFloat(document.getElementById('Discount').value);
        var TotalDue =  parseFloat((PreviousBalance + TotalAmount) - (ReceiveAmount + Discount)).toFixed(2);
        parseFloat(document.getElementById('TotalDue').value = TotalDue);
}

//Wallet Receive
function WalletReceive() {

    var WalletID = $('#modal-default3 #WalletID').val();
    var ReceiveName = $('#modal-default3 #WalletInfo').val();

    if (WalletID == '') {
        toastr.error('Please Select Wallet Info !!!');
        playclip_warning();
        $('#WalletID').focus();
        return false;
    }
    document.getElementById('GetWalletID').value = WalletID;
    $('#pay_mode').html('Wallet Receive : ' + ReceiveName);
    document.getElementById('ReceiveName').value = ReceiveName;
    $('#modal-default3').modal('hide');

}

//Bank Banking     
function BankPayment() {

    var BankID = $('#modal-default7 #BankID').val();
    var ReceiveName = $('#modal-default7 #BankInfo').val();

    if (BankID == '') {
        toastr.error('Please Select Bank Info !!!');
        playclip_warning();
        $('#BankID').focus();
        return false;
    }
    $('#pay_mode').html('Bank Receive : ' + ReceiveName);
    document.getElementById('GetBankID').value = BankID;
    document.getElementById('ReceiveName').value = ReceiveName;

    $('#modal-default7').modal('hide');

}