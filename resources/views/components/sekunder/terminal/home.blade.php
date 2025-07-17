<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <x-sekunder.bagian.css />
    @stack('css')

</head>

<body>

    {{-- <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End --> --}}

    <!-- Topbar Start -->
    <x-sekunder.bagian.topbar />
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <x-sekunder.bagian.nav />
    <!-- Navbar & Hero End -->

    {{-- Content --}}
    <div class="container">
        {{ $slot }}
    </div>

    <!-- Footer Start -->
    <x-sekunder.bagian.footer />
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    @stack('js')
    <x-sekunder.bagian.js />

</body>

</html>
