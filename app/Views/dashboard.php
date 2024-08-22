<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated Bills</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-w" href="#"> User Product Management</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-md-auto gap-2">
        <li class="nav-item rounded">
          <a class="nav-link active" aria-current="page" href="/"><i class="bi bi-house-fill me-2"></i>Home</a>
        </li>
        <li class="nav-item rounded">
          <a class="nav-link" href="/logout"><i class="bi bi-people-fill me-2"></i>Logout</a>
        </li>
       
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-3">
<a class="btn btn-success" style="margin-bottom:20px; align-item" href="/generate-bill" target="_blank">Generate Bill</a>
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>S-no</th>
			<th>User Name</th>
			<th>Bill No</th>
			<th>No of products</th>
      <th>Total Price</th>
			<th>Generated Date</th>
            <th>Action</th>
		</tr>
        <tbody>
		
</tbody>
	</thead>
</table>
</div>
<footer class="bg-dark text-white" style="position: absolute; bottom:0px; width:100%;">
  <p class="text-center p-4 m-0">Footer Content</p>
</footer>
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="invoice-box">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" class="text-center">
                                    <h4>Invoice #: <span id="invoiceNumber"></span></h4>
                                    <p>Created: <span id="invoiceDate"></span></p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                
                            </tr>
                            <tr class="heading">
                                <th>s-no</th>
                                <th>Product</th>
                                <th>Product code</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                            <tbody id="itemList">
                                <!-- Items will be inserted here dynamically -->
                            </tbody>
                            <tr class="total">
                                <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                                <td class="text-right"><strong>₹<span id="totalPrice">385.00</span></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        // Define the user ID (you might get this from session or another source)
        var userId = <?php echo session()->get('user_id');?> // Replace this with actual logged-in user ID
        
        // Fetch data from API
        $.ajax({
            url: 'http://localhost:8080/api/bills/user/' + userId, // Replace with your API URL
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Initialize DataTable with the fetched data
                console.log(response);
                if (response.status === 'success' && response.data.length > 0) {
                // Initialize DataTable with the fetched data
                $('#example').DataTable({
                    "data": response.data, // Response data from API
                    "columns": [
                        { "data": null, "render": function (data, type, row, meta) {
                            return meta.row + 1; // Auto-increment row number
                        }},
                        { "data": "user_name" }, // Adjust according to your API response
                        { "data": "bill_no" },
                        { "data": "product_count" }, // Ensure this matches your API response
                        { "data": "total_price" },
                        { "data": "created_at" },
                        { "data": "bill_no", "render": function (data, type, row) {
                            return '<button data-id="' + data + '" id="view-bill" class="view-bill btn btn-info">View</button>'; // Example action button
                        }}
                    ],
                    "paging": true,
                    "autoWidth": true
                    
                });
            } else {
            var table=  $('#example').DataTable({
                    "paging": true,
                    "autoWidth": true,
                    "language": {
                        "emptyTable": "No bills Generated By this user." // Custom message when the table is empty
                    }
                });
                // Handle the case where the server returns an error status
                //$('#example').DataTable().clear().draw("No products available");
                //$('#example').DataTable().clear().draw();
                //$('#example').parent().append('<p class="text-center">No products available</p>');
                table.clear().draw();
            }
        },
            error: function(xhr, status, error) {
              console.error('Error:', status, error);
            console.error('Response:', xhr.responseText);

            // Display a user-friendly message
            alert('Failed to fetch data.');
            }
        });
        
    });
    
   // Function to populate and show the invoice modal
function populateInvoiceModal(billDetails) {
    $('#invoiceNumber').text(billDetails.bill_code);
    $('#invoiceDate').text(new Date(billDetails.created_at).toLocaleDateString());
   // Adjust due date as needed
    $('#totalPrice').text(parseFloat(billDetails.total_price).toFixed(2));

    // Populate items
    var items = JSON.parse(billDetails.products);
    var itemList = $('#itemList');
    itemList.empty(); // Clear existing items

    items.forEach(function(item,index) {
      var productTotalPrice=item.qty*item.price
        itemList.append(
            `<tr class="item">
                <td>${index + 1}</td>
                <td>${item.product}</td>
                <td>${item.code}</td>
                <td>${item.qty}</td>
                <td>₹${parseFloat(item.price).toFixed(2)}rs</td>
                <td>₹${productTotalPrice.toFixed(2)}rs</td>
            </tr>`
        );
    });
}

// Example AJAX call to fetch and show invoice data
$(document).on('click', '.view-bill', function() {
    var billId = $(this).data('id');
    
    $.ajax({
        url: 'http://localhost:8080/api/bills/details/' + billId, // Adjust URL as needed
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                populateInvoiceModal(response.data);
                $('#invoiceModal').modal('show');
            } else {
                alert('Invoice data not found.');
            }
        },
        error: function() {
            alert('Failed to fetch invoice data.');
        }
    });
});

</script>
</body>
</html>
