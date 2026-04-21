// LOAD Customer Balance
function CustomerBalance() {
    //get the VALUE
    var CustomerID = $('#CustomerID').val();

    document.getElementById('CustomerBalance').value = 'Loading...';
    //use ajax to run the check
    $.post("CustomerBalance.php", {
            CustomerID: CustomerID
        },
        function (result) {
            document.getElementById('CustomerBalance').value = result['CustomerBalance'];
        });

}

function CustomerDueReceive() {
    //get the VALUE
    var CustomerID = $('#CustomerID').val();
    var CustomerBalance = $('#CustomerBalance').val();
    var TransactionType = $('#TransactionType').val();
    var WalletID = $('#GetWalletID').val();
    var BankID = $('#GetBankID').val();
    var PaymentName = $('#PaymentName').val();
    var ReceiveAmount = $('#ReceiveAmount').val();
    var ReceiveDiscount = $('#ReceiveDiscount').val();
    var ReceiveNote = $('#ReceiveNote').val();
    var ReceiveDate = $('#ReceiveDate').val();
    var CustomerDueReceiveInvoice = $('#CustomerDueReceiveInvoice').val();

    if (CustomerID == '') {
        toastr.error('Please Select Customer Name !!!');
        playclip_warning();
        $('#CustomerID').focus();
        return false;
    }

    if (TransactionType == '') {
        toastr.error('Please Select Transaction Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        return false;
    }

    if ($.isNumeric(ReceiveAmount) && ReceiveAmount == '0') {
        toastr.error(' Please Enter Receive Amount !!!');
        playclip_warning();
        $('#ReceiveAmount').focus();
        $('#ReceiveAmount').val('0');
        return false;
    }

    if ( (WalletID + BankID) == '') {
        toastr.error('Please Check Transaction  Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        $('#TransactionType').val('');
        return false;
    }

    if (ReceiveDate == '') {
        toastr.error('Please Select Receive Date !!!');
        playclip_warning();
        $('#ReceiveDate').focus();
        return false;
    }
    
    if (ReceiveNote == '') {
        toastr.error('Please Select Receive Note !!!');
        playclip_warning();
        $('#ReceiveNote').focus();
        return false;
    }

    if (CustomerDueReceiveInvoice == '') {
        toastr.error('Please Enter Invoice No !!!');
        playclip_warning();
        $('#CustomerDueReceiveInvoice').focus();
        return false;
    }

    // BEFORE RESPONSE
    $('#CustomerDueReceive').val('Please Wait...');
    $('#CustomerDueReceive').attr('disabled', true);

    // use ajax to run the check
    $.post("ReceiveData.php", {
            action: 'CustomerDueReceive',
            CustomerID: CustomerID,
            CustomerBalance: CustomerBalance,
            TransactionType: TransactionType,
            WalletID: WalletID,
            BankID: BankID,
            PaymentName: PaymentName,
            ReceiveAmount: ReceiveAmount,
            ReceiveDiscount: ReceiveDiscount,
            ReceiveNote: ReceiveNote,
            ReceiveDate: ReceiveDate,
            CustomerDueReceiveInvoice: CustomerDueReceiveInvoice
        }, function (result) {
            //and after the ajax request ends we check the text returned
            if (result == '100') {
                toastr.success('Customer Due Receive Successfully Completed !!!');


                $('#CustomerID').val('').select2();
                $('#CustomerBalance').val('0');
                $('#TransactionType').val('').select2();
                $('#GetWalletID').val('');
                $('#GetBankID').val('');
                $('#PaymentName').val('');
                $('#ReceiveAmount').val('');
                $('#ReceiveDiscount').val('');
                $('#ReceiveNote').val('');
                $('#CustomerDueReceiveInvoice').val('');
                $('#CustomerID').focus();
                $('#pay_mode').html('');

                $('#CustomerDueReceive').val('Due Entry');
                $('#CustomerDueReceive').attr('disabled', false);

                $("#load_cart_list").load("CustomerDueReceiveList.php", function () {
                    $('#example2').DataTable();
                });


            } else {
                toastr.error(result);
                playclip_warning();
                $('#CustomerDueReceive').val('Due Entry');
                $('#CustomerDueReceive').attr('disabled', false);
                $('#CustomerID').focus();
            }

        }

    );

}



function CustomerReceive() {
    //get the VALUE
    var CustomerID = $('#CustomerID').val();
    var CustomerBalance = $('#CustomerBalance').val();
    var TransactionType = $('#TransactionType').val();
    var WalletID = $('#GetWalletID').val();
    var BankID = $('#GetBankID').val();
    var PaymentName = $('#PaymentName').val();
    var ReceiveAmount = $('#ReceiveAmount').val();
    var ReceiveDiscount = $('#ReceiveDiscount').val();
    var ReceiveNote = $('#ReceiveNote').val();
    var ReceiveDate = $('#ReceiveDate').val();
    var CustomerReceiveInvoice = $('#CustomerReceiveInvoice').val();

    if (CustomerID == '') {
        toastr.error('Please Select Customer Name !!!');
        playclip_warning();
        $('#CustomerID').focus();
        return false;
    }

    if (TransactionType == '') {
        toastr.error('Please Select Transaction Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        return false;
    }

    if ($.isNumeric(ReceiveAmount) && ReceiveAmount == '0') {
        toastr.error(' Please Enter Receive Amount !!!');
        playclip_warning();
        $('#ReceiveAmount').focus();
        $('#ReceiveAmount').val('0');
        return false;
    }

    if (ReceiveNote == '') {
        toastr.error('Please Select Receive Note !!!');
        playclip_warning();
        $('#ReceiveNote').focus();
        return false;
    }

    if (ReceiveDate == '') {
        toastr.error('Please Select Receive Date !!!');
        playclip_warning();
        $('#ReceiveDate').focus();
        return false;
    }

    if (CustomerReceiveInvoice == '') {
        toastr.error('Please Enter Invoice No !!!');
        playclip_warning();
        $('#CustomerReceiveInvoice').focus();
        return false;
    }

    if ( (WalletID + BankID) == '') {
        toastr.error('Please Check Transaction  Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        $('#TransactionType').val('');
        return false;
    }

    // BEFORE RESPONSE
    $('#CustomerReceive').val('Please Wait...');
    $('#CustomerReceive').attr('disabled', true);

    // use ajax to run the check
    $.post("ReceiveData.php", {
            action: 'CustomerReceive',
            CustomerID: CustomerID,
            CustomerBalance: CustomerBalance,
            TransactionType: TransactionType,
            WalletID: WalletID,
            BankID: BankID,
            PaymentName: PaymentName,
            ReceiveAmount: ReceiveAmount,
            ReceiveDiscount: ReceiveDiscount,
            ReceiveNote: ReceiveNote,
            ReceiveDate: ReceiveDate,
            CustomerReceiveInvoice: CustomerReceiveInvoice
        }, function (result) {
            //and after the ajax request ends we check the text returned
            if (result == '100') {
                toastr.success('Customer Due Receive Successfully Completed !!!');


                $('#CustomerID').val('').select2();
                $('#CustomerBalance').val('0');
                $('#TransactionType').val('').select2();
                $('#GetWalletID').val('');
                $('#GetBankID').val('');
                $('#PaymentName').val('');
                $('#ReceiveAmount').val('');
                $('#ReceiveDiscount').val('');
                $('#ReceiveNote').val('');
                $('#CustomerReceiveInvoice').val('');
                $('#CustomerID').focus();
                $('#pay_mode').html('');

                $('#CustomerReceive').val('Customer Receive');
                $('#CustomerReceive').attr('disabled', false);

                $("#load_cart_list").load("CustomerReceiveList.php", function () {
                    $('#example2').DataTable();
                });


            } else {
                toastr.error(result);
                playclip_warning();
                $('#CustomerReceive').val('Customer Receive');
                $('#CustomerReceive').attr('disabled', false);
                $('#CustomerID').focus();
            }

        }

    );

}


// LOAD Other Balance
function OtherBalance() {
    //get the VALUE
    var OtherID = $('#OtherID').val();

    document.getElementById('OtherBalance').value = 'Loading...';
    //use ajax to run the check
    $.post("OtherBalance.php", {
            OtherID: OtherID
        },
        function (result) {
            document.getElementById('OtherBalance').value = result['OtherBalance'];
        });

}