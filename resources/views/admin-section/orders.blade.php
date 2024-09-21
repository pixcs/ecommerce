<section id="orders-section" class="hidden h-[155px] border-4 border-y-indigo-950">
    <div class="p-4">
        <p class="w-full">Home > Orders</p>
        <p id="total-products" class="text-2xl font-bold my-2">Total Orders: {{ $orders->count() }}</p>
        <input type="date" name="" id="">
    </div>

    <table id="order-table" class="w-full mt-2">
        <thead>
            @if (Auth::user()->hasPermission(['orders-read']))
                <tr>
                    <th class="font-bold">Product</th>
                    <th class="font-bold">Customer</th>
                    <th class="font-bold">Purchase Date</th>
                    <th class="font-bold">Status</th>
                    <th class="font-bold">Price</th>
                </tr>
            @endif
        </thead>
        <tbody></tbody>
    </table>
    <div id="orders-error-container"></div>
</section>

<script>
    $(document).ready(() => {

        $.ajax({
            type: "GET",
            url: "{{ route('get.orders') }}",
            success: function(response) {
                console.log("Orders response:", response);
                new DataTable('#order-table');
                $('#orders-error-container').empty();

                if ($.fn.DataTable.isDataTable('#order-table')) {
                    $('#order-table').DataTable().destroy();
                }

                $('#order-table').DataTable({
                    data: response,
                    columns: [{
                            data: 'product'
                        },
                        {
                            data: 'customer',

                        },
                        {
                            data: 'purchase_date'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'price'
                        },

                    ]
                });

            },
            error: (err) => {
                console.error(err);
                $('#orders-error-container').append(`
                    <div>
                        <p class="text-rose-500 text-lg text-center font-bold mt-10"> 403 (Forbidden) ${err.responseJSON.message}</p>
                        <p class="text-rose-500 text-base text-center font-bold">Contact your Super Admin to gain access to this data.</p>
                    </div>
                `);
            }
        });
    })
</script>
