<div id="manage-permissions-section">
    <h1 class="text-2xl p-2 font-bold my-2">Manage Permissions</h1>
    @if (Auth::user()->hasPermission(['permissions-create']))
        <button id="user-permission-btn"
            class="text-white w-full my-2 justify-center rounded-md px-3 py-2 text-sm font-semibold rounded-md bg-indigo-950 hover:bg-rose-600 hover:text-white hover:scale-105 shadow-md transition duration-300 sm:ml-3 sm:w-auto">Add
            Privilege
        </button>
    @endif
    <div class="container">
        <table id="manage-permissions-table" class="w-full">
            <thead>
                @if (Auth::user()->hasPermission(['permissions-create']))
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th>Privilege</th>
                        <th>Actions</th>
                    </tr>
                @endif
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="manage-permissions-error-container"></div>
    </div>

    {{-- Add Permission Modal --}}
    <div id="add-permission-modal" class="hidden relative z-10" aria-labelledby="modal-edit-user" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-zinc-950 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div
                class=" backdrop-blur-sm flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <form method="POST" id="add-permission-form" enctype="multipart/form-data"
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start md:items-center justify-center">
                            <div class="sm:ml-4 sm:mt-0 sm:text-left w-full">

                                <h3 class="text-2xl font-semibold leading-6 text-gray-900 mb-4" id="modal-title">
                                    Add Privilege
                                </h3>
                                <div>
                                    <div class="flex flex-col gap-y-3">
                                        <label for="permission-name" class="m-0">Name</label>
                                        <input type="text" id="permission-name" name="name"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="permission-display-name" class="m-0">Display Name</label>
                                        <input type="text" id="permission-display-name" name="display_name"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="permission-description" class="m-0">Description</label>
                                        <textarea type="text" id="permission-description" name="description"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                        </textarea>
                                    </div>
                                    <fieldset class="flex flex-col gap-y-4">
                                        <legend class="text-sm py-3">Permission</legend>
                                        <div class="grid grid-rows-4 grid-flow-col gap-4">
                                            @foreach ($permissions as $permission)
                                                <div class="flex items-center gap-x-2">
                                                    <input type="checkbox" id="{{ $permission->name }}"
                                                        name="permissions[]" value="{{ $permission->id }}">
                                                    <label for="{{ $permission->name }}"
                                                        class="m-0">{{ $permission->display_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="privilege-error-container" class="my-2 bg-red-200 mx-4">

                    </div>
                    <div class="add-new-user-btn bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="permission-submit-btn"
                            class="text-white w-full justify-center rounded-md bg-indigo-950 px-3 py-2 text-sm font-semibold rounded-md hover:bg-rose-600 hover:text-white hover:scale-105 shadow-lg transition duration-300 sm:ml-3 sm:w-auto">
                            Submit</button>
                        <button id="cancel-permission-btn" type="button"
                            class="w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm hover:bg-slate-200 hover:scale-105 transition duration-300 sm:ml-3 sm:w-auto">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Permission Modal --}}
    <div id="edit-permission-modal" class="hidden relative z-10" aria-labelledby="modal-edit-user" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-zinc-950 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div
                class=" backdrop-blur-sm flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <form method="POST" id="edit-permission-form" enctype="multipart/form-data"
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start md:items-center justify-center">
                            <div class="sm:ml-4 sm:mt-0 sm:text-left w-full">

                                <h3 class="text-2xl font-semibold leading-6 text-gray-900 mb-4" id="modal-title">
                                    Edit Privilege
                                </h3>
                                <div>
                                    <div class="flex flex-col gap-y-3">
                                        <label for="edit-permission-name" class="m-0">Name</label>
                                        <input type="text" id="edit-permission-name" name="name"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="edit-permission-display-name" class="m-0">Display Name</label>
                                        <input type="text" id="edit-permission-display-name" name="display_name"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                    </div>
                                    <div class="flex flex-col gap-y-3 mt-3">
                                        <label for="edit-permission-description" class="m-0">Description</label>
                                        <textarea type="text" id="edit-permission-description" name="description"
                                            class="w-full p-2 rounded-md outline-none ring focus:ring-blue-500 shadow-md">
                                        </textarea>
                                    </div>
                                    <fieldset class="flex flex-col gap-y-4">
                                        <legend class="text-sm py-3">Permission</legend>
                                        <div class="grid grid-rows-4 grid-flow-col gap-4">
                                            @foreach ($permissions as $permission)
                                                <div class="flex items-center gap-x-2">
                                                    <input type="checkbox" id="edit-{{ $permission->name }}"
                                                        name="edit_permissions[]" value="{{ $permission->id }}">
                                                    <label for="edit-{{ $permission->name }}"
                                                        class="m-0">{{ $permission->display_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="edit-privilege-error-container" class="my-2 bg-red-200 mx-4">

                    </div>
                    <div class="add-new-user-btn bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button id="permission-update-btn"
                            class="text-white w-full justify-center rounded-md bg-indigo-950 px-3 py-2 text-sm font-semibold rounded-md hover:bg-rose-600 hover:text-white hover:scale-105 shadow-lg transition duration-300 sm:ml-3 sm:w-auto">
                            Update</button>
                        <button id="cancel-edit-permission-btn" type="button"
                            class="w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm hover:bg-slate-200 hover:scale-105 transition duration-300 sm:ml-3 sm:w-auto">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(() => {

        function renderTable(responseData) {
            if ($.fn.DataTable.isDataTable('#manage-permissions-table')) {
                $('#manage-permissions-table').DataTable().destroy();
            }

            $('#manage-permissions-table').DataTable({
                data: responseData,
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'display_name'
                    },
                    {
                        data: 'description'

                    },
                    {
                        data: null,
                        render: function(__, __, row) {
                            return row.permissions.map(permission => permission
                                .name);
                        }
                    },
                    {
                        data: null,
                        render: function(__, __, row) {
                            return `
                            
                                <button 
                                    data-id="${row.id}" 
                                    {{Auth::user()->hasPermission(['permissions-update']) ? '' : "disabled" }}
                                    class=" {{Auth::user()->hasPermission(['permissions-update']) ? 'hover:bg-slate-200 hover:scale-105' : "bg-gray-300 opacity-35 cursor-not-allowed" }} select-edit-permission-btn w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm transition duration-300 sm:ml-3 sm:w-auto">
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
            url: "{{ route('get.permissions') }}",
            success: (response) => {
                console.log(response);
                new DataTable('#manage-permissions-table');
                $('#manage-permissions-error-container').empty();
                renderTable(response);
            },
            error: (err) => {
                console.error(err);
                $('#manage-permissions-error-container').append(`
                     <div>
                        <p class="text-rose-500 text-lg text-center font-bold mt-10"> 403 (Forbidden) ${err.responseJSON.message}</p>
                        <p class="text-rose-500 text-base text-center font-bold">Contact your Super Admin to gain access to this data.</p>
                    </div>
                `);
            }
        });

        $("#user-permission-btn").click(() => {
            $("input[type='checkbox']").prop("checked", false);
            $('#add-permission-modal').fadeIn();
        });

        $('#cancel-permission-btn').click(() => {
            $('#privilege-error-container').empty();
            $('#add-permission-modal').fadeOut();
        });

        $('#add-permission-form').submit((e) => {
            e.preventDefault();

            const formData = new FormData($('#add-permission-form')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('store.permissions') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    console.log(response);
                    $('#privilege-error-container').empty();
                    $('#add-permission-modal').fadeOut();
                    renderTable(response);

                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Added Successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: (err) => {
                    console.error(err);
                    const errors = err.responseJSON.errors;
                    const errorsMsg = Object.values(errors);
                    $('#privilege-error-container').empty();

                    errorsMsg.forEach(errMsg => {
                        $('#privilege-error-container').append(
                            `<p class="px-4 py-1 rounded-md">${errMsg}</p>`);
                    });
                }
            });

        })

        let newRoleId = null;

        $(document).on('click', '.select-edit-permission-btn', function() {
            $("#edit-permission-modal").fadeIn();
            const roleid = $(this).data('id');
            newRoleId = roleid;
            console.log(roleid);

            $.ajax({
                type: "GET",
                url: "{{ route('show.permissions') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: roleid
                },
                success: (response) => {
                    console.log("role selected result:", response);

                    $("#edit-permission-name").val(response.name);
                    $("#edit-permission-display-name").val(response.display_name);
                    $("#edit-permission-description").val(response.display_name);

                    const permissions = response.permissions;

                    $("input[type='checkbox']").prop("checked", false);

                    permissions.forEach(permission => {
                        // Check the checkbox that matches the permission id
                        $(`input[type='checkbox'][value='${permission.id}']`).prop(
                            "checked", true);
                    });
                },
                error: (err) => {
                    console.error(err);
                }
            });
        });

        $("#cancel-edit-permission-btn").click(() => {
            $('#edit-privilege-error-container').empty();
            $("#edit-permission-modal").fadeOut();
        });

        $('#edit-permission-form').submit((e) => {
            e.preventDefault();

            const editFormData = new FormData($('#edit-permission-form')[0]);
            editFormData.append('id', newRoleId);

            $.ajax({
                type: "POST",
                url: "{{ route('update.permissions') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: editFormData,
                processData: false,
                contentType: false,
                success: (response) => {
                    console.log(response);
                    $('#edit-privilege-error-container').empty();
                    $("#edit-permission-modal").fadeOut();
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
                    $('#edit-privilege-error-container').empty();

                    errorsMsg.forEach(errMsg => {
                        $('#edit-privilege-error-container').append(
                            `<p class="px-4 py-1 rounded-md">${errMsg}</p>`);
                    });
                }
            });
        });
    })
</script>
