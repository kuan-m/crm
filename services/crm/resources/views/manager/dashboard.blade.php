@extends('manager.layouts.app')

@section('title', 'Заявки — CRM Manager')

@section('content')
        
        <!-- Header & Stats -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Заявки</h2>
                <p class="text-sm text-slate-500 mt-1">Управление входящими обращениями клиентов</p>
            </div>
            
            <div class="flex flex-wrap gap-4">
                <div class="bg-white px-5 py-3 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">За месяц</p>
                        <p class="text-xl font-bold text-slate-800 leading-none mt-1" id="stat-all">...</p>
                    </div>
                </div>
                <div class="bg-white px-5 py-3 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="bg-emerald-50 p-2 rounded-lg text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">За неделю</p>
                        <p class="text-xl font-bold text-emerald-600 leading-none mt-1" id="stat-week">...</p>
                    </div>
                </div>
                <div class="bg-white px-5 py-3 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="bg-indigo-50 p-2 rounded-lg text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Сегодня</p>
                        <p class="text-xl font-bold text-indigo-600 leading-none mt-1" id="stat-today">...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <form id="filters-form" class="flex flex-wrap items-end gap-4" onsubmit="event.preventDefault(); fetchTickets();">
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Дата</label>
                    <input type="date" name="date" class="w-full text-sm border-slate-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-2 transition-colors">
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Статус</label>
                    <select name="status" class="w-full text-sm border-slate-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-2 transition-colors">
                        <option value="">Все статусы</option>
                        @foreach($statuses as $statusOption)
                            <option value="{{ $statusOption->value }}">{{ $statusOption->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="text" name="email" placeholder="Поиск по email" class="w-full text-sm border-slate-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-2 transition-colors">
                </div>
                <div class="flex-1 min-w-[150px]">
                    <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Телефон</label>
                    <input type="text" name="phone" placeholder="Поиск по телефону" class="w-full text-sm border-slate-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-2 px-2 transition-colors">
                </div>
                <div class="flex-none flex items-center gap-2">
                    <button type="submit" class="bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-700 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 w-full md:w-auto flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Искать
                    </button>
                    <button type="button" onclick="resetFilters()" class="bg-white text-slate-600 border border-slate-200 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 w-full md:w-auto flex items-center justify-center" title="Сбросить фильтры">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Ticket List Container -->
        <div id="tickets-list-container" class="relative min-h-[400px]">
            <!-- Loader -->
            <div id="tickets-loader" class="absolute inset-0 bg-white/60 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl hidden">
                <div class="w-8 h-8 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
            </div>
            
            <!-- Target for Ajax HTML -->
            <div id="tickets-content"></div>
        </div>

@endsection

@push('modals')
    <!-- Ticket Details Modal -->
    <div id="ticket-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" 
             id="modal-backdrop" onclick="closeModal()"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal Panel -->
                <div id="modal-panel" class="relative transform rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl modal-leave">
                    
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 rounded-t-2xl">
                        <div class="flex items-center gap-3">
                            <span class="bg-blue-100 text-blue-700 py-1 px-2.5 rounded-md text-xs font-bold" id="modal-ticket-id">#--</span>
                            <h3 class="text-lg font-semibold leading-6 text-slate-900" id="modal-ticket-subject">Загрузка...</h3>
                        </div>
                        <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-500 bg-white hover:bg-slate-100 rounded-full p-1.5 transition-colors focus:outline-none">
                            <span class="sr-only">Закрыть</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <!-- Loader inside modal -->
                        <div id="modal-loader" class="flex justify-center py-10 hidden">
                             <div class="w-8 h-8 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                        </div>

                        <div id="modal-content-area" class="space-y-6">
                            <!-- Customer Info -->
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-wrap gap-y-3 gap-x-6 text-sm">
                                <div>
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Клиент</span>
                                    <span class="font-medium text-slate-800" id="modal-customer-name">--</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Email</span>
                                    <span class="text-slate-600" id="modal-customer-email">--</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Телефон</span>
                                    <span class="text-slate-600 font-mono" id="modal-customer-phone">--</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Дата</span>
                                    <span class="text-slate-600" id="modal-ticket-date">--</span>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Дата ответа</span>
                                    <span class="text-slate-600 font-medium text-emerald-600" id="modal-ticket-replied-date">--</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Текст обращения</h4>
                                <div class="text-sm text-slate-700 bg-white border border-slate-200 rounded-xl p-4 leading-relaxed whitespace-pre-wrap" id="modal-ticket-text">
                                    --
                                </div>
                            </div>

                            <!-- Attachments -->
                            <div id="modal-attachments-container" class="hidden">
                                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Прикрепленные файлы</h4>
                                <ul id="modal-attachments-list" class="divide-y divide-slate-100 border border-slate-200 rounded-xl">
                                    <!-- Files injected here via JS -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="bg-slate-50/50 px-6 py-4 flex items-center justify-between border-t border-slate-100 rounded-b-2xl">
                        <div class="relative inline-block w-[150px]">
                            <select id="modal-ticket-status-select" 
                                    onchange="window.updateTicketStatus(document.getElementById('modal-ticket-id').dataset.id, this.value, this)"
                                    class="w-full appearance-none pl-3 pr-8 py-1.5 rounded-md text-xs font-bold border focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors cursor-pointer text-slate-700 bg-white border-slate-200">
                                @php
                                    $allStatuses = \App\Modules\Ticket\Enums\TicketStatus::cases();
                                    
                                    function getOptionStyle(int $val): string {
                                        return match($val) {
                                            1 => 'color: #1d4ed8; background-color: #eff6ff; font-weight: 600;', // blue
                                            2 => 'color: #b45309; background-color: #fffbeb; font-weight: 600;', // amber
                                            3 => 'color: #047857; background-color: #ecfdf5; font-weight: 600;', // emerald
                                            default => 'color: #334155; background-color: #f8fafc; font-weight: 600;', // slate
                                        };
                                    }
                                @endphp
                                @foreach($allStatuses as $statusOption)
                                    <option value="{{ $statusOption->value }}" style="{{ getOptionStyle($statusOption->value) }}">{{ $statusOption->label() }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <button type="button" onclick="closeModal()" class="inline-flex justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-colors">
                            Закрыть
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <!-- JavaScript -->
    <script>
        const baseUrl = '{{ url('/') }}';
        let currentUrl = '{{ route(\App\Enums\RouteName::MANAGER_TICKETS_LIST->value) }}';

        // Initial Data Load
        document.addEventListener('DOMContentLoaded', () => {
            fetchStatistics();
            fetchTickets(currentUrl);
        });

        // 1. Fetch Statistics
        async function fetchStatistics() {
            try {
                const response = await axios.get('{{ route('api.v1.tickets.statistics') }}');
                const stats = response.data.data;
                
                document.getElementById('stat-today').textContent = stats.today || 0;
                document.getElementById('stat-week').textContent = stats.week || 0;
                document.getElementById('stat-all').textContent = stats.month || 0; 
            } catch (error) {
                console.error('Failed to fetch statistics:', error);
            }
        }

        function resetFilters() {
            document.getElementById('filters-form').reset();
            fetchTickets(currentUrl.split('?')[0]); // fetch without params
        }

        // 2. Fetch Ticket List HTML
        async function fetchTickets(url = null) {
            const form = document.getElementById('filters-form');
            const formData = new FormData(form);
            const searchParams = new URLSearchParams(formData);
            
            // If new search, use base url + params. If pagination click, use url + current params.
            let fetchUrl = url || '{{ route(\App\Enums\RouteName::MANAGER_TICKETS_LIST->value) }}';
            
            // If it's a pagination URL, we might need to merge existing filters
            if(fetchUrl.includes('?')) {
                // Merge params (basic implementation)
                 const existingParams = new URLSearchParams(fetchUrl.split('?')[1]);
                 for (const [key, value] of searchParams.entries()) {
                     if(value) existingParams.set(key, value);
                 }
                 fetchUrl = fetchUrl.split('?')[0] + '?' + existingParams.toString();
            } else {
                 fetchUrl = fetchUrl + '?' + searchParams.toString();
            }

            document.getElementById('tickets-loader').classList.remove('hidden');

            try {
                const response = await axios.get(fetchUrl);
                document.getElementById('tickets-content').innerHTML = response.data;
                
                // Intercept pagination clicks
                document.querySelectorAll('#tickets-list-container nav[role="navigation"] a').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const href = e.currentTarget.getAttribute('href');
                        if (href) {
                            fetchTickets(href);
                        }
                    });
                });
            } catch (error) {
                console.error('Failed to fetch tickets:', error);
                document.getElementById('tickets-content').innerHTML = '<div class="text-red-500 p-4 text-center">Ошибка загрузки заявок</div>';
            } finally {
                document.getElementById('tickets-loader').classList.add('hidden');
            }
        }

        // 3. View Full Ticket Details
        async function viewTicket(id) {
            openModal();
            document.getElementById('modal-loader').classList.remove('hidden');
            document.getElementById('modal-content-area').classList.add('hidden');
            
            // Reset fields
            const idElement = document.getElementById('modal-ticket-id');
            idElement.textContent = `#${id}`;
            idElement.dataset.id = id;
            document.getElementById('modal-ticket-subject').textContent = 'Загрузка...';

            try {
                const response = await axios.get('{{ url("api/v1/tickets") }}/' + id);
                const ticket = response.data.data;

                // Populate data
                document.getElementById('modal-ticket-subject').textContent = ticket.subject;
                document.getElementById('modal-customer-name').textContent = ticket.customer.name;
                document.getElementById('modal-customer-email').textContent = ticket.customer.email;
                document.getElementById('modal-customer-phone').textContent = ticket.customer.phone;
                
                // Format date roughly if needed, assuming API sends ISO string
                 const d = new Date(ticket.created_at);
                document.getElementById('modal-ticket-date').textContent = d.toLocaleString('ru-RU', {day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'});
                
                if (ticket.replied_at) {
                    const rd = new Date(ticket.replied_at);
                    document.getElementById('modal-ticket-replied-date').textContent = rd.toLocaleString('ru-RU', {day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'});
                } else {
                    document.getElementById('modal-ticket-replied-date').textContent = '—';
                }
                
                document.getElementById('modal-ticket-text').textContent = ticket.text;
                
                // Color status badge select
                const statusSelect = document.getElementById('modal-ticket-status-select');
                statusSelect.value = ticket.status;
                statusSelect.dataset.originalValue = ticket.status;
                
                // Reset select classes before applying new ones
                statusSelect.className = 'w-full appearance-none pl-3 pr-8 py-1.5 rounded-md text-xs font-bold border focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors cursor-pointer ' + getStatusClass(ticket.status);


                // Attachments
                const attContainer = document.getElementById('modal-attachments-container');
                const attList = document.getElementById('modal-attachments-list');
                attList.innerHTML = '';

                if (ticket.attachments && ticket.attachments.length > 0) {
                    attContainer.classList.remove('hidden');
                    ticket.attachments.forEach(file => {
                        const sizeKb = (file.size / 1024).toFixed(1);
                        const isImage = file.mime_type.startsWith('image/');
                        const li = document.createElement('li');
                        li.className = 'flex items-center justify-between py-3 pl-4 pr-5 hover:bg-slate-50 transition-colors cursor-default';
                        
                        let previewHtml = `<svg class="h-8 w-8 flex-shrink-0 text-slate-400 bg-slate-100 p-1.5 rounded-lg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>`;
                        if(isImage) {
                            previewHtml = `
                                <div class="relative group">
                                    <img src="${file.url}" alt="${file.file_name}" class="h-8 w-8 object-cover rounded-lg border border-slate-200 cursor-zoom-in">
                                    <div class="hidden group-hover:block absolute z-[60] left-10 -top-10 bg-white p-2 rounded-xl border border-slate-200 shadow-2xl pointer-events-none">
                                        <img src="${file.url}" alt="${file.file_name}" class="max-w-[400px] max-h-[400px] rounded-lg object-contain shadow-sm">
                                    </div>
                                </div>
                            `;
                        }

                        li.innerHTML = `
                            <div class="flex items-center flex-1 w-0">
                                ${previewHtml}
                                <div class="ml-4 flex min-w-0 flex-1 flex-col">
                                    <span class="truncate font-medium text-slate-700 text-xs">${file.file_name}</span>
                                    <span class="flex-shrink-0 text-slate-400 text-[10px] mt-0.5">${sizeKb} KB</span>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="${file.url}" download="${file.file_name}" class="font-medium text-blue-600 hover:text-blue-500 text-xs bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition-colors flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Скачать
                                </a>
                            </div>
                        `;
                        attList.appendChild(li);
                    });
                } else {
                    attContainer.classList.add('hidden');
                }

                document.getElementById('modal-loader').classList.add('hidden');
                document.getElementById('modal-content-area').classList.remove('hidden');

            } catch (error) {
                console.error('Failed to fetch ticket:', error);
                document.getElementById('modal-ticket-subject').textContent = 'Ошибка загрузки';
                document.getElementById('modal-loader').classList.add('hidden');
            }
        }

        // Modal Controls
        const modal = document.getElementById('ticket-modal');
        const modalPanel = document.getElementById('modal-panel');

        function openModal() {
            modal.classList.remove('hidden');
            // small delay to allow display block to apply before animating opacity
            setTimeout(() => {
                modalPanel.classList.remove('modal-leave');
                modalPanel.classList.add('modal-enter-active');
            }, 10);
        }

        function closeModal() {
            modalPanel.classList.remove('modal-enter-active');
            modalPanel.classList.add('modal-leave-active');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modalPanel.classList.remove('modal-leave-active');
                modalPanel.classList.add('modal-leave');
            }, 150);
        }

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
        // Helper for status styling
        function getStatusClass(statusValue) {
            // Using integer values from TicketStatus Enum
            switch(parseInt(statusValue)) {
                case 1: return 'bg-blue-50 text-blue-600 border-blue-200'; // New
                case 2: return 'bg-amber-50 text-amber-600 border-amber-200'; // InProcess
                case 3: return 'bg-emerald-50 text-emerald-600 border-emerald-200'; // Processed
                default: return 'bg-slate-50 text-slate-600 border-slate-200';
            }
        }

        // 4. Update Ticket Status
        async function updateTicketStatus(id, newStatus, selectElement) {
            const originalValue = selectElement.dataset.originalValue;
            
            // Revert changes visually fast if they select the same one
            if(newStatus == originalValue) return;

            // Simple visual loading logic
            const originalClasses = selectElement.className;
            selectElement.classList.add('opacity-50', 'pointer-events-none');

            try {
                const response = await axios.patch(`{{ url('/api/v1/tickets') }}/${id}/status`, { status: newStatus });
                const repliedAt = response.data.data?.replied_at;
                
                // Success: apply new styles and save state
                selectElement.dataset.originalValue = newStatus;
                
                let repliedDateStr = null;
                if (repliedAt) {
                    repliedDateStr = new Date(repliedAt).toLocaleString('ru-RU', {day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'});
                }
                
                // Base classes without color
                const baseClasses = 'w-full appearance-none pl-2 pr-6 py-1 rounded-md text-[11px] font-medium border focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors cursor-pointer ';
                // Modal uses slightly different base classes (larger py/text)
                const isModal = selectElement.id === 'modal-ticket-status-select';
                
                const updateTableRepliedNode = (ticketId, dStr) => {
                    const listSelects = document.querySelectorAll(`select[onchange*="updateTicketStatus(${ticketId},"]`);
                    listSelects.forEach(sel => {
                        const td = sel.closest('tr').querySelector('td:first-child');
                        if (td) {
                            let rNode = td.querySelector(`#ticket-replied-${ticketId}`);
                            if (dStr) {
                                if (!rNode) {
                                    rNode = document.createElement('div');
                                    rNode.id = `ticket-replied-${ticketId}`;
                                    rNode.className = 'text-[11px] text-emerald-600 font-medium mt-1 inline-flex items-center gap-1 bg-emerald-50 px-1.5 py-0.5 rounded';
                                    td.appendChild(rNode);
                                }
                                rNode.textContent = 'Дата ответа ' + dStr;
                            } else if (rNode) {
                               // Should we remove it if no longer processed? Current logic doesn't clear the replied_at date in DB, but just in case.
                               // We keep it as is if dStr=null, usually API will return the existing repliedAt.
                            }
                        }
                    });
                };
                
                updateTableRepliedNode(id, repliedDateStr);

                if (isModal) {
                    selectElement.className = 'w-full appearance-none pl-3 pr-8 py-1.5 rounded-md text-xs font-bold border focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors cursor-pointer ' + getStatusClass(newStatus);
                    
                    const modalRepliedNode = document.getElementById('modal-ticket-replied-date');
                    if (modalRepliedNode && document.getElementById('modal-ticket-id')?.dataset?.id == id) {
                        modalRepliedNode.textContent = repliedDateStr ? repliedDateStr : '—';
                    }

                    // Sync the list view natively without sending a search request
                    const listSelects = document.querySelectorAll(`select[onchange*="updateTicketStatus(${id},"]`);
                    listSelects.forEach(sel => {
                        sel.value = newStatus;
                        sel.dataset.originalValue = newStatus;
                        sel.className = baseClasses + getStatusClass(newStatus);
                    });
                } else {
                    selectElement.className = baseClasses + getStatusClass(newStatus);
                    
                    // Sync the modal view natively if it happens to be open for this ticket
                    const modalSelect = document.getElementById('modal-ticket-status-select');
                    const modalTicketId = document.getElementById('modal-ticket-id')?.dataset?.id;
                    if (modalSelect && modalTicketId == id) {
                        modalSelect.value = newStatus;
                        modalSelect.dataset.originalValue = newStatus;
                        modalSelect.className = 'w-full appearance-none pl-3 pr-8 py-1.5 rounded-md text-xs font-bold border focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors cursor-pointer ' + getStatusClass(newStatus);
                        
                        const modalRepliedNode = document.getElementById('modal-ticket-replied-date');
                        if (modalRepliedNode) modalRepliedNode.textContent = repliedDateStr ? repliedDateStr : '—';
                    }
                }



            } catch (error) {
                console.error('Failed to update status:', error);
                alert(error.response?.data?.message || 'Ошибка при обновлении статуса');
                // Revert
                selectElement.value = originalValue;
            } finally {
                selectElement.classList.remove('opacity-50', 'pointer-events-none');
            }
        }
    </script>
@endpush
