<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>

    <title>J&G</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="icon" href="http://example.com/favicon.png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-indigo-950">
    <div class="flex-center position-ref full-height">
        <main>
            {{-- Login Form --}}
            <div id="backdrop-login" class=" relative z-10" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">
                <div class="fixed inset-0 bg-gray-500/50  backdrop-blur-md bg-opacity-75 transition-opacity"
                    aria-hidden="true"> </div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8  sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 py-5 sm:p-6 sm:pb-4 h-full">
                                <div class="text-3xl font-bold text-center">{{ __('Login') }}</div>

                                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-y-4">
                                    @csrf

                                    <label for="email"
                                        class="text-lg font-medium m-0">{{ __('E-Mail Address') }}</label>

                                    <div class="">
                                        <input id="email" type="email"
                                            class="w-full p-4 rounded-md outline-none ring ring-indigo-300 focus:ring-indigo-800 shadow-md @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            autofocus>

                                        @error('email')
                                            <span class="text-red-500" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="password" class="text-lg font-medium">{{ __('Password') }}</label>

                                    <div>
                                        <input id="password" type="password"
                                            class="w-full p-4 rounded-md outline-none ring ring-indigo-300 focus:ring-indigo-800 shadow-md @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="text-red-500" role="alert">
                                                <strong>{{ $message }} </strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="flex items-center gap-x-2">
                                        <input class="" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="font-medium  m-0" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    <div class="flex flex-col gap-y-6">
                                        <button type="submit"
                                            class="w-full bg-indigo-800 p-3 rounded-full text-white hover:bg-indigo-950/90 transition-all duration-300">
                                            {{ __('Login') }}
                                        </button>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label for="password" class="text-lg font-medium text-center">Don't have an
                                            Account?</label>

                                        <button type="button" id="create-acc-btn"
                                            class="text-indigo-800 hover:underline mb-5">
                                            Create Account
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            {{-- Register Form --}}
            <div id="backdrop-register" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">
                <div class="fixed inset-0 bg-gray-500 backdrop-blur-lg bg-opacity-75 transition-opacity"
                    aria-hidden="true">
                </div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div id="login-modal-content"
                            class="relative transform overflow-hidden rounded-lg text-left shadow-xl transition-all sm:my-8  sm:w-full sm:max-w-lg">
                            <div class="bg-white px-4 pb-4 py-5 sm:p-6 sm:pb-4 h-full">
                                <h1 class="text-3xl font-bold text-center">Sign Up</h1>

                                <form method="POST" action="{{ route('register') }}"
                                    class="flex flex-col gap-y-4 h-full">
                                    @csrf

                                    <label for="name" class="text-lg font-medium m-0">Full
                                        Name</label>
                                    <div>
                                        <input id="name" type="text"
                                            class="w-full p-2 rounded-md outline-none ring ring-indigo-300 focus:ring-indigo-800 shadow-md @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" autocomplete="name" required
                                            autofocus>

                                        @error('name')
                                            <span class="text-red-500" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="phone-number" class="text-lg font-medium m-0">Phone
                                        Number</label>
                                    <div>
                                        <input id="phone-number" type="text"
                                            class="w-full p-2 rounded-md outline-none ring ring-indigo-300 focus:ring-indigo-800 shadow-md @error('phone_number') is-invalid @enderror"
                                            name="phone_number" value="{{ old('phone_number') }}" maxlength="11"
                                            autocomplete="tel" required>

                                        @error('phone_number')
                                            <span class="text-red-500" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="create-email" class="text-lg font-medium m-0">Email
                                        Address</label>
                                    <div>
                                        <input id="create-email" type="email"
                                            class="w-full p-2 rounded-md outline-none ring ring-indigo-300 focus:ring-indigo-800 shadow-md @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" autocomplete="email"
                                            required>

                                        @error('email')
                                            <span class='text-red-500' role='alert'>
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="complete-address" class="text-lg font-medium m-0">Complete
                                        Address</label>
                                    <div>
                                        <input id="complete-address" type="text"
                                            class="w-full p-2 rounded-md outline-none ring ring-indigo-300 focus:ring-indigo-800 shadow-md @error('complete_address') is-invalid @enderror"
                                            name="complete_address" value="{{ old('complete_address') }}"
                                            autocomplete="address" required>

                                        @error('complete_address')
                                            <span class='text-red-500' role='alert'>
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="e-wallet" class="text-lg font-medium m-0">E-Wallet
                                        Account
                                        Number</label>
                                    <div>
                                        <input id="e-wallet" type="text"
                                            class="w-full p-2 rounded-md outline-none ring ring-indigo-300 focus:ring-indigo-800 shadow-md @error('e_wallet') is-invalid @enderror"
                                            name="e_wallet" value="{{ old('e_wallet') }}" autocomplete="e_wallet"
                                            maxlength="11">

                                        @error('e_wallet')
                                            <span class='text-red-500' role='alert'>
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <label for="create-password"
                                        class="text-lg font-medium">{{ __('Password') }}</label>
                                    <div>
                                        <input id="create-password" type="password"
                                            class="w-full p-2 rounded-md outline-none ring ring-indigo-300 focus:ring-indigo-800 @error('create_password') is-invalid @enderror"
                                            name="create_password" autocomplete="new-password" required>

                                        @error('create_password')
                                            <span class="text-red-500" role="alert">
                                                <strong>{{ $message }}
                                                    and contain 1 lowercase, uppercase, number and special character (@$!%*?&).
                                                </strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="flex flex-col gap-y-6">
                                        <button type="submit"
                                            class="w-full bg-indigo-800 p-3 rounded-full text-white hover:bg-indigo-950/90 transition-all duration-300 mt-2">
                                            {{ __('Register') }}
                                        </button>

                                        <div class="flex flex-col gap-2">
                                            <label class="font-medium text-center">Already have an account?</label>
                                            <button type="button" id="sign-in-btn" class="text-indigo-800 hover:underline">
                                                Sign in
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        $('document').ready(() => {

            $("#sign-in-btn").click(() => {
                $("#backdrop-register").fadeOut();
                $('#backdrop-login').toggle();
            })

            $("#create-acc-btn").click(() => {
                $('#backdrop-login').fadeOut();
                $("#backdrop-register").fadeToggle();
            })
        })
    </script>
</body>

</html>
