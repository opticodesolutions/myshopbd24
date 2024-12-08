<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    @include('includes.head')
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        @include('includes.sidebar')
        <div class="main">
            @include('includes.topbar')
            @yield('content')
            @include('includes.footer')
        </div>
    </div>
    <!-- IziToast -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                iziToast.success({
                    title: 'Success',
                    message: "{{ session('success') }}",
                    position: 'topRight'
                });
            @endif

            @if (session('error'))
                iziToast.error({
                    title: 'Error',
                    message: "{{ session('error') }}",
                    position: 'topRight'
                });
            @endif
        });
    </script>
    </script>

    <!-- IziToast JS -->
    <script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>

    <script src="{{ asset('backend/js/app.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            setTimeout(function() {
                if (localStorage.getItem('popState') !== 'shown') {
                    window.notyf.open({
                        type: "success",
                        message: "Welcome! 🚀",
                        duration: 10000,
                        ripple: true,
                        dismissible: false,
                        position: {
                            x: "left",
                            y: "bottom"
                        }
                    });

                    localStorage.setItem('popState', 'shown');
                }
            }, 15000);
        });
    </script>
</body>

</html>
