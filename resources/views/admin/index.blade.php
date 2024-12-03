@extends('adminlte::page')

@section('title', 'ReciclaUSAT')

@section('content_header')
    {{-- <h1>ReciclaUSAT</h1> --}}
@stop

@section('content')
    <div class="background-image">
        <div class="content-container">
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Columna para la imagen (a la izquierda) con la línea vertical en la derecha -->
                    <div class="col-md-4 text-center border-right-custom">
                        <img src="{{ asset('vendor/adminlte/dist/img/homeMPCH.png') }}" alt="ReciclaUSAT Image"
                            class="img-fluid rounded">
                    </div>
                    <!-- Columna para el texto (a la derecha) -->
                    <div class="col-md-8 text-left ">
                        <br>
                        <h1><strong>ReciclaUSAT</strong></h1>
                        <h3><strong>MUNICIPALIDAD DISTRITAL DE CHICLAYO</strong></h3><br>
                    </div>
                </div>
                <!-- Texto centrado -->
                <div class="text-center">
                    <br>
                    <h2><strong>#JuntosSaldremosAdelante</strong></h2>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilo para la imagen de fondo con capa de opacidad */
        .background-image {
            position: relative;
            /* Necesario para el pseudo-elemento */
            background-image: url('{{ asset('vendor/adminlte/dist/img/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Pseudo-elemento para la capa opaca sobre la imagen de fondo */
        .background-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.4);
            /* Fondo blanco con 40% de opacidad */
            z-index: 1;
            /* Asegura que la capa esté encima de la imagen */
        }

        /* Contenedor del contenido */
        .content-container {
            position: relative;
            z-index: 2;
            /* Asegura que el contenido esté por encima de la capa opaca */
            padding: 20px;
            border-radius: 10px;
            max-width: 1000px;
        }

        /* Cambiar la tipografía a Arial Black solo para esta vista */
        .custom-font,
        .custom-font h1,
        .custom-font h5,
        .custom-font p,
        .custom-font ul,
        .custom-font li {
            font-family: 'Arial Black', Arial, sans-serif;
        }

        /* Ajustes del texto */
        .custom-font ul {
            list-style-type: none;
            padding: 0;
        }

        .custom-font ul li {
            margin-bottom: 5px;
        }

        /* Hacer la imagen más pequeña, limitando su ancho */
        .img-fluid {
            max-width: 70%;
            /* Ajusté el tamaño de la imagen al 80% del contenedor */
            height: auto;
        }

        /* Asegurarse de que el fondo del texto sea transparente */
        .card-body {
            background-color: transparent;
        }

        /* Espaciado entre las columnas */
        .row {
            display: flex;
            align-items: center;
        }

        .col-md-8 {
            padding-left: 40px;
        }


        /* Centrar el texto en el div para #JuntosSaldremosAdelante */
        .text-center {
            text-align: center;
            width: 100%;
            /* Asegura que el div ocupe todo el ancho disponible */
        }

        /* Aumentar el tamaño de la fuente de ReciclaUSAT */
        h1 strong {
            font-size: 5rem;
            /* Cambié el tamaño a 5rem */
        }

        .text-center h2 {
            font-size: 3rem;
            /* Ajusté el tamaño para que sea más grande */
        }

        /* Estilo para agregar la línea vertical a la derecha del div con la imagen */
        .border-right-custom {
            border-right: 2px solid rgb(12, 12, 12);
            /* Borde derecho de 10px y color rojo */
            height: 100%;
            /* Asegura que el borde cubra toda la altura del div */
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@stop
