<div id="manage-user-section">
    <h1 class="text-2xl p-2 font-bold my-2">Manage User</h1>
        <button id="add-user-btn"
            {{Auth::user()->hasPermission(['users-create']) ? '' : "disabled" }}
            class="{{Auth::user()->hasPermission(['users-create']) ? 'bg-indigo-950 hover:bg-rose-600 hover:text-white hover:scale-105' : " bg-gray-500 opacity-35 cursor-not-allowed" }} text-white w-full my-2 justify-center rounded-md px-3 py-2 text-sm font-semibold rounded-md shadow-md transition duration-300 sm:ml-3 sm:w-auto">
            Add User
        </button>

    <div class="container">
        <table id="manage-user-table" class="w-full">
            <thead>
                <tr>
                    <th>Name </th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Complete Address</th>
                    <th>E-Wallet</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="manage-user-container">
            </tbody>
        </table>
    </div>


    {{-- Add New User Modal --}}
    <div id="add-user-modal" class="hidden relative z-10" aria-labelledby="modal-edit-user" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-zinc-950 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div
                class=" backdrop-blur-sm flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <form method="POST" id="add-manage-user-form" enctype="multipart/form-data"
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start md:items-center justify-center">
                            <div class="sm:ml-4 sm:mt-0 sm:text-left w-full">

                                <h3 class="text-2xl font-semibold leading-6 text-gray-900 mb-4" id="modal-title">
                                    Add New User
                                </h3>
                                <div>
                                    <div class="flex flex-col gap-y-3">
                                        <label for="add-name" class="m-0">Name</label>
                                        <input type="text" id="add-name" name="add_name"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="add_email" class="m-0">Email</label>
                                        <input type="email" id="add_email" name="add_email"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="manage-password" class="m-0">Password</label>
                                        <input type="password" id="manage-password" name="password"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="add-phone-number" class="m-0">Phone Number</label>
                                        <input type="text" id="add-phone-number" name="add_phone_number"
                                            maxlength="11"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="add-address" class="m-0">Address</label>
                                        <input type="text" id="add-address" name="add_address"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="add-e-wallet" class="m-0">E-Wallet</label>
                                        <input type="text" id="add-e-wallet" name="add_e_wallet" maxlength="11"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-2 mt-3 gap-x-2 border-b-2 pb-2 border-slate-200">
                                        <label for="add-roles" class="m-0">Roles</label>
                                        <select class="outline-none" id="add-roles" name="add_roles">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="add-error-container" class="my-2 bg-red-200 mx-4">

                    </div>
                    <div class="add-new-user-btn bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="update-product-btn"
                            class="text-white w-full justify-center rounded-md bg-indigo-950 px-3 py-2 text-sm font-semibold rounded-md hover:bg-rose-600 hover:text-white hover:scale-105 shadow-lg transition duration-300 sm:ml-3 sm:w-auto">
                            Submit</button>
                        <button id="cancel-user-add-btn" type="button"
                            class="w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm hover:bg-slate-200 hover:scale-105 transition duration-300 sm:ml-3 sm:w-auto">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit User Modal --}}
    <div id="edit-user-modal" class="hidden relative z-10" aria-labelledby="modal-edit-user" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-zinc-950 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div
                class=" backdrop-blur-sm flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <form method="POST" id="edit-manage-user-form" enctype="multipart/form-data"
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start md:items-center justify-center">
                            <div class="sm:ml-4 sm:mt-0 sm:text-left w-full">

                                <h3 class="text-2xl font-semibold leading-6 text-gray-900 mb-4" id="modal-title">
                                    Update User
                                </h3>
                                <div>
                                    <div class="flex flex-col gap-y-3">
                                        <label for="manage-name" class="m-0">Name</label>
                                        <input type="text" id="manage-name" name="manage_name"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="manage-email" class="m-0">Email</label>
                                        <input type="email" id="manage-email" name="manage_email"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="phone-number" class="m-0">Phone Number</label>
                                        <input type="text" id="phone-number" name="manage_phone_number"
                                            maxlength="11"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="address" class="m-0">Address</label>
                                        <input type="text" id="address" name="manage_address"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="e-wallet" class="m-0">E-Wallet</label>
                                        <input type="text" id="e-wallet" name="e_wallet" maxlength="11"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-2 mt-3 gap-x-2 border-b-2 pb-2 border-slate-200">
                                        <label for="roles" class="m-0">Roles</label>
                                        <select class="outline-none" id="roles" name="roles">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->display_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex flex-col gap-y-2 mt-3 gap-x-2 border-b-2 pb-2 border-slate-200">
                                        <label for="edit-status" class="m-0">Status</label>
                                        <select class="outline-none" id="edit-status" name="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="edit-error-container" class="my-2 bg-red-200 mx-4">

                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="update-product-btn"
                            class="text-white w-full justify-center rounded-md bg-indigo-950 px-3 py-2 text-sm font-semibold rounded-md hover:bg-rose-600 hover:text-white hover:scale-105 shadow-lg transition duration-300 sm:ml-3 sm:w-auto">
                            Update</button>
                        <button id="cancel-manage-user-btn" type="button"
                            class="w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm hover:bg-slate-200 hover:scale-105 transition duration-300 sm:ml-3 sm:w-auto">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(() => {
        new DataTable('#manage-user-table');

        function renderTable(responseData) {
            if ($.fn.DataTable.isDataTable('#manage-user-table')) {
                $('#manage-user-table').DataTable().destroy();
            }

            $('#manage-user-table').DataTable({
                data: responseData,
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone_number'
                    },
                    {
                        data: 'complete_address'
                    },
                    {
                        data: 'e_wallet'
                    },
                    {
                        data: null,
                        render(data, type, row) {
                            return data.roles && data.roles.length > 0 ? row.roles[0].name : 'N/A'
                        }
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button data-id="${row.id}"
                                    {{Auth::user()->hasPermission(['users-update']) ? '' : "disabled" }}
                                    class=" {{Auth::user()->hasPermission(['users-update']) ? 'hover:bg-slate-200 hover:scale-105' : "bg-gray-300 opacity-35 cursor-not-allowed" }} select-edit-manage-user-btn w-full justify-center rounded-md px-3 py-2 text-sm font-semibold shadow-sm  transition duration-300 sm:ml-3 sm:w-auto">
                                    <i class="fa-regular fa-pen-to-square text-xl"></i>
                                </button>
                            `;
                        }
                    }
                ]
            });
        }

        $.ajax({
            type: "GET",
            url: "{{ route('get.users') }}",
            success: (res) => {
                console.log("Accounts: ", res);
                renderTable(res);
            },
            error: (err) => {
                console.error(err);
            }
        });

        $('#add-user-btn').click(() => {
            $('#add-user-modal').fadeIn();
            $('#add-error-container').empty();
        });

        $('#cancel-user-add-btn').click(() => {
            $('#add-user-modal').fadeOut();
        });

        $('#add-manage-user-form').submit((e) => {
            e.preventDefault();

            const formData = new FormData($('#add-manage-user-form')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('store.users') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    $('#add-error-container').empty();
                    $('#add-user-modal').fadeOut();
                    renderTable(response);

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Added User Successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    console.log("Added successfully: ", response);
                },
                error: (err) => {
                    console.error(err);
                    const errors = err.responseJSON.errors;
                    const errorsMsg = Object.values(errors);
                    $('#add-error-container').empty();

                    errorsMsg.forEach(errMsg => {
                        $('#add-error-container').append(
                            `<p class="px-4 py-1 rounded-md">${errMsg}</p>`);
                    });
                }
            })
        })

        let userId = null;

        $(document).on('click', '.select-edit-manage-user-btn', function() {
            const id = $(this).data('id');
            $('#edit-user-modal').fadeIn();

            $.ajax({
                type: "GET",
                url: "{{ route('show.user') }}",
                data: {
                    id: id
                },
                success: (response) => {
                    $('#manage-name').val(response.name);
                    $('#manage-email').val(response.email);
                    $('#phone-number').val(response.phone_number);
                    $('#roles').val(response.roles[0].name);
                    $('#address').val(response.complete_address);
                    $('#e-wallet').val(response.e_wallet);
                    $('#edit-status').val(response.status);

                    userId = response.id;
                    console.log(response);
                },
                error: (err) => {
                    console.error(err);
                }
            });
        });

        $('#cancel-manage-user-btn').click(() => {
            $('#edit-user-modal').fadeOut();
        });

        $('#edit-manage-user-form').submit((e) => {
            e.preventDefault();

            const editFormData = new FormData($('#edit-manage-user-form')[0]);
            editFormData.append("id", userId);

            $.ajax({
                type: "POST",
                url: "{{ route('update.users') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: editFormData,
                processData: false,
                contentType: false,
                success: (response) => {
                    console.log("edit form result:", response);
                    $('#edit-error-container').empty();
                    $('#edit-user-modal').fadeOut();
                    renderTable(response);

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Updated Successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: (err) => {
                    console.error(err);
                    const errors = err.responseJSON.errors;
                    const errorsMsg = Object.values(errors);
                    $('#edit-error-container').empty();

                    errorsMsg.forEach(errMsg => {
                        $('#edit-error-container').append(
                            `<p class="px-4 py-1 rounded-md">${errMsg}</p>`);
                    });
                }
            })
        });
    });
</script>
