<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Панель управления')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        
        /* Modal Transition */
        .modal-enter {
            opacity: 0;
            transform: scale(0.95);
        }
        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 200ms ease-out, transform 200ms ease-out;
        }
        .modal-leave {
            opacity: 1;
            transform: scale(1);
        }
        .modal-leave-active {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 150ms ease-in, transform 150ms ease-in;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800">

    <!-- Top Navigation -->
    @include('manager.partials.navbar')

    <!-- Main Content -->
    <main class="p-4 md:p-8 max-w-7xl mx-auto space-y-6">
        @yield('content')
    </main>

    <!-- Modals -->
    @stack('modals')

    <!-- JavaScript -->
    @stack('scripts')
</body>
</html>
