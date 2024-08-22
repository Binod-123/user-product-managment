<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
          <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-house-fill me-2"></i>Home</a>
        </li>
        <li class="nav-item rounded">
          <a class="nav-link" href="#"><i class="bi bi-people-fill me-2"></i>Logout</a>
        </li>
       
      </ul>
    </div>
  </div>
</nav>
<div class="container my-5">
        <h1 class="mb-4">Search Products </h1>

        <div class="input-group mb-4">
            <input type="text" id="product-search" class="form-control" placeholder="Search for a product (by name or code)">
            <button id="search-button" class="btn btn-primary">Search</button>
        </div>

        <div id="product-results" class="table-container">
            <div class="product-table-container">
                <table id="product-table" class="table table-bordered table-striped d-none">
                    <thead class="table-dark">
                        <tr>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Search results will be displayed here -->
                    </tbody>
                </table>
                <div id="no-products-message" class="alert alert-info d-none">
                    No products found.
                </div>
            </div>
        </div>

        <h2 class="mt-5">Generate Bill</h2>
        <form id="cartForm">
        <?= csrf_field() ?>
        <div class="cart-table-container">
            <table id="cart-table" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Cart items will be displayed here -->
                </tbody>
            </table>
            <div id="no-cart-message" class="alert alert-info d-none">
                No products in the cart.
            </div>
        </div>

        <h2 class="mt-4">Total Price: <span id="total-price">0</span></h2>

        <input type="hidden" name="total" id="total"value="">
        <input type="hidden" name="cart_data" id="cart_data" value="">
        <button id="submit-cart" class="btn btn-success mt-3" disable>Submit Cart</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            let totalPrice = 0;
            const cart = {};

            // Search product and display in table
            $('#search-button').click(function () {
                const query = $('#product-search').val();

                $.ajax({
                    url: '<?= base_url('home/searchProduct') ?>',
                    method: 'GET',
                    data: { query: query },
                    success: function (response) {
                        $('#product-table tbody').empty();
                        if (response.length === 0) {
                            $('#product-table').addClass('d-none');
                            $('#no-products-message').removeClass('d-none');
                        } else {
                            $('#product-table').removeClass('d-none');
                            $('#no-products-message').addClass('d-none');
                            response.forEach(product => {
                                $('#product-table tbody').append(`
                                    <tr data-price="${product.price}" data-id="${product.id}" data-name="${product.product_name}" data-code="${product.product_code}" data-stock="${product.stock_quantity}">
                                        <td>${product.product_name}</td>
                                        <td>${product.product_code}</td>
                                        <td>${product.price}</td>
                                        <td>
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary decrement-btn">-</button>
                                                <input type="number" class="form-control qty" value="1" min="1" max="${product.stock_quantity}" readonly>
                                                <button class="btn btn-outline-secondary increment-btn">+</button>
                                            </div>
                                        </td>
                                        <td><button class="btn btn-danger add-to-cart-btn">Add</button></td>
                                    </tr>
                                `);
                            });
                        }
                    }
                });
            });
     
            // Increment quantity
            $(document).on('click', '.increment-btn', function () {
                const $input = $(this).closest('.input-group').find('.qty');
                let qty = parseInt($input.val());
                const max = $input.attr('max');

                if (qty < max) {
                    qty++;
                    $input.val(qty);
                }
            });

            // Decrement quantity
            $(document).on('click', '.decrement-btn', function () {
                const $input = $(this).closest('.input-group').find('.qty');
                let qty = parseInt($input.val());

                if (qty > 1) {
                    qty--;
                    $input.val(qty);
                }
            });

            // Add to cart
            $(document).on('click', '.add-to-cart-btn', function () {
                const $row = $(this).closest('tr');
                const productId = $row.data('id');
                const productName = $row.data('name');
                const productcode = $row.data('code');
                const price = parseFloat($row.data('price'));
                const $qtyInput = $row.find('.qty');
                let qty = parseInt($qtyInput.val());
                const stock_quantity= parseInt($qtyInput.attr('max'));
                if (cart[productId]) {
                    cart[productId].qty += qty;
                } else {
                    cart[productId] = {
                        name: productName,
                        code:productcode,
                        price: price,
                        qty: qty,
                        stock_quantity:stock_quantity
                    };
                }

                updateCartTable();
                calculateTotal();
            });

            // Remove from cart
            

            // Update cart table
            function updateCartTable() {
                
            $('#cart-table tbody').empty();
            for (let id in cart) {
                
                const item = cart[id];
               
                const itemTotal = item.qty * item.price;
                $('#cart-table tbody').append(`
                    <tr data-id="${id}">
                        <td><input type="text" name="product[]" id="product[]" value="${item.name}" readonly></td>
                        <td> <input type="text" name="code[]" id="code[]" value="${item.code}" readonly></td>
                        <td><input type="text" name="price[]" id="price[]" value="${item.price.toFixed(2)}" readonly>
                        <input name="product_id" id="product_id" type="hidden" value="${id}">
                        </td>
                        <td>
                            <div class="input-group">
                                <a class="btn btn-outline-secondary decrement-cart-btn">-</a>
                                <input type="number" class="form-control cart-qty" value="${item.qty}" min="1" max="${item.stock_quantity}" readonly>
                                <a class="btn btn-outline-secondary increment-cart-btn">+</a>
                            </div>
                        </td>
                        <td class="cart-total">${itemTotal.toFixed(2)}</td>
                        <td><button class="btn btn-danger remove-cart-btn" data-id="${id}">Remove</button></td>
                        
                    </tr>
                `);
              }
              updateCartButtonState();
                calculateTotal();
            }


            // Calculate total price
            function calculateTotal() {
                totalPrice = 0;
                for (let id in cart) {
                    totalPrice += cart[id].qty * cart[id].price;
                }
                $('#total-price').text(totalPrice.toFixed(2));
                $('#total').val(totalPrice.toFixed(2));
            }
      
            // Submit cart to the database
            // Increment cart quantity
        $(document).on('click', '.increment-cart-btn', function () {
        
            const $row = $(this).closest('tr');
            const productId = $row.data('id');
            // Assuming `stock` is available in the cart item
            
            const $qtyInput = $row.find('.cart-qty');
            let qty = parseInt($qtyInput.val());
            const max = $qtyInput.attr('max');
            
            if (qty < max) {
                qty++;
                $row.find('.cart-qty').val(qty);
                cart[productId].qty = qty;
                updateRowTotal($row);
                calculateTotal();
            }
        });

// Decrement cart quantity
$(document).on('click', '.decrement-cart-btn', function () {
    const $row = $(this).closest('tr');
    const productId = $row.data('id');
    let qty = parseInt($row.find('.cart-qty').val());

    if (qty > 1) {
        qty--;
        $row.find('.cart-qty').val(qty);
        cart[productId].qty = qty;
        updateRowTotal($row);
        calculateTotal();
    }
});

// Remove item from cart
$(document).on('click', '.remove-cart-btn', function () {
    const productId = $(this).data('id');
    delete cart[productId];
    updateCartTable();
    updateCartButtonState();
});

// Update row total
function updateRowTotal($row) {
    const productId = $row.data('id');
    const qty = parseInt($row.find('.cart-qty').val());
    const price = cart[productId].price;
    const total = qty * price;

    $row.find('.cart-total').text(total.toFixed(2));
}
$(document).ready(function() {
    $('#cartForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way

        const cartData = [];
        $('#cart-table tbody tr').each(function() {
            const row = $(this);
            const product = row.find('input[name="product[]"]').val();
            const code = row.find('input[name="code[]"]').val();
            const price = row.find('input[name="price[]"]').val();
            const qty = row.find('.cart-qty').val();
            const total = row.find('.cart-total').text().trim();
            const id = row.find('input[name="product_id"]').val();

            cartData.push({
                id: id,
                product: product,
                code: code,
                price: parseFloat(price),
                qty: parseInt(qty),
                total: parseFloat(total)
            });
        });

        // Assign the JSON string to the hidden input field
        $('#cart_data').val(JSON.stringify(cartData));
       
        // Send the form data using AJAX
        $.ajax({
            url: 'home/save',  // The URL to submit the form data to
            method: 'POST',       // The HTTP method to use
            data: $(this).serialize(), // Serialize the form data
            dataType: 'JSON',     // The expected response format
            success: function(response) {
                alert(response);
                // Handle success response
                 //console.log('Form submitted successfully:', response);
                window.location.href = response.redirect_url;
                //alert('Form submitted successfully!');
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error('Form submission failed:', status, error);
                alert('Form submission failed. Please try again.');
            }
        });
    });
});

    // Function to toggle the button state
    function toggleSearchButton() {
        const searchInput = $('#product-search').val().trim();
        $('#search-button').prop('disabled', searchInput === '');
    }

    // Initial check on page load
    toggleSearchButton();

    // Event listener for input field
    $('#product-search').on('input', function() {
        toggleSearchButton();
    });
    function updateCartButtonState() {
        const cartTableRows = $('#cart-table tbody tr').length;
        const submitButton = $('#submit-cart');
       // const noCartMessage = $('#no-cart-message');
        
        if (cartTableRows > 0) {
            submitButton.prop('disabled', false); // Enable the button
          //  noCartMessage.addClass('d-none'); // Hide the "No products" message
        } else {
            submitButton.prop('disabled', true); // Disable the button
           // noCartMessage.removeClass('d-none'); // Show the "No products" message
        }
    }
    updateCartButtonState();
});
       
    </script>
</body>
</html>
