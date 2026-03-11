<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Outfit', sans-serif;
            background: #f8fafc;
        }
    </style>
</head>
<body class="bg-slate-50">
    <nav class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between">
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">CRM Manager</h1>
        <div class="flex items-center space-x-6">
            <span class="text-sm text-slate-500">{{ Auth::user()->name }} ({{ Auth::user()->email }})</span>
            <form action="{{ route(\App\Enums\RouteName::LOGOUT->value) }}" method="POST">
                @csrf
                <button type="submit" class="text-sm font-semibold text-rose-600 hover:text-rose-700">Выход</button>
            </form>
        </div>
    </nav>

    <main class="p-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl font-bold text-slate-900 mb-8">Рабочий стол</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Cards -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-sm text-slate-500 mb-1">Всего заявок</p>
                    <p class="text-3xl font-bold text-slate-900">128</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-sm text-slate-500 mb-1">Новых сегодня</p>
                    <p class="text-3xl font-bold text-blue-600">+12</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-sm text-slate-500 mb-1">В ожидании</p>
                    <p class="text-3xl font-bold text-amber-500">24</p>
                </div>
            </div>

            <div class="mt-10 bg-white rounded-2xl shadow-sm border border-slate-100 p-8 text-center text-slate-400 font-light">
                <p>Здесь скоро появится список заявок и управление ими.</p>
            </div>
        </div>
    </main>
</body>
</html>
