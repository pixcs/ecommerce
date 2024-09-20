@section('admin')
    <section class="grid grid-cols-8 h-screen">

        <div class="flex flex-col justify-start col-span-2 border-r-2 bg-gray-800 text-white">
            <div
                class="sm:w-[100px] sm:h-[100px] lg:w-[150px] lg:h-[150px] rounded-full bg-rose-600 text-white mx-auto border-2 border-indigo-950 my-[50px]">
                <h3 class="font-bold text-center sm:text-xl lg:text-wxl md:mt-8 lg:mt-14">
                    @if (Auth::user()->hasRole('super administrator'))
                        Super Admin
                    @endif
                    @if (Auth::user()->hasRole('administrator'))
                        Admin
                    @endif
                </h3>
            </div>

            <button id="dashboard-btn"
                class="font-medium h-20 hover:bg-indigo-900 hover:text-white hover:text-lg transition-all duration-300 flex justify-center place-items-center">
                Dashboard
            </button>
            <button id="products-btn"
                class="font-medium h-20 hover:bg-indigo-900 hover:text-white hover:text-lg transition-all duration-300 flex justify-center place-items-center">
                Products
            </button>
            <button id="orders-btn"
                class="font-medium h-20 hover:bg-indigo-900 hover:text-white hover:text-lg transition-all duration-300 flex justify-center place-items-center">
                Orders
            </button>
            <button id="manage-user-btn"
                class="font-medium h-20 hover:bg-indigo-900 hover:text-white hover:text-lg transition-all duration-300 flex justify-center place-items-center">
                Manage User
            </button>
            <button id="manage-permissions-btn"
                class="font-medium h-20 hover:bg-indigo-900 hover:text-white hover:text-lg transition-all duration-300 flex justify-center place-items-center">
                Manage Permissions
            </button>
            <button id="logout"
                class="font-medium h-20 hover:bg-indigo-900 hover:text-white hover:text-lg transition-all duration-300">
                {{ __('Logout') }}
            </button>
        </div>

        <div class="col-span-6">
            <div class="h-[100px]  bg-indigo-950 flex items-center justify-between">
                <div class="px-10">
                    <h2 class="text-lg font-bold text-white">{{ Auth::user()->name }}</h2>
                    <h3 class="text-xs text-white">{{ Auth::user()->email }}</h3>
                </div>
                <i
                    class="fa-solid fa-bell text-3xl mr-10 cursor-pointer text-white hover:scale-110 transition-all duration-300"></i>
            </div>

            @include('admin-section.dashboard')
            @include('admin-section.products')
            @include('admin-section.orders')
            @include('admin-section.manage-user')
            @include('admin-section.manage-permissions')

        </div>

    </section>

    <script>
        function showSection(sectionId, buttonId) {
            $("#dashboard-section, #products-section, #orders-section, #manage-user-section, #manage-permissions-section")
                .hide();
            $(sectionId).show();

            $("#dashboard-btn, #products-btn, #orders-btn, #manage-user-btn, #manage-permissions-btn").removeClass(
                "bg-indigo-900 text-white text-lg font-bold"
            );
            $(buttonId).addClass("bg-indigo-900 text-white text-lg font-bold");
        }

        $(document).ready(() => {
            showSection("#dashboard-section", "#dashboard-btn");
        });

        $("#dashboard-btn").click(() => showSection("#dashboard-section", "#dashboard-btn"));
        $('#products-btn').click(() => showSection("#products-section", "#products-btn"));
        $('#orders-btn').click(() => showSection("#orders-section", "#orders-btn"));
        $('#manage-user-btn').click(() => showSection("#manage-user-section", "#manage-user-btn"));
        $('#manage-permissions-btn').click(() => showSection('#manage-permissions-section', '#manage-permissions-btn'));

        $('#logout').click((e) => {
            Swal.fire({
                title: "Are you sure you want to logout?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    e.preventDefault();
                    document.getElementById('logout-form').submit();
                }
            });
        })
    </script>
@endsection
