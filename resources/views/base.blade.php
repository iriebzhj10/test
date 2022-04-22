<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Accueil</title>
    <link rel="icon" href="{{ asset('assets/img/icon.png') }}" type="image/png">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ asset('assets/front/libs/@fortawesome/fontawesome-free/css/all.min.css') }}"><!-- Page CSS -->
    <link type="text/css" href="{{ asset('assets/front/libs/swiper/dist/css/swiper.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://allyoucan.cloud/cdn/icofont/1.0.1/icofont.css">
    <!-- Purpose CSS -->
    <link rel="stylesheet" href="{{asset('assets/front/css/purpose.css')}}" id="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/front/css/ac-customize.css')}}">

</head>
<body>

    @include('layout.header')

    @yield('accueil')

    @include('layout.footer')

<!-- Core JS - includes jquery, bootstrap, popper, in-view and sticky-kit -->
<script src="{{asset('assets/front/js/purpose.core.js')}}"></script>
<!-- Page JS -->
<script src="{{asset('assets/front/libs/swiper/dist/js/swiper.min.js')}}"></script>
<!-- Purpose JS -->
<script src="{{asset('assets/front/js/purpose.js')}}"></script>
<!-- Demo JS - remove it when starting your project -->
<script src="{{asset('assets/front/js/demo.js')}}"></script>

{{-- la saisie automatique --}}
<script src="{{asset('assets/front/libs/typed.js/lib/typed.min.js')}}"></script>
<!-- Purpose JS -->
<script src="{{asset('assets/front/js/purpose.js')}}"></script>

<script>
    $('#flash-overlay-modal').modal();
</script>
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

</body>
</html>
