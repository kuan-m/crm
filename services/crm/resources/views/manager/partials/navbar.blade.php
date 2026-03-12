<nav class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-10 transition-shadow">
    <div class="flex items-center gap-3">
        <div class="bg-blue-600 p-1.5 rounded-lg">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-base font-bold text-slate-800 leading-none">CRM Manager</h1>
            <p class="text-[11px] text-slate-500 mt-0.5">Workspace</p>
        </div>
    </div>
    
    <div class="flex items-center space-x-6">
        <div class="flex items-center gap-2">
            <div class="hidden md:block">
                <p class="text-xs font-semibold text-slate-700 leading-none">{{ Auth::user()->name ?? 'Администратор' }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">{{ Auth::user()->email ?? 'admin@crm.test' }}</p>
            </div>
        </div>
        <div class="w-px h-6 bg-slate-200"></div>
        <form action="{{ route(\App\Enums\RouteName::LOGOUT->value) }}" method="POST">
            @csrf
            <button type="submit" class="text-xs font-semibold text-rose-500 hover:text-rose-700 transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Выход
            </button>
        </form>
    </div>
</nav>
