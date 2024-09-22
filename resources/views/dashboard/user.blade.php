@section('user')
    <section>
        <header class="bg-indigo-950 text-white shadow-md">
            <div class="container mx-auto flex items-center justify-between p-4">
                <div class="border-2 rounded-full h-[60px] w-[60px]">
                    <h1 class="text-xl font-bold text-center mt-3">J&G</h1>
                </div>
                <nav class="space-x-4">
                    <i class="fa-solid fa-user text-xl cursor-pointer rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold rounded-md hover:bg-rose-600  hover:text-white hover:scale-105 shadow-lg transition duration-300"
                        data-popover-target="popover-click" data-popover-trigger="click">
                    </i>

                    <div data-popover id="popover-click" role="tooltip"
                        class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                        <div
                            class="px-3 py-2 bg-sky-600 border-b border-sky-600 rounded-t-lg dark:border-indigo-600 dark:bg-indigo-600">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h3>
                        </div>
                        <div class="font-bold flex items-center gap-x-3 px-3 py-2 cursor-pointer hover:text-red-500"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <p>logout</p>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                </nav>
            </div>
        </header>

        <div class="flex h-screen">

            <form id="filtering-form" class="w-1/5 bg-gray-800 text-white p-4 space-y-6">

                <div class="bg-gray-700 p-4 rounded">
                    <h3 class="text-lg font-semibold mb-2">Sort By</h3>
                    <select name="sort-price" class="w-full bg-gray-800 text-white border border-gray-600 rounded p-2">
                        <option>Price</option>
                        <option value="asc">Low to High</option>
                        <option value="desc">High to Low</option>
                    </select>
                </div>

                <!-- Product Category Section -->
                <div class="bg-gray-700 p-4 rounded">
                    <h3 class="text-lg font-semibold mb-2">Product Category</h3>
                    <div class="space-y-2">
                        @php
                            $categories = [];
                            foreach ($products as $product) {
                                $categories[] = $product->category;
                            }
                            $uniqueCategories = array_unique($categories);
                        @endphp

                        @foreach ($uniqueCategories as $category)
                            <div>
                                <input id="{{ $category }}" type="checkbox" class="mr-2" name="categories[]"
                                    value="{{ $category }}">
                                <label for="{{ $category }}" class="text-sm">{{ $category }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="bg-gray-700 p-4 rounded">
                    <h3 class="text-lg font-semibold mb-2">Filter</h3>
                    <div class="space-y-2">
                        <div>
                            <label for="featured" class="flex items-center text-sm">
                                <input id="featured" type="checkbox" class="mr-2" name="isFeatured" value="Featured">
                                Featured
                            </label>
                        </div>
                        <div>
                            <label for="on-sale" class="flex items-center text-sm">
                                <input id="on-sale" type="checkbox" class="mr-2" name="isOnSale" value="On Sale">
                                On Sale
                            </label>
                        </div>
                    </div>
                    <button type="submit"
                        class="mt-4 bg-indigo-950 text-white px-4 py-2 rounded hover:bg-rose-700 hover:scale-105 transition duration-300">Apply</button>
                </div>
            </form>

            <!-- Content Area -->
            <main id="content-main" class="flex-1 p-6">
                <div class="text-2xl font-bold mb-4 flex items-center justify-between">
                    <h2>Welcome {{ Auth::user()->name }}</h2>
                    <input type="text" id="search-input"
                        class="w-1/4 p-2 rounded-md outline-none ring ring-indigo-500 focus:ring-indigo-600"
                        placeholder="Search Product...">
                </div>
                <div id="product-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                </div>
                <div id="product-error-message"></div>
                
                @include('user-section.chat')
            </main>

            <script>
                $('document').ready(() => {

                    function loadProducts() {
                        const products = $.ajax({
                            type: "GET",
                            url: "{{ route('get.products') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: (res) => {
                                console.log("loaded product:", res);
                                $('#product-error-message').empty();
                                res.forEach(product => productDisplay(product));

                                $("#search-input").keyup(() => {

                                    const searchVal = $("#search-input").val().toLowerCase();
                                    console.log(searchVal);

                                    const searchfilterered = searchVal ?
                                        res.filter(product =>
                                            product.product_name.toLowerCase().includes(searchVal) ||
                                            product.description.toLowerCase().includes(searchVal)
                                        ) : res;

                                    $('#product-list').empty();

                                    if (searchfilterered.length === 0) {
                                        $('#product-list').append(
                                            `<p class="text-center font-bold text-xl text-nowrap text-red-500">Sorry, The "${searchVal}" you are looking for was not found.</p>`
                                        );
                                    } else {
                                        searchfilterered.forEach(product => productDisplay(product));
                                    }

                                })
                            },
                            error: (err) => {
                                console.error(err);
                                $('#product-error-message').append(`
                                    <div>
                                        <p class="text-rose-500 text-lg text-center font-bold mt-10">Sorry, You can't view the data.</p>
                                        <p class="text-rose-500 text-base text-center font-bold"> 403 (Forbidden) ${err.responseJSON.message}</p>
                                    </div>
                                `);
                            }
                        })
                    }

                    loadProducts();

                    function productDisplay(product) {
                        $("#product-list").append(`
                            <div class="relative bg-white shadow-xl rounded-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:scale-105 cursor-pointer">
                                <!-- Image container -->
                                <div class="relative">
                                    <img src="/storage/images/${product.picture}" alt="${product.product_name}" class="w-full h-72 object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-between p-4 text-white">
                                        <div>
                                            <h3 class="text-lg font-bold mb-2">${product.product_name.slice(0, 50)}</h3>
                                            <p class="mb-4 sm:text-sm lg:text-md">${product.description.slice(0, 75)}...</p>
                                        </div>
                                        <div class="flex flex-col gap-y-1 bg-zinc-900/90 absolute bottom-2 p-2 rounded-md">
                                            <p class="font-bold text-xl text-green-500">${product.price}</p>
                                            <p class="font-medium text-sm text-lime-300">${product.category}</p>
                                        </div>
                                        ${product.status === "Featured" 
                                            ? (`<p class="absolute bottom-2 right-3 text-yellow-400 bg-zinc-900 px-2 py-1 rounded-full">${product.status}`)
                                            : (`<p></p>`)
                                        }
                                    </div>
                                </div>
                                <button data-id="${product.id}" class="add-order w-full bg-indigo-950 text-white px-4 py-3 text-base font-semibold rounded-lg shadow-md hover:bg-rose-700 transition duration-300">
                                    Add to Cart
                                </button>
                            </div>
                        `);
                    }

                    $(document).on("click", ".add-order", function() {
                        const {
                            id
                        } = $(this).data();

                        $.ajax({
                            type: "GET",
                            url: `/home/products/${id}`,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: (res) => {
                                //console.log(res);

                                Swal.fire({
                                    title: `Are you sure to order ${res.product_name}?`,
                                    text: res.description,
                                    icon: "question",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yes, Order this Product"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        savedOrder(res);

                                        Swal.fire({
                                            title: "Ordered Successfully",
                                            icon: "success",
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    }
                                });
                            },
                            error: (err) => {
                                console.error(err);
                            }
                        })
                    });

                    function savedOrder(data) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('store.orders') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                product_id: data.id,
                                product: data.product_name,
                                price: parseFloat(data.price)
                            },
                            success: (res) => {
                                console.log(res);
                            },
                            error: (err) => {
                                console.error(err);
                            }
                        })
                    }

                    $('#filtering-form').submit((e) => {
                        e.preventDefault();
                        const filteringFormData = new FormData($('#filtering-form')[0]);

                        $.ajax({
                            type: "POST",
                            url: "{{ route('filtered.products') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: filteringFormData,
                            processData: false,
                            contentType: false,
                            success: (res) => {
                                console.log("filtered response", res);

                                if (res.length) {
                                    $('#product-list').empty();
                                    res.forEach(product => productDisplay(product));
                                } else {
                                    $('#product-list').empty();
                                    $('#product-list').append(
                                        `<p class="text-center font-bold text-xl text-nowrap text-red-500">There are no products displayed based on your filtered category.</p>`
                                    );
                                }
                            },
                            error: (err) => {
                                console.log(err);
                            }
                        })
                    })
                })
            </script>
        </div>
    </section>
@endsection
