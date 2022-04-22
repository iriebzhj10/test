<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('assets/img/icon.png') }}" type="image/png">

         <!-- Algolia city -->
         <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0"></script>
         <script src="https://cdn.jsdelivr.net/npm/places.js@1.19.0/dist/cdn/placesAutocompleteDataset.min.js"></script>

        <!-- Ende Algolia city-->


      {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}">  --}}

        <link rel="icon" href="{{ asset('assets/img/icon.png') }}" type="image/png">
        <!-- Font Awesome 5 -->
         <link rel="stylesheet" href="{{ asset('assets/front/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
         <!-- Page CSS -->
        {{-- <link type="text/css" href="{{ asset('assets/front/libs/swiper/dist/css/swiper.min.css') }}" rel="stylesheet"> --}}

        <link rel="stylesheet" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css">
        {{-- <!-- Purpose CSS -->
        <link rel="stylesheet" href="{{asset('assets/front/css/purpose.css')}}" id="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/front/css/ac-customize.css')}}" id="stylesheet"> --}}
        {{-- dedans --}}
        {{-- <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
        <script type="application/javascript" defer src="{{ asset('assets/js/loader.js') }}"></script>
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">

        <script type="application/javascript" defer src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}" ></script>
        <script type="application/javascript" defer src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
        <script type="application/javascript" defer src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="application/javascript" defer src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }} "></script>
        <script type="application/javascript" defer src="{{ asset('assets/js/app.js') }}"></script>
        <script type="application/javascript" defer src="{{ asset('assets/js/custom.js') }}"></script>
        <script type="application/javascript" defer src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
        <script type="application/javascript" defer src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
        <script type="application/javascript" defer src="{{ asset('assets/js/dashboard/dash_1.js') }}"></script> --}}

        {{-- <link href="{{ asset('assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" /> --}}

        {{-- Fin dedans --}}

        {{-- Trendy style --}}

        <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
        <script src="assets/js/loader.js"></script>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
        <link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" class="dashboard-analytics" />
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}"> --}}
         {{-- Fin Trendy style --}}

        <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />

        <!-- style Dashboard -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">


        <link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />


  <!--  FACTURE CUSTOM STYLE FILE  -->
  {{-- <link href="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />


  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}"> --}}
  {{-- <link href="{{ asset('assets/css/apps/invoice-list.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/apps/invoice-add.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/apps/invoice-preview.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/apps/invoice-edit.css') }}" rel="stylesheet" type="text/css"> --}}

  <!--  END FACTURE STYLE FILE  -->




        <!-- style register -->
        <link href="{{ asset('assets/css/authentication/form-1.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">
        <link href="{{ asset('plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
        <link href="{{ asset('assets/css/tables/table-basic.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/dropify/dropify.min.css') }}">
        <link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
        {{-- <link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css"> --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css"> --}}
        <!-- icon link  -->
        <link rel="stylesheet" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css">

        {{-- Polices --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Spartan&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

        {{-- customize link --}}
        <link href="{{ asset('assets/css/customize.css') }}" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        @routes
        <!-- Scripts dashboa-rd -->
        @if (Route::currentRouteName()=='accueil')
            {{-- la saisie automatique --}}
            <script type="application/javascript" defer src="{{asset('assets/front/libs/typed.js/lib/typed.min.js')}}"></script>
        @endif

        <script  type="application/javascript"  src="{{ mix('js/app.js') }}" defer></script>

        <script type="application/javascript" defer src="{{ asset('js/app.js') }}"></script>


        {{-- <script type="application/javascript" defer src="{{ asset('assets/js/apps/invoice.css') }}"></script> --}}










{{-- trendy debut --}}

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script type="application/javascript" defer src="{{ asset('plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
    <script type="application/javascript" defer src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="application/javascript" defer src="{{ asset('assets/js/scrollspyNav.js') }}"></script>
    <script type="application/javascript" defer src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    <script type="application/javascript" defer src="{{ asset('plugins/select2/custom-select2.js') }}"></script>
    <script type="application/javascript" defer src="{{ asset('plugins/highlight/highlight.pack.js') }}"></script>
    {{-- SweetAlert --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
           <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- <script src="{{ asset('assets/js/custom.js') }}"></script> --}}
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/dash_1.js') }}"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
{{-- trendy fin --}}
 <script type="application/javascript" defer src="{{ asset('assets/js/custom.js') }}"></script>

 <script type="application/javascript" defer src="{{ asset('assets/js/dashboard/dash_2.js') }}"></script>
 {{-- <script type="application/javascript" defer src="{{ asset('plugins/file-upload/file-upload-with-preview.min.js') }}"></script> --}}
 <script type="application/javascript" defer src="{{ asset('js/custom.js') }}"></script>

 <script type="application/javascript" defer src="{{ asset('assets/js/authentication/form-1.js') }}"></script>
 <script type="application/javascript" defer src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
 <script type="application/javascript" defer src="{{asset('plugins/blockui/jquery.blockUI.min.js') }}"></script>
 {{-- <script type="application/javascript" defer src="{{asset('plugins/blockui/jquery.blockUI.min.js') }}"></script> --}}

 <script type="application/javascript" defer src="{{asset('plugins/dropify/dropify.min.js') }}"></script>
 <script type="application/javascript" defer src="{{asset('plugins/flatpickr/flatpickr.js') }}"></script>
 <script type="application/javascript" defer src="{{asset('plugins/flatpickr/custom-flatpickr.js') }}"></script>

<!-- facture---2 JS -->
    {{-- <script type="application/javascript" defer src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
    <script type="application/javascript" defer src="{{ asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
    <script type="application/javascript" defer src="{{ asset('assets/js/apps/invoice-list.js') }}"></script>
    <script type="application/javascript" defer src="{{asset('assets/js/apps/invoice-add.js') }}"></script>
    <script type="application/javascript" defer src="{{ asset('assets/js/apps/invoice-preview.js') }}"></script> --}}
    {{-- <script type="application/javascript" defer src="{{ asset ('assets/js/apps/invoice-edit.js') }}"></script> --}}
    {{-- <script type="application/javascript" defer src="{{ asset ('assets/js/apps/invoice.js') }}"></script> --}}



@if (Route::currentRouteName()=='accueil')
    <!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->
    <script type="application/javascript" defer src="{{asset('assets/front/js/purpose.core.js')}}"></script>
    <!-- Page JS -->
    <script type="application/javascript" defer src="{{asset('assets/front/libs/swiper/dist/js/swiper.min.js')}}"></script>
    <!-- Purpose JS -->
    <script type="application/javascript" defer src="{{asset('assets/front/js/purpose.js')}}"></script>
    <!-- Demo JS - remove it when starting your project -->
    <script type="application/javascript" defer src="{{asset('assets/front/js/demo.js')}}"></script>
@endif

  <script type="application/javascript" defer>
            $(document).ready(function() {
                App.init();
            });
        </script>

<script>
    $('#flash-overlay-modal').modal();
</script>
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])






 <!-- Scripts register -->
    </head>
    {{-- <body class="font-sans antialiased dashboard-analytics"> --}}
    <body class="font-sans antialiased dashboard-analytics bg-white">
        @inertia
    </body>
</html>
