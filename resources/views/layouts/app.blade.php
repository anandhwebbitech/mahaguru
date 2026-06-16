<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') MahaGuru</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="format-detection" content="telephone=no">
    {{-- Include CSS & Meta --}}
    @include('layouts.header-link')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Select2 main box */
        .select2-container .select2-selection--single {
            height: 45px !important;
            border: 1px solid #ced4da !important;
            border-radius: 8px !important;
            padding: 6px 10px !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Font & color */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #333 !important;
            font-size: 15px !important;
            line-height: 32px !important;
        }

        /* Arrow icon */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            right: 10px !important;
        }

        /* Placeholder styling */
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #999 !important;
        }

        /* MULTIPLE Select */
        .select2-container--default .select2-selection--multiple {
            min-height: 45px !important;
            border-radius: 8px !important;
            border: 1px solid #ced4da !important;
            padding: 4px !important;
        }

        /* Tags (multiselect items) */
        .select2-container--default .select2-selection__choice {
            background-color: #6c5ce7 !important;
            color: white !important;
            border-radius: 6px !important;
            padding: 4px 10px !important;
            margin-top: 4px !important;
            border: none !important;
        }

        /* Search field inside dropdown */
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border-radius: 6px !important;
            border: 1px solid #ced4da !important;
            padding: 6px !important;
        }

        .select2-selection__clear {
            display: none !important;
        }

        .select2-selection__arrow {
            display: none !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-selection--single {
            height: 48px !important;
            padding: 10px !important;
            display: flex !important;
            align-items: center;
        }

        .select2-selection__rendered {
            line-height: 28px !important;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.12) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }

        .glass-header {
            background: rgba(0, 123, 255, 0.4) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: white !important;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px 16px 0 0 !important;
        }

        .glass-card .form-control,
        .glass-card .select2-container .select2-selection {
            background: rgba(255, 255, 255, 0.6) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 8px 12px;
        }

        .glass-card label {
            color: #000000ff !important;
            font-weight: 600;
        }

        /*  */
    </style>

</head>

<body>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar:
                });
            @endif

        });
    </script>
    @include('layouts.header')

    {{-- Main Content --}}
    <main class="content-wrapper">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')


    {{-- jQuery MUST be before @stack --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery -->
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Load Scripts Pushed From Pages --}}
    @stack('scripts')


</body>

</html>
