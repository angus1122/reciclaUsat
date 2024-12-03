<x-guest-layout>
    <div class="custom-container">
        <x-authentication-card>
            <div class="transparent-box">
                <x-slot name="logo">
                    <div class="logo-container">
                        <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="home" class="rounded-image" />
                    </div>
                </x-slot>

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button class="ms-4">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </x-authentication-card>
    </div>

    <style>
        /* Fondo de la página */
        body {
            background-image: url('{{ asset('vendor/adminlte/dist/img/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Contenedor principal */
        .custom-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background-color: transparent;
        }

        /* Caja transparente */
        .transparent-box {
            background-color: rgb(255, 255, 255); /* Fondo blanco con transparencia */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.223);
            width: 100%;
            max-width: 400px;
        }

        /* Imagen redonda */
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .rounded-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4CAF50; /* Opcional: borde decorativo */
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.553);
        }
    </style>
</x-guest-layout>
