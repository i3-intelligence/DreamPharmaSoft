//auto Cash Memo Invoice load      
if (typeof (EventSource) !== "undefined") {
    var source = new EventSource("CashMemoReturnInvoice.php", {
        withCredentials: true
    });
    source.onmessage = function (event) {
        var arr = event.data.split("~");
        document.getElementById("CashMemoReturnInvoice").value = arr[0];
        CalculateAmount();
    };

} else {
    document.getElementById("CashMemoReturnInvoice").value = "";
}



//Create Memo
function CreateCashMemoReturn() {
    //get the VALUE

    var CashMemoReturnInvoice = $('#CashMemoReturnInvoice').val();
    var TotalAmount = $('#TotalAmount').val();
    var TransactionType = $('#TransactionType').val();
    var GetWalletID = $('#GetWalletID').val();
    var GetBankID = $('#GetBankID').val();
    var PaymentName = $('#PaymentName').val();
    var PaymentAmount = $('#PaymentAmount').val();
    var TotalDue = $('#TotalDue').val();
    var CashMemoReturnDate = $('#CashMemoReturnDate').val();
    var Remarks = $('#Remarks').val();
    var CustomerID = $('#CustomerID').val();

    if (CashMemoReturnInvoice == '') {
        toastr.error('Please Select Cash Memo Invoice !!!');
        playclip_warning();
        $('#CashMemoReturnInvoice').focus();
        return false;
    }

    if ((PaymentAmount == '0') && CustomerID == '') {
        toastr.error('Please Enter Payment Amount !!!');
        playclip_warning();
        $('#PaymentAmount').focus();
        return false;
    }

   
    if ((TotalDue != '0') && (CustomerID == '')) {
        toastr.error('Please Paid Full Amount !!!');
        playclip_warning();
        $('#TotalDue').focus();
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
    
    
    if (TotalDue == '') {
        toastr.error('Please Select Total Due !!!');
        playclip_warning();
        $('#TotalDue').focus();
        return false;
    }

    if (CashMemoReturnDate == '') {
        toastr.error('Please Select Cash Memo Date !!!');
        playclip_warning();
        $('#CashMemoReturnDate').focus();
        return false;
    }

    if ((TransactionType != 'Due') && ((GetWalletID + GetBankID) == '')) {
        toastr.error('Please Check Transaction Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        $('#TransactionType').val('');
        return false;
    }

    document.getElementById("CreateCashMemoReturn").disabled = true;
    document.getElementById("CreateCashMemoReturn").value = 'Processing...';
    //use ajax to run the check
    $.post("CashMemoReturnCreate.php", {
            CashMemoReturnInvoice: CashMemoReturnInvoice,
            TotalAmount: TotalAmount,
            TransactionType: TransactionType,
            WalletID: GetWalletID,
            BankID: GetBankID,
            PaymentName: PaymentName,
            PaymentAmount: PaymentAmount,
            TotalDue: TotalDue,
            CashMemoReturnDate: CashMemoReturnDate,
            Remarks: Remarks
        },
        function (result) {
            document.getElementById("CreateCashMemoReturn").disabled = false;
            document.getElementById("CreateCashMemoReturn").value = 'Create Memo';
            if (result == 200) {
                toastr.success('Cash Memo Return Successfully Created !!!');
                window.open('CashMemoReturnview.php?CashMemoReturnInvoice='+CashMemoReturnInvoice, 'CASH MEMO', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=1,resizable=yes,copyhistory=no,width=1200,height=600');
                window.location.href = 'CashMemoReturn.php';
            }else if (result == 404) {
                toastr.error('Cash Memo Return Cart  Not Found !!!');
            }else {
                toastr.error(result);
                // window.location.href = 'CashMemoReturn.php';
            }
        }
    );

}


// Sales Calculation
function CalculateCartAmount(ChallanID) {
    //get the VALUE
    var ReturnQuantity = parseFloat(document.getElementById('ReturnQuantity' + ChallanID).value);
    var ReturnRate = parseFloat(document.getElementById('ReturnRate' + ChallanID).value);
    var StockQty = parseFloat(document.getElementById('StockQty' + ChallanID).value);

    var StockBalance = Math.round(StockQty - ReturnQuantity, 2);

    if (StockBalance < 0) {
        toastr.warning("Sales Quantity Can't be more than Stock Quantity " + StockQty);

        $('#Balance' + ChallanID).val(0);
        $('#ReturnQuantity' + ChallanID).val(StockQty);
        $('#ReturnAmount' + ChallanID).val(StockQty * ReturnRate);

    } else {
        $('#Balance' + ChallanID).val(StockBalance);
        var ReturnAmount = ReturnQuantity * ReturnRate;
        $('#ReturnAmount' + ChallanID).val(ReturnAmount);
    }

}

function ReceiveMode() {
    $('#GetWalletID').val('');
    $('#GetBankID').val('');

    var TransactionType = document.getElementById('TransactionType').value;
    document.getElementById('PaymentAmount').value = '0';
    document.getElementById('PaymentAmount').disabled = false;


    if (TransactionType == 'Wallet') {
        $('#modal-default3').modal({
            backdrop: 'static',
            keyboard: false
        });

        $("#modal-default3").modal('show');
        document.getElementById('PaymentAmount').value = '0';
        document.getElementById('PaymentAmount').disabled = false;


    } else if (TransactionType == 'Bank') {
        $('#modal-default7').modal({
            backdrop: 'static',
            keyboard: false
        });
        document.getElementById('PaymentAmount').value = '0';
        document.getElementById('PaymentAmount').disabled = false;
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
        var TotalAmount = parseFloat(document.getElementById('TotalAmount').value);
        var PaymentAmount = parseFloat(document.getElementById('PaymentAmount').value);
        var TotalDue =  Math.round(( TotalAmount) - (PaymentAmount), 2);
        parseFloat(document.getElementById('TotalDue').value = TotalDue);
}

//Wallet Receive
function WalletReceive() {

    var WalletID = $('#modal-default3 #WalletID').val();
    var PaymentName = $('#modal-default3 #WalletInfo').val();

    if (WalletID == '') {
        toastr.error('Please Select Wallet Info !!!');
        playclip_warning();
        $('#WalletID').focus();
        return false;
    }
    document.getElementById('GetWalletID').value = WalletID;
    $('#pay_mode').html('Wallet Receive : ' + PaymentName);
    document.getElementById('PaymentName').value = PaymentName;
    $('#modal-default3').modal('hide');

}

//Bank Banking     
function BankPayment() {

    var BankID = $('#modal-default7 #BankID').val();
    var PaymentName = $('#modal-default7 #BankInfo').val();

    if (BankID == '') {
        toastr.error('Please Select Bank Info !!!');
        playclip_warning();
        $('#BankID').focus();
        return false;
    }
    $('#pay_mode').html('Bank Receive : ' + PaymentName);
    document.getElementById('GetBankID').value = BankID;
    document.getElementById('PaymentName').value = PaymentName;

    $('#modal-default7').modal('hide');

}