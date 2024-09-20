
<div id="products-section" class="hidden h-[155px] border-4 border-y-indigo-950">
    <div class="p-4">
        <p class="w-full">Home > Products</p>
        <p id="total-products" class="text-2xl font-bold my-2">Total Products: {{ $products->count() }}</p>

        <div class="flex items-center justify-between">
            <input type="date" name="" id="">

            <div class="flex items-center space-x-4">
                <button id="add-product-btn"
                    {{Auth::user()->hasPermission(['products-create']) ? '' : "disabled" }}
                    class="{{Auth::user()->hasPermission(['products-create']) ? 'bg-indigo-950 hover:bg-rose-600 hover:text-white hover:scale-105' : " bg-gray-500 opacity-35 cursor-not-allowed" }} px-3 py-2 flex items-center space-x-2 rounded-md text-white shadow-lg transition duration-300">
                    <i class="fa-solid fa-plus"></i>
                    <p>Add Product</p>
                </button>
                {{-- <button
                    class="px-3 py-2 flex items-center space-x-2 rounded-md text-white bg-indigo-950 hover:bg-rose-600 hover:text-white hover:scale-105 shadow-lg transition duration-300">
                    <i class="fa-solid fa-plus"></i>
                    <p>Add to SALE</p>
                </button> --}}
            </div>
        </div>
    </div>

    {{-- product section --}}
    <div>

        <div class="container">
            <table id="myTable" class="w-full">
                <thead>
                    <tr>
                        <th class="t-head">
                            <p>Product Name</p>
                        </th>
                        <th>Description</th>
                        <th>Picture</th>
                        <th>Stocks</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="hover:bg-slate-200 hover:shadow-lg transition duration-300">
                            <td>
                                @if(Auth::user()->hasPermission(['products-delete']))
                                    <input type="checkbox" id="{{ $product->id }}" class="check cursor-pointer">
                                @endif
                                <label for="{{ $product->id }}" class="m-0 {{Auth::user()->hasPermission(['products-delete']) ? 'cursor-pointer' : '' }}">{{ $product->product_name }}</label>
                            </td>
                            <td>{{ $product->description }}</td>
                            <td>
                                <img src="{{ asset('/storage/images/' . $product->picture) }}"
                                    alt="{{ $product->picture }}" class="image">
                            </td>
                            <td>{{ $product->stocks }}</td>
                            <td>₱{{ $product->price }}</td>
                            <td>{{ $product->status }}</td>
                            <td>
                                <button id="{{ $product->id }}" data-id="{{ $product->id }}"
                                    {{Auth::user()->hasPermission(['products-update']) ? '' : "disabled" }}
                                    class="{{Auth::user()->hasPermission(['products-update']) ? 'hover:bg-slate-200 hover:scale-105' : "bg-gray-300 opacity-35 cursor-not-allowed" }} select-edit-product-btn w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm transition duration-300 sm:ml-3 sm:w-auto">
                                    <i class="fa-regular fa-pen-to-square text-xl"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Add Product Modal  --}}
        <div id="add-product-modal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-zinc-950 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div
                    class=" backdrop-blur-sm flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <form method="POST" action="/home/products" id="add-product-form" enctype="multipart/form-data"
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start md:items-center justify-center">
                                <div class="sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-2xl font-semibold leading-6 text-gray-900 mb-4" id="modal-title">Add
                                        Product
                                    </h3>
                                    <div>
                                        <div class="flex flex-col gap-y-3">
                                            <label for="product-name" class="m-0">Product name</label>
                                            <input type="text" id="product-name" name="product_name"
                                                class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                        </div>
                                        <div class="flex flex-col gap-y-3 mt-3">
                                            <label for="description" class="m-0">Description</label>
                                            <input type="text" id="description" name="description"
                                                class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                        </div>
                                        <div class="flex flex-col gap-y-3 mt-3">
                                            <label for="price" class="m-0">Price</label>
                                            <input type="text" id="price" name="price"
                                                class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                        </div>
                                        <div class="flex flex-col gap-y-3 mt-3">
                                            <label for="category" class="m-0">Category</label>
                                            <input type="text" id="category" name="category"
                                                class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                        </div>
                                        <div class="flex flex-col gap-y-3 mt-3">
                                            <label for="upload-picture" class="m-0">Picture</label>
                                            <input type="file" id="upload-picture" accept="image/*" name="picture"
                                                class="w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700">
                                        </div>

                                        <div class="flex items-center mt-3 gap-x-2 border-b-2 pb-2 border-slate-200">
                                            <select name="status" class="outline-none">
                                                <option value="Not Featured">Not Featured</option>
                                                <option value="Featured">Featured</option>
                                            </select>
                                        </div>
                                        <div class="flex flex-col items-start  mt-3 gap-2">
                                            <div class="flex items-center gap-x-2">
                                                <input type="radio" name="stocks" id="available" value="available">
                                                <label for="available" class="m-0">Available</label>
                                            </div>
                                            <div class="flex items-center gap-x-2">
                                                <input type="radio" name="stocks" id="not-available"
                                                    value="not available">
                                                <label for="not-available" class="m-0">Not
                                                    Available</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="error-form-container" class="my-2 bg-red-200 mx-4"></div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button
                                class="text-white w-full justify-center rounded-md bg-indigo-950 px-3 py-2 text-sm font-semibold rounded-md hover:bg-rose-600 hover:text-white hover:scale-105 shadow-lg transition duration-300 sm:ml-3 sm:w-auto">
                                + Add</button>
                            <button id="cancel-product-btn" type="button"
                                class="w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm hover:bg-slate-200 hover:scale-105 transition duration-300 sm:ml-3 sm:w-auto">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Product Modal --}}
    <div id="edit-product-modal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-zinc-950 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div
                class=" backdrop-blur-sm flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <form method="PUT" id="edit-product-form" enctype="multipart/form-data"
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start md:items-center justify-center">
                            <div class="sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-2xl font-semibold leading-6 text-gray-900 mb-4" id="modal-title">
                                    Update Product
                                </h3>
                                <div>
                                    <div class="flex flex-col gap-y-3">
                                        <label for="edit-product-name" class="m-0">Product name</label>
                                        <input type="text" id="edit-product-name" name="product_name"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="edit-description" class="m-0">Description</label>
                                        <input type="text" id="edit-description" name="description"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="edit-price" class="m-0">Price</label>
                                        <input type="text" id="edit-price" name="price"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="edit-category" class="m-0">Category</label>
                                        <input type="text" id="edit-category" name="category"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="edit-picture" class="m-0">Picture</label>
                                        <input type="file" id="edit-picture" accept="image/*" name="picture"
                                            class="w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700">

                                    </div>

                                    <div class="flex items-center mt-3 gap-x-2 border-b-2 pb-2 border-slate-200">
                                        <select name="status" class="outline-none" id="status">
                                            <option value="Not Featured">Not Featured</option>
                                            <option value="Featured">Featured</option>
                                        </select>
                                    </div>
                                    <div class="flex flex-col items-start  mt-3 gap-2">
                                        <div class="flex items-center gap-x-2">
                                            <input type="radio" name="stocks" id="edit-available"
                                                value="available">
                                            <label for="edit-available" class="m-0">Available</label>
                                        </div>
                                        <div class="flex items-center gap-x-2">
                                            <input type="radio" name="stocks" id="edit-not-available"
                                                value="not available">
                                            <label for="edit-not-available" class="m-0">Not
                                                Available</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="edit-error-form-container" class="my-2 bg-red-200 mx-4">

                    </div>
                    <div class="edit-update-btn bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="update-product-btn"
                            class="text-white w-full justify-center rounded-md bg-indigo-950 px-3 py-2 text-sm font-semibold rounded-md hover:bg-rose-600 hover:text-white hover:scale-105 shadow-lg transition duration-300 sm:ml-3 sm:w-auto">
                            Update</button>
                        <button id="cancel-edit-product-btn" type="button"
                            class="w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm hover:bg-slate-200 hover:scale-105 transition duration-300 sm:ml-3 sm:w-auto">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
