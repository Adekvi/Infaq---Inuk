<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin.template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../admin/"
  data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Verifikasi Kode Otp!</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('landing/img/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('landing/img/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('admin/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('admin/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('admin/js/config.js') }}"></script>
  </head>

  <body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
          <div class="authentication-inner">
            <!-- Register Card -->
            <div class="card">
              <div class="card-body">
                <!-- /Logo -->
                <h4 class="mb-2">Verifikasi Nomor Telepon!</h4>
                <p class="text-dark mb-6 text-sm">
                    Masukkan kode OTP yang dikirim ke nomor Anda:
                    <strong class="text-dark">{{ $user->no_hp ?? 'Nomor tidak ditemukan' }}</strong>
                </p>
                <hr>

                <!-- Error Alert -->
        <div class="mb-4">
            @if (session('error'))
<div class="text-danger text-sm">
                    {{ session('error') }}
                </div>
@endif
        </div>

        <!-- Success Alert -->
        <div class="mb-4">
            @if (session('success'))
<div class="text-success text-sm">
                    {{ session('success') }}
                </div>
@endif
        </div>
    
                <form id="formAuthentication" class="mb-3" action="{{ route('verify.otp.submit') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div>
                    @if (isset($user))
<strong class="text-dark">No. Hp: {{ $user->no_hp ?? 'Nomor tidak ditemukan' }}</strong>
@else
<strong class="text-danger">User tidak ditemukan</strong>
@endif
                </div>
    
                <input type="hidden" name="user_id" value="{{ $user_id }}" />
                <input type="hidden" name="no_hp" value="{{ $user->no_hp ?? '' }}" />
    
                <div>
                    <input type="text" name="otp" placeholder="Masukkan Kode OTP" required
                        class="form-control" />
                </div>
    
                <div class="mt-3">
                    <button type="submit"
                    class="btn btn-primary d-grid w-100">
                    Verifikasi
                </button>
                </div>
                </form>
              </div>
            </div>
            <!-- Register Card -->
          </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('admin/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('admin/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('admin/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

</body>
</html>
