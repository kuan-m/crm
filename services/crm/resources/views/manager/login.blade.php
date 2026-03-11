<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход для менеджеров</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Manrope', sans-serif; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp .3s ease-out both; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

<div class="bg-white w-full max-w-sm rounded-2xl shadow-lg p-5 animate-fade-up">

    {{-- Заголовок --}}
    <div class="flex items-center gap-2.5 mb-5">
        <span class="bg-blue-600 p-1.5 rounded-lg shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </span>
        <div>
            <p class="text-sm font-bold text-gray-800 leading-tight">CRM Manager</p>
            <p class="text-[11px] text-gray-400">Вход в панель управления</p>
        </div>
    </div>

    <form action="{{ route(\App\Enums\RouteName::LOGIN->value) }}" method="POST" class="space-y-3" novalidate>
        @csrf

        {{-- Email --}}
        <div>
            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">
                Электронная почта
            </label>
            <input type="email" name="email" required autofocus
                   value="{{ old('email', 'admin@crm.test') }}"
                   placeholder="admin@crm.test"
                   class="w-full px-3 py-2 text-xs border rounded-lg outline-none transition-all
                          {{ $errors->has('email') ? 'border-red-400 focus:ring-2 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500' }}">
            @error('email')
                <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Пароль --}}
        <div>
            <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">
                Пароль
            </label>
            <input type="password" name="password" required value="password"
                   placeholder="••••••••"
                   class="w-full px-3 py-2 text-xs border rounded-lg outline-none transition-all
                          {{ $errors->has('password') ? 'border-red-400 focus:ring-2 focus:ring-red-500/20 focus:border-red-500' : 'border-gray-200 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500' }}">
            @error('password')
                <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Запомнить --}}
        <label class="flex items-center gap-2 cursor-pointer select-none">
            <input type="checkbox" name="remember"
                   class="w-3.5 h-3.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500/20">
            <span class="text-[11px] text-gray-400">Запомнить меня</span>
        </label>

        {{-- Кнопка --}}
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold
                       py-2.5 rounded-lg transition-colors">
            Войти в систему
        </button>

    </form>
</div>

</body>
</html>