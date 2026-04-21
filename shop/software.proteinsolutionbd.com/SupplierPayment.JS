//auto Supplier Payment Invoice load      
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource("SupplierPaymentInvoice.php",{ withCredentials: true });
    source.onmessage = function(event) {
        var arr = event.data.split("~");
        document.getElementById("SupplierPaymentInvoice").value = arr[0];
        // transfer_calculate();

    };

    } else {
    document.getElementById("SupplierPaymentInvoice").value = "";
    }

function PaymentMode()
{
    $('#GetWalletID').val('');
    $('#GetBankID').val('');

  var TransactionType = document.getElementById('TransactionType').value;
  document.getElementById('PaymentAmount').value = '0';
  document.getElementById('PaymentAmount').disabled = false;
  

  if(TransactionType == 'Wallet'){
    $('#modal-default3').modal({
    backdrop: 'static',
    keyboard: false
    });

    $("#modal-default3").modal('show');
    document.getElementById('PaymentAmount').value = '0';
    document.getElementById('PaymentAmount').disabled = false;
 

}else if(TransactionType == 'Bank'){
    $('#modal-default7').modal({
    backdrop: 'static',
    keyboard: false
    });
    document.getElementById('PaymentAmount').value = '0';
    document.getElementById('PaymentAmount').disabled = false;
    $("#modal-default7").modal('show');
 
  }
}



//Delete Product
$('#modal-default1').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        var modal = $(this);
        var dataString = 'id=' + recipient;

        $.ajax({
            type: "GET",
            url: "DeleteSupplierPayment.php",
            data: dataString,
            cache: false,
            success: function (data) {
                console.log(data);
                modal.find('.dash').html(data);
            },
            error: function (err) {
                console.log(err);
            }
        });
    });

    
//Wallet Payment
    function WalletPayment() {

        var WalletID = $('#modal-default3 #WalletID').val();
        var PaymentName = $('#modal-default3 #WalletInfo').val();

        if (WalletID == '') {
            toastr.error('Please Select Wallet Info !!!');
            playclip_warning();
            $('#WalletID').focus();
            return false;
        }
        document.getElementById('GetWalletID').value = WalletID;
        $('#pay_mode').html('Wallet Payment : '+PaymentName);
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
    $('#pay_mode').html('Bank Payment : '+PaymentName);
    document.getElementById('GetBankID').value = BankID;
    document.getElementById('PaymentName').value = PaymentName;

    $('#modal-default7').modal('hide');

    }

