<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Написать в поддержку</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.1/build/js/intlTelInput.min.js"></script>

    <style>
        body { font-family: 'Manrope', sans-serif; }
        .iti { display: block; width: 100%; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp .3s ease-out both; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

<div class="bg-white w-full max-w-sm rounded-2xl shadow-lg overflow-hidden animate-fade-up">

    {{-- ===== ФОРМА ===== --}}
    <div id="formView" class="p-5">

        <div class="flex items-center gap-2.5 mb-5">
            <span class="bg-blue-600 p-1.5 rounded-lg shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </span>
            <div>
                <p class="text-sm font-bold text-gray-800 leading-tight">Написать в поддержку</p>
                <p class="text-[11px] text-gray-400">Ответим в ближайшее время</p>
            </div>
        </div>

        <form id="ticketForm" class="space-y-3" novalidate>

            <div>
                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Имя</label>
                <input type="text" name="name" required placeholder="Иван Иванов"
                       class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Email</label>
                <input type="email" name="email" required placeholder="ivan@example.com"
                       class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Телефон</label>
                <input type="tel" id="phone" name="phone_input" required
                       class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Тема</label>
                <input type="text" name="subject" required placeholder="Краткая суть вопроса"
                       class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Сообщение</label>
                <textarea name="text" rows="3" required placeholder="Опишите детали..."
                          class="w-full px-3 py-2 text-xs border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all resize-none"></textarea>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Файлы</label>
                    <span id="fileCount" class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded">0 / 5</span>
                </div>
                <label class="flex items-center justify-center gap-2 w-full h-12 border-2 border-dashed border-gray-200
                              rounded-lg cursor-pointer hover:bg-gray-50 transition-colors text-[11px] text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Добавить вложения
                    <input id="fileInput" type="file" class="hidden" multiple>
                </label>
                <ul id="fileList" class="mt-1.5 space-y-1 max-h-28 overflow-y-auto"></ul>
            </div>

            <button type="submit" id="submitBtn"
                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-60 text-white text-xs font-semibold
                           py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2">
                <span id="btnText">Отправить</span>
                <svg id="loader" class="hidden animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
            </button>

        </form>
    </div>

    {{-- ===== КАРТОЧКА УСПЕХА ===== --}}
    <div id="successView" class="hidden">

        {{-- Зелёная шапка --}}
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 px-5 pt-6 pb-8 text-white text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-white/20 mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-base font-bold">Заявка принята!</p>
            <p class="text-[11px] text-white/70 mt-0.5">Мы свяжемся с вами в ближайшее время</p>
            <div class="inline-block mt-3 bg-white/20 rounded-full px-3 py-1 text-[11px] font-semibold tracking-wide">
                # <span id="sTicketId"></span> · <span id="sStatus"></span>
            </div>
        </div>

        {{-- Тело карточки --}}
        <div class="px-5 -mt-4">

            {{-- Блок контакта --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-3">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2.5">Контакт</p>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0" id="sAvatar"></div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate" id="sName"></p>
                        <p class="text-[11px] text-gray-400 truncate" id="sEmail"></p>
                        <p class="text-[11px] text-gray-400" id="sPhone"></p>
                    </div>
                </div>
            </div>

            {{-- Тема + текст --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-3">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Обращение</p>
                <p class="text-xs font-semibold text-gray-800 mb-1" id="sSubject"></p>
                <p class="text-[11px] text-gray-500 leading-relaxed" id="sText"></p>
            </div>

            {{-- Вложения (показываем только если есть) --}}
            <div id="sAttachmentsBlock" class="hidden bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-3">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Вложения</p>
                <ul id="sAttachments" class="space-y-1.5"></ul>
            </div>

            {{-- Дата + кнопка новой заявки --}}
            <div class="flex items-center justify-between py-3">
                <p class="text-[10px] text-gray-400" id="sDate"></p>
                <button onclick="resetForm()"
                        class="text-[11px] text-blue-600 font-semibold hover:underline">
                    Новая заявка →
                </button>
            </div>

        </div>
    </div>

</div>

<script>
    // --- Intl-Tel-Input ---
    // dropdownContainer: document.body — рендерит список стран вне карточки,
    // исключает съезжание при overflow родителя
    const phoneEl = document.querySelector('#phone');
    const iti = window.intlTelInput(phoneEl, {
        initialCountry: 'ru',
        preferredCountries: ['ru', 'kz', 'uz', 'kg'],
        utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.1/build/js/utils.js',
        autoPlaceholder: 'aggressive',
        separateDialCode: true,
        strictMode: true,
        dropdownContainer: document.body,
    });

    // --- Файлы ---
    const MAX_FILES   = 5;
    const MAX_SIZE    = 10 * 1024 * 1024;
    const ALLOWED_EXT = new Set(['jpg','jpeg','png','gif','pdf','doc','docx','xls','xlsx','zip']);

    let selectedFiles = [];

    const fileInput   = document.getElementById('fileInput');
    const fileListEl  = document.getElementById('fileList');
    const fileCountEl = document.getElementById('fileCount');

    fileInput.addEventListener('change', ({ target }) => {
        Array.from(target.files).forEach(file => {
            const isDuplicate = selectedFiles.some(f => f.name === file.name && f.size === file.size);
            if (!isDuplicate) selectedFiles.push(file);
        });
        target.value = '';
        renderFiles();
    });

    function renderFiles() {
        fileCountEl.textContent = `${selectedFiles.length} / ${MAX_FILES}`;
        fileListEl.innerHTML = selectedFiles.map((f, i) => `
            <li class="flex items-center justify-between px-2 py-1 bg-gray-50 border border-gray-100 rounded text-[11px] text-gray-600">
                <span class="truncate max-w-[200px]">${f.name}</span>
                <button type="button" onclick="removeFile(${i})" class="ml-2 text-gray-300 hover:text-red-400 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </li>`).join('');
    }

    window.removeFile = (i) => { selectedFiles.splice(i, 1); renderFiles(); };

    function validateFiles() {
        if (selectedFiles.length > MAX_FILES) return `Можно прикрепить не более ${MAX_FILES} файлов.`;
        for (const file of selectedFiles) {
            const ext = file.name.split('.').pop().toLowerCase();
            if (file.size > MAX_SIZE)  return `Файл «${file.name}» превышает 10 МБ.`;
            if (!ALLOWED_EXT.has(ext)) return `Формат «${ext}» не поддерживается.`;
        }
        return null;
    }

    // --- Отправка ---
    const form      = document.getElementById('ticketForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText   = document.getElementById('btnText');
    const loader    = document.getElementById('loader');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!iti.isValidNumber()) return showError('Введите корректный номер телефона.');

        const fileError = validateFiles();
        if (fileError) return showError(fileError);

        setLoading(true);

        try {
            const fd = new FormData(form);

            const { data: { data: ticket } } = await axios.post(
                '{{ route("api.v1.tickets.create") }}',
                {
                    name:    fd.get('name'),
                    email:   fd.get('email'),
                    phone:   iti.getNumber(),
                    subject: fd.get('subject'),
                    text:    fd.get('text'),
                }
            );

            // Загружаем файлы и берём вложения из ответа эндпоинта
            if (selectedFiles.length) {
                const fileData = new FormData();
                selectedFiles.forEach(f => fileData.append('files[]', f));

                const { data: { data: attachments } } = await axios.post(
                    '{{ route("api.v1.tickets.files.upload", ["ticket" => "__ID__"]) }}'.replace('__ID__', ticket.id),
                    fileData,
                    { headers: { 'Content-Type': 'multipart/form-data' } }
                );

                ticket.attachments = attachments;
            }

            showSuccess(ticket);

        } catch (err) {
            const res = err.response;
            let message = res?.data?.message ?? 'Произошла ошибка. Попробуйте позже.';

            if (res?.status === 422 && typeof res.data.errors === 'object') {
                message = Object.values(res.data.errors).flat().join('<br>');
            }

            showError(message);
        } finally {
            setLoading(false);
        }
    });

    // --- Рендер карточки успеха ---
    function showSuccess(ticket) {
        const c = ticket.customer;

        // Аватар — первая буква имени
        document.getElementById('sAvatar').textContent   = c.name.charAt(0).toUpperCase();
        document.getElementById('sTicketId').textContent = ticket.id;
        document.getElementById('sStatus').textContent   = ticket.status_label;
        document.getElementById('sName').textContent     = c.name;
        document.getElementById('sEmail').textContent    = c.email;
        document.getElementById('sPhone').textContent    = c.phone;
        document.getElementById('sSubject').textContent  = ticket.subject;
        document.getElementById('sText').textContent     = ticket.text;

        // Дата
        const date = new Date(ticket.created_at);
        document.getElementById('sDate').textContent = date.toLocaleString('ru-RU', {
            day: 'numeric', month: 'long', hour: '2-digit', minute: '2-digit'
        });

        // Вложения
        if (ticket.attachments?.length) {
            const icons = { 'application/pdf': '📄', 'image/': '🖼️' };
            document.getElementById('sAttachments').innerHTML = ticket.attachments.map(a => {
                const icon = Object.entries(icons).find(([k]) => a.mime_type.startsWith(k))?.[1] ?? '📎';
                const size = (a.size / 1024).toFixed(0);
                return `
                    <li>
                        <a href="${a.url}" target="_blank"
                           class="flex items-center gap-2 text-[11px] text-blue-600 hover:text-blue-800 transition-colors">
                            <span>${icon}</span>
                            <span class="truncate">${a.file_name}</span>
                            <span class="text-gray-400 shrink-0">${size} КБ</span>
                        </a>
                    </li>`;
            }).join('');
            document.getElementById('sAttachmentsBlock').classList.remove('hidden');
        }

        // Переключаем вид
        document.getElementById('formView').classList.add('hidden');
        document.getElementById('successView').classList.remove('hidden');
        document.getElementById('successView').classList.add('animate-fade-up');
    }

    // --- Сброс к форме ---
    window.resetForm = () => {
        form.reset();
        selectedFiles = [];
        renderFiles();
        document.getElementById('sAttachmentsBlock').classList.add('hidden');
        document.getElementById('successView').classList.add('hidden');
        document.getElementById('formView').classList.remove('hidden');
    };

    function setLoading(state) {
        submitBtn.disabled  = state;
        btnText.textContent = state ? 'Отправка...' : 'Отправить';
        loader.classList.toggle('hidden', !state);
    }

    function showError(html) {
        Swal.fire({ title: 'Ошибка', html, icon: 'error', confirmButtonColor: '#2563eb' });
    }
</script>

</body>
</html>