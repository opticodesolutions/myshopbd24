<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.includes.head')
</head>

   <body>
      <!-- navbar -->
      @include('frontend.includes.nav')

      <!-- Shop Cart -->
      @include('frontend.includes.cart')

      <main>
         @yield('content')
      </main>
      <!-- footer -->
      @include('frontend.includes.footer')

      <!-- Javascript-->

      <!-- Libs JS -->
      <!-- <script src="./assets/libs/jquery/dist/jquery.min.js"></script> -->
      <script src="{{ asset('frontend/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('frontend/assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

      <!-- Theme JS -->
      <script src="{{ asset('frontend/assets/js/theme.min.js') }}"></script>

      <script src="{{ asset('frontend/assets/js/vendors/jquery.min.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/vendors/countdown.js') }}"></script>
      <script src="{{ asset('frontend/assets/libs/slick-carousel/slick/slick.min.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/vendors/slick-slider.js') }}"></script>
      <script src="{{ asset('frontend/assets/libs/tiny-slider/dist/min/tiny-slider.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/vendors/tns-slider.js') }}"></script>
      <script src="{{ asset('frontend/assets/js/vendors/zoom.js') }}"></script>
   </body>
</html>
