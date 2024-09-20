let newid = null;

$('document').ready(() => {
    let table = new DataTable('#myTable');
    
    $('#add-product-btn').click(() => {
        $("#add-product-modal").fadeToggle();
    })

    $('#cancel-product-btn').click(() => {
        $("#add-product-modal").fadeOut();
    })

    $('#add-product-form').submit((e) => {
        e.preventDefault();

        const formData = new FormData($('#add-product-form')[0]);

        $.ajax({
            type: "POST",
            url: '/home/products',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: (response) => {

                reRender(response);
                $('#total-products').text(`Total Products: ${response.length}`);
                $('#error-form-container').empty();
                $("#add-product-modal").fadeOut();
                console.log(response);


                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "You Product has been inserted",
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: (err) => {
                const errors = err.responseJSON.errors;
                console.error(err);
                const errorsMsg = Object.values(errors);
                $('#error-form-container').empty();

                errorsMsg.forEach(errMsg => {
                    $('#error-form-container').append(`<p class="px-4 py-1 rounded-md">${errMsg}</p>`);
                });
            }
        });
    })

    $("#edit-product-form").submit((e) => {
        e.preventDefault();

        const editformData = new FormData($('#edit-product-form')[0]);

        $.ajax({
            type: "POST",
            url: `/home/products/update-form/${newid}`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: editformData,
            processData: false,
            contentType: false,
            success: (response) => {
                $("#edit-product-modal").fadeOut();
                $('#edit-error-form-container').empty();
                console.log("update result:", response);
                reRender(response);

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "You Product has been updated",
                    showConfirmButton: false,
                    timer: 1500
                });

            },
            error: (err) => {
                const errors = err.responseJSON.errors;
                const errorsMsg = Object.values(errors);
                $('#edit-error-form-container').empty();

                errorsMsg.forEach(errMsg => {
                    $('#edit-error-form-container').append(`<p class="px-4 py-1 rounded-md">${errMsg}</p>`);
                });
            }
        });
    });

    $("#cancel-edit-product-btn").click(() => {
        $("#edit-product-modal").fadeOut();
    })

    $(document).on('click', '.select-edit-product-btn', function () {
        $("#edit-product-modal").fadeToggle();
        const id = $(this).data('id');  // Use .data() to get the data-id attribute
        newid = id;
    
        console.log("Clicked button with ID:", id, "Updated ID:", newid);
        selectProduct(id);
    });

    $(document).on('change', '.check', function () {
        const $checkbox = $(this);
        const checkboxId = $checkbox.attr("id");
        const isChecked = $checkbox.is(":checked");

        console.log("Checkbox ID:", checkboxId);
        console.log("Checked status:", isChecked);

        Swal.fire({
            title: "Are you sure you want to delete?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: '/home/products/delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { id: checkboxId },
                    success: (res) => {
                        reRender(res);
                    },
                    error: (err) => {
                        console.error(err);
                    }
                });

                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            } else {
                $checkbox.prop("checked", false);
            }
        });
    });

})


function reRender(responseData) {
    if ($.fn.DataTable.isDataTable('#myTable')) {
        $('#myTable').DataTable().destroy();
    }

    $('#myTable').DataTable({
        data: responseData,
        columns: [
            {
                data: 'product_name',
                render: function (data, type, row) {
                    return `
                        @if(Auth::user()->hasPermission(['products-delete']))
                            <input type="checkbox" class="check cursor-pointer" id="${row.id}">
                        @endif
                        <label for="${row.id}" class="{{Auth::user()->hasPermission(['products-delete']) ? 'cursor-pointer' : '' }}">${data}</label>
                    `;
                }
            },
            {
                data: 'description'
            },
            {
                data: 'picture',
                render: function (data, type, row) {
                    return `<img src="/storage/images/${data}" alt="${data}" class="image">`;
                }
            },
            {
                data: 'stocks'
            },
            {
                data: 'price'
            },
            {
                data: 'status'
            },
            {
                data: null,
                render: function (__, __, row) {
                    return `
                        <button 
                            data-id="${row.id}" 
                            {{Auth::user()->hasPermission(['products-update']) ? '' : "disabled" }}
                            class=" {{Auth::user()->hasPermission(['products-update']) ? 'hover:bg-slate-200 hover:scale-105' : "bg-gray-300 opacity-35 cursor-not-allowed" }} select-edit-product-btn w-full justify-center rounded-md bg-slate-50 px-3 py-2 text-sm font-semibold shadow-sm transition duration-300 sm:ml-3 sm:w-auto">
                                <i class="fa-regular fa-pen-to-square text-xl"></i>
                        </button>
                    `;
                }
            }
        ]
    });
}

function selectProduct(id) {
    $.ajax({
        type: "GET",
        url: `/home/products/${id}`,
        success: (res) => {
            console.log("selected:", res);

            $("#edit-product-name").val(res.product_name);
            $("#edit-description").val(res.description);
            $("#edit-price").val(res.price);
            $("#edit-category").val(res.category);
            $("#edit-status").val(res.status);
            $("input[name='edit-stocks'][value='" + res.stocks + "']").prop('checked', true);

            const pictureInput = $("#edit-picture");
            const picturePreview = $('#picture-preview');
            
            if (picturePreview.length) {
                picturePreview.attr('src', `/storage/images/${res.picture}`);
            } else {
                pictureInput.after(`<img id="picture-preview" src="/storage/images/${res.picture}" alt="Product Picture" class="image-preview" style="max-width: 120px;"/>`);
            }
        },
        error: (err) => {
            console.error(err);
        }
    });
}