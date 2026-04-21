// LOAD Supplier Balance
function SupplierBalance() {
    //get the VALUE
    var SupplierID = $('#SupplierID').val();

    document.getElementById('SupplierBalance').value = 'Loading...';
    //use ajax to run the check
    $.post("SupplierBalance.php", {
        SupplierID: SupplierID
        },
        function (result) {
            document.getElementById('SupplierBalance').value = result['SupplierBalance'];
        });

}

function SupplierPayment() {
    //get the VALUE
    var SupplierID = $('#SupplierID').val();
    var SupplierBalance = $('#SupplierBalance').val();
    var TransactionType = $('#TransactionType').val();
    var WalletID = $('#GetWalletID').val();
    var BankID = $('#GetBankID').val();
    var PaymentName = $('#PaymentName').val();
    var PaymentAmount = $('#PaymentAmount').val();
    var PaymentDiscount = $('#PaymentDiscount').val();
    var PaymentNote = $('#PaymentNote').val();
    var PaymentDate = $('#PaymentDate').val();
    var SupplierPaymentInvoice = $('#SupplierPaymentInvoice').val();

    if (SupplierID == '') {
        toastr.error('Please Select Supplier Name !!!');
        playclip_warning();
        $('#SupplierID').focus();
        return false;
    }

    if (TransactionType == '') {
        toastr.error('Please Select Transaction Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        return false;
    }

    if ($.isNumeric(PaymentAmount) && PaymentAmount == '0' && PaymentDiscount == '0') {
        toastr.error(' Please Enter Payment Amount !!!');
        playclip_warning();
        $('#PaymentAmount').focus();
        $('#PaymentAmount').val('0');
        return false;
    }

    
    if (PaymentNote == '') {
        toastr.error('Please Select Payment Note !!!');
        playclip_warning();
        $('#PaymentNote').focus();
        return false;
    }

    if (PaymentDate == '') {
        toastr.error('Please Select Payment Date !!!');
        playclip_warning();
        $('#PaymentDate').focus();
        return false;
    }

    if (SupplierPaymentInvoice == '') {
        toastr.error('Please Enter Invoice No !!!');
        playclip_warning();
        $('#SupplierPaymentInvoice').focus();
        return false;
    }

    
    if ( (WalletID + BankID) == '') {
        toastr.error('Please Check Transaction Type !!!');
        playclip_warning();
        $('#TransactionType').focus();
        $('#TransactionType').val('');
        return false;
    }

    // BEFORE RESPONSE
    $('#SupplierPayment').val('Please Wait...');
    $('#SupplierPayment').attr('disabled', true);

    // use ajax to run the check
    $.post("PaymentData.php", {
            action: 'SupplierPayment',
            SupplierID: SupplierID,
            SupplierBalance: SupplierBalance,
            TransactionType: TransactionType,
            WalletID: WalletID,
            BankID: BankID,
            PaymentName: PaymentName,
            PaymentAmount: PaymentAmount,
            PaymentDiscount: PaymentDiscount,
            PaymentNote: PaymentNote,
            PaymentDate: PaymentDate,
            SupplierPaymentInvoice: SupplierPaymentInvoice
        }, function (result) {
            //and after the ajax request ends we check the text returned
            if (result == '100') {
                toastr.success('Supplier Payment Successfully Completed !!!');

                $('#SupplierID').val('').select2();
                $('#SupplierBalance').val('0');
                $('#TransactionType').val('').select2();
                $('#GetWalletID').val('');
                $('#GetBankID').val('');
                $('#PaymentName').val('');
                $('#PaymentAmount').val('');
                $('#PaymentDiscount').val('');
                $('#PaymentNote').val('');
                $('#SupplierPaymentInvoice').val('');
                $('#SupplierID').focus();
                $('#pay_mode').html('');

                $('#SupplierPayment').val('Supplier Payment');
                $('#SupplierPayment').attr('disabled', false);

                $("#load_cart_list").load("SupplierPaymentList.php", function () {
                    $('#example2').DataTable();
                });


            } else {
                toastr.error(result);
                playclip_warning();
                $('#SupplierPayment').val('Supplier Payment');
                $('#SupplierPayment').attr('disabled', false);
                $('#SupplierID').focus();
            }

        }

    );

}