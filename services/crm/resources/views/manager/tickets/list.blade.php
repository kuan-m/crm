@if($tickets->isEmpty())
    <div class="py-12 text-center text-slate-400 font-light bg-white rounded-2xl border border-slate-100 shadow-sm">
        <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <p>Заявки не найдены</p>
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-semibold text-slate-400 uppercase tracking-wider">
                        <th class="p-4 pl-6">ID / Дата</th>
                        <th class="p-4">Клиент</th>
                        <th class="p-4">Тема</th>
                        <th class="p-4">Статус</th>
                        <th class="p-4 pr-6 text-right">Действие</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-4 pl-6">
                                <div class="font-medium text-slate-800">#{{ $ticket->id }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $ticket->created_at->format('d.m.Y H:i') }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-slate-800">{{ $ticket->customer->name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $ticket->customer->email }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $ticket->customer->phone }}</div>
                            </td>
                            <td class="p-4">
                                <span class="font-medium text-slate-700 truncate block max-w-xs" title="{{ $ticket->subject }}">
                                    {{ $ticket->subject }}
                                </span>
                            </td>
                            <td class="p-4">
                                @php
                                    $statusClasses = match($ticket->status->value) {
                                        \App\Modules\Ticket\Enums\TicketStatus::New->value => 'bg-blue-50 text-blue-600 border-blue-200',
                                        \App\Modules\Ticket\Enums\TicketStatus::InProcess->value => 'bg-amber-50 text-amber-600 border-amber-200',
                                        \App\Modules\Ticket\Enums\TicketStatus::Processed->value => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        default => 'bg-slate-50 text-slate-600 border-slate-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-[11px] font-medium border {{ $statusClasses }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <button type="button" 
                                        onclick="window.viewTicket({{ $ticket->id }})"
                                        class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors inline-flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($tickets->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
@endif
