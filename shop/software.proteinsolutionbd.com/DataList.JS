// Branch Name List Search
function BranchList() {
    var BranchName = $('#BranchName').val();
    // alert(BranchName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            BranchName: BranchName
        },
        dataType: "json",
        success: function (data) {
            // alert(data);
            $('#BranchList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#BranchList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}


// Bank Name List Search
function BankNameList() {
    var BankName = $('#BankName').val();
    // alert(BankName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            BankName: BankName
        },
        dataType: "json",
        success: function (data) {
            $('#BankNameList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#BankNameList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}



// Account Name List Search
function AccountNameList() {
    var AccountName = $('#AccountName').val();
    // alert(AccountName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            AccountName: AccountName
        },
        dataType: "json",
        success: function (data) {
            $('#AccountNameList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#AccountNameList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}


// Sector Name List Search
function SectorNameList() {
    var SectorName = $('#SectorName').val();
    // alert(AccountName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            SectorName: SectorName
        },
        dataType: "json",
        success: function (data) {
            $('#SectorNameList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#SectorNameList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}


// Cash Memo List Search
function CashMemoInvoiceList() {
    var CashMemoInvoice = $('#CashMemoInvoice').val();
    // alert(AccountName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            CashMemoInvoice: CashMemoInvoice
        },
        dataType: "json",
        success: function (data) {
            $('#CashMemoInvoiceList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#CashMemoInvoiceList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}



// Cash Memo Return List Search
function CashMemoReturnInvoiceList() {
    var CashMemoReturnInvoice = $('#CashMemoReturnInvoice').val();
    // alert(AccountName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            CashMemoReturnInvoice: CashMemoReturnInvoice
        },
        dataType: "json",
        success: function (data) {
            $('#CashMemoReturnInvoiceList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#CashMemoReturnInvoiceList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}



// Customer Receive Invoice List Search
function CustomerReceiveInvoiceList() {
    var CustomerReceiveInvoice = $('#CustomerReceiveInvoice').val();
    // alert(AccountName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            CustomerReceiveInvoice: CustomerReceiveInvoice
        },
        dataType: "json",
        success: function (data) {
            $('#CustomerReceiveInvoiceList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#CustomerReceiveInvoiceList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}



// Customer Due Receive Invoice List Search
function CustomerDueReceiveInvoiceList() {
    var CustomerDueReceiveInvoice = $('#CustomerDueReceiveInvoice').val();
    // alert(AccountName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            CustomerDueReceiveInvoice: CustomerDueReceiveInvoice
        },
        dataType: "json",
        success: function (data) {
            $('#CustomerDueReceiveInvoiceList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#CustomerDueReceiveInvoiceList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}



// Customer Due Receive Invoice List Search
function SupplierPaymentInvoiceList() {
    var SupplierPaymentInvoice = $('#SupplierPaymentInvoice').val();
    // alert(AccountName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            SupplierPaymentInvoice: SupplierPaymentInvoice
        },
        dataType: "json",
        success: function (data) {
            $('#SupplierPaymentInvoiceList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#SupplierPaymentInvoiceList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}

// Cash Memo List Search
function ChallanInvoiceList() {
    var ChallanInvoice = $('#ChallanInvoice').val();
    // alert(AccountName);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            ChallanInvoice: ChallanInvoice
        },
        dataType: "json",
        success: function (data) {
            $('#ChallanInvoiceList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#ChallanInvoiceList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}




// Customer Address List Search
function CustomerAddressList() {
    var CustomerAddress = $('#Address').val();
    // alert(CustomerAddress);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            CustomerAddress: CustomerAddress
        },
        dataType: "json",
        success: function (data) {
            $('#CustomerAddressList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#CustomerAddressList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}


// Customer Receive Note List Search
function CustomerReceiveNoteList() {
    var CustomerReceiveNote = $('#ReceiveNote').val();
    // alert(CustomerReceiveNote);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            CustomerReceiveNote: CustomerReceiveNote
        },
        dataType: "json",
        success: function (data) {
            $('#CustomerReceiveNoteList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#CustomerReceiveNoteList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}


// Customer Due Receive Note List Search
function CustomerDueReceiveNoteList() {
    var CustomerDueReceiveNote = $('#ReceiveNote').val();
    // alert(CustomerReceiveNote);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            CustomerDueReceiveNote: CustomerDueReceiveNote
        },
        dataType: "json",
        success: function (data) {
            $('#CustomerDueReceiveNoteList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#CustomerDueReceiveNoteList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}



// Customer Due Receive Note List Search
function SupplierPaymentNoteList() {
    var SupplierPaymentNote = $('#PaymentNote').val();
    // alert(CustomerReceiveNote);
    $.ajax({
        url: "DataList.php",
        method: "POST",
        data: {
            SupplierPaymentNote: SupplierPaymentNote
        },
        dataType: "json",
        success: function (data) {
            $('#SupplierPaymentNoteList').empty();
            for (var i = 0; i < data.length; i++) {
                $('#SupplierPaymentNoteList').append('<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }
    })
}