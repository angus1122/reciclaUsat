<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="logo-container">
        {{ $logo }}
    </div>

    <div class="content-container w-full sm:max-w-md mt-6 px-6 py-4">
        {{ $slot }}
    </div>

    <style>
        /* Fondo general de la página */
        body {
            background-image: url('{{ asset('vendor/adminlte/dist/img/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }


        /* Contenedor principal */
        .min-h-screen {
            background-color: transparent;
            /* Fondo completamente transparente */
        }

        /* Contenedor del logo */
        .logo-container {
            background: none;
            /* Sin fondo */
            border: none;
            /* Sin borde */
        }

        /* Contenedor del contenido */
        .content-container {
            background-color: rgba(255, 255, 255, 0.333);
            /* Fondo blanco semi-transparente */
            border-radius: 10px;
            /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Sombra ligera */
            padding: 20px;
            /* Espaciado interno */
        }
    </style>
</div>
