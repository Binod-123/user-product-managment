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
    <div class="container my-5">
        <h1 class="mb-4">Create Bill</h1>

        <div class="input-group mb-3">
            <input type="text" id="product-search" class="form-control" placeholder="Search for a product (by name or code)">
            <button id="search-button" class="btn btn-primary">Search</button>
        </div>

        <table id="product-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Products will be added here -->
            </tbody>
        </table>

        <h2>Total Price: <span id="total-price">0</span></h2>
    </div>

    <script>
        $(document).ready(function () {
            let totalPrice = 0;

            $('#search-button').click(function () {
                const query = $('#product-search').val();

                $.ajax({
                    url: '<?= base_url('home/searchProduct') ?>',
                    method: 'GET',
                    data: { query: query },
                    success: function (response) {
                        $('#product-table tbody').empty();
                        response.forEach(product => {
                            $('#product-table tbody').append(`
                                <tr data-price="${product.price}" data-id="${product.id}">
                                    <td>${product.name}</td>
                                    <td>${product.price}</td>
                                    <td>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary decrement-btn">-</button>
                                            <input type="number" class="form-control qty" value="1" min="1" max="${product.stock}" readonly>
                                            <button class="btn btn-outline-secondary increment-btn">+</button>
                                        </div>
                                    </td>
                                    <td class="total">${product.price}</td>
                                    <td><button class="btn btn-danger remove-btn">Remove</button></td>
                                </tr>
                            `);
                        });

                        calculateTotal();
                    }
                });
            });

            $(document).on('click', '.increment-btn', function () {
                const $input = $(this).closest('.input-group').find('.qty');
                let qty = parseInt($input.val());
                const max = $input.attr('max');

                if (qty < max) {
                    qty++;
                    $input.val(qty);
                    updateRowTotal($(this).closest('tr'));
                }
            });

            $(document).on('click', '.decrement-btn', function () {
                const $input = $(this).closest('.input-group').find('.qty');
                let qty = parseInt($input.val());

                if (qty > 1) {
                    qty--;
                    $input.val(qty);
                    updateRowTotal($(this).closest('tr'));
                }
            });

            $(document).on('click', '.remove-btn', function () {
                $(this).closest('tr').remove();
                calculateTotal();
            });

            function updateRowTotal($row) {
                const qty = parseInt($row.find('.qty').val());
                const price = parseFloat($row.data('price'));
                const total = qty * price;

                $row.find('.total').text(total.toFixed(2));
                calculateTotal();
            }

            function calculateTotal() {
                totalPrice = 0;
                $('#product-table tbody tr').each(function () {
                    const rowTotal = parseFloat($(this).find('.total').text());
                    totalPrice += rowTotal;
                });
                $('#total-price').text(totalPrice.toFixed(2));
            }
        });
    </script>
</body>
</html>
