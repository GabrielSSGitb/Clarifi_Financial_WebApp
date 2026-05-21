@php use App\Models\Annotation; @endphp
@extends('webSite.layouts.basicSetup')

@section('content')
    <section class="calendar-section">
        {{-- Header --}}
        <div class="calendar-header">
            <div>
                <h1 class="calendar-title">Financial Calendar</h1>
                <p class="calendar-subtitle">Schedule, plan, and keep track of your notes and payment deadlines.</p>
            </div>
            <div class="header-actions">
                <button onclick="openNoteModal(new Date().toISOString().split('T')[0])" class="btn-primary">
                    + Add Quick Note
                </button>
            </div>
        </div>

        <div class="calendar-grid-layout">
            {{-- Painel Lateral: Próximas Anotações --}}
            <div class="upcoming-panel">
                <h3 class="panel-title">Upcoming Annotations</h3>
                <div class="notes-list" id="upcomingNotesList">
                    {{-- Será populado via JS ou loops do Blade --}}
                    @forelse($annotations as $note)
                        <div class="upcoming-card" onclick="openNoteModal('{{ $note->date }}')">
                            <div class="card-dot"></div>
                            <div class="card-content">
                                <span class="card-date">{{ date('M d, Y', strtotime($note->date)) }}</span>
                                <p class="card-text">{{ Str::limit($note->content, 60) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-sm text-center py-4">No annotations for the next few days.</p>
                    @endforelse
                </div>
            </div>

            {{-- O Calendário Principal --}}
            <div class="main-calendar-card">
                <div class="calendar-navigation">
                    <button onclick="moveMonth(-1)" class="nav-btn">&larr;</button>
                    <h2 id="currentMonthYear" class="month-year-title">May 2026</h2>
                    <button onclick="moveMonth(1)" class="nav-btn">&rarr;</button>
                </div>

                <div class="weekdays-grid">
                    <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                </div>

                <div id="calendarDays" class="days-grid">
                    {{-- Grid de dias gerado dinamicamente via JS --}}
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL PARA ADICIONAR/EDITAR ANOTAÇÃO --}}
    <div id="noteModal" class="modal-overlay hidden">
        <div class="modal-card">
            <div class="modal-header">
                <h3 id="modalTitle" class="modal-title">Annotation</h3>
                <button onclick="closeNoteModal()" class="close-btn">&times;</button>
            </div>

            <form id="noteForm" action="{{route('dashboard.calendar.save')}}" method="POST">
                @csrf
                <input type="hidden" id="noteId" name="id">
                <input type="hidden" id="noteDate" name="date">

                <div class="form-group">
                    <label class="form-label" for="selectedDateDisplay">Selected Date</label>
                    <input type="text" name="selectedDate" id="selectedDateDisplay" class="form-input text-muted" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label" for="noteContent">Your Annotation</label>
                    <textarea id="noteContent" name="content" rows="4" placeholder="Write down expenses, reminders, or goals for this day..." class="form-textarea" required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="closeNoteModal()" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Save Note</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* --- ESTRUTURA GERAL --- */
        .calendar-section { max-width: 1152px; margin: 0 auto; color: #ffffff; }
        .text-muted { color: #6b7280; }
        .text-sm { font-size: 0.875rem; }
        .hidden { display: none !important; }

        /* --- HEADER --- */
        .calendar-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; }
        .calendar-title { font-size: 2.25rem; font-weight: 700; margin: 0; letter-spacing: -0.025em; }
        .calendar-subtitle { color: #6b7280; margin-top: 0.5rem; margin-bottom: 0; }

        .btn-primary { padding: 0.75rem 1.25rem; background-color: #4f46e5; border: none; border-radius: 0.75rem; color: white; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-primary:hover { background-color: #4338ca; }
        .btn-secondary { padding: 0.75rem 1.25rem; background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; color: #d1d5db; cursor: pointer; }

        /* --- LAYOUT GRID --- */
        .calendar-grid-layout { display: grid; grid-template-columns: 1fr; gap: 2rem; }
        @media (min-width: 768px) { .calendar-grid-layout { grid-template-columns: 300px 1fr; } }

        /* --- PAINEL LATERAL --- */
        .upcoming-panel { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 1.5rem; }
        .panel-title { font-size: 1.125rem; margin-top: 0; margin-bottom: 1.25rem; font-weight: 600; }
        .notes-list { display: flex; flex-direction: column; gap: 1rem; }
        .upcoming-card { display: flex; gap: 0.75rem; padding: 1rem; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 1rem; cursor: pointer; transition: background 0.2s; }
        .upcoming-card:hover { background: rgba(255,255,255,0.06); }
        .card-dot { width: 8px; height: 8px; background: #06b6d4; border-radius: 50%; margin-top: 4px; flex-shrink: 0; }
        .card-date { font-size: 0.75rem; color: #a5b4fc; font-weight: 600; }
        .card-text { font-size: 0.85rem; margin: 0.25rem 0 0 0; color: #e5e7eb; }

        /* --- CALENDÁRIO CARD --- */
        .main-calendar-card { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; padding: 1.5rem; backdrop-filter: blur(12px); }
        .calendar-navigation { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .nav-btn { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.5rem; color: white; padding: 0.5rem 1rem; cursor: pointer; }
        .nav-btn:hover { background: rgba(255,255,255,0.1); }
        .month-year-title { font-size: 1.25rem; margin: 0; font-weight: 600; }

        /* DIAS E SEMANAS GRID */
        .weekdays-grid { display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; font-size: 0.75rem; text-transform: uppercase; color: #9ca3af; font-weight: 600; margin-bottom: 0.75rem; }
        .days-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.5rem; }

        .calendar-day { aspect-ratio: 1; padding: 0.5rem; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 0.75rem; display: flex; flex-direction: column; justify-content: space-between; cursor: pointer; transition: all 0.2s; position: relative; }
        .calendar-day:hover { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); }
        .day-number { font-weight: 600; font-size: 0.9rem; }
        .day-empty { opacity: 0.1; cursor: default; pointer-events: none; }
        .day-today { border-color: #4f46e5; background: rgba(79, 70, 229, 0.15); }
        .day-today .day-number { color: #a5b4fc; }

        /* Indicador de anotação interna no dia */
        .note-indicator { width: 6px; height: 6px; background: #06b6d4; border-radius: 50%; align-self: center; margin-bottom: 4px; box-shadow: 0 0 8px #06b6d4; }

        /* --- MODAL --- */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); display: flex; justify-content: center; align-items: center; z-index: 999; }
        .modal-card { background: #0f0e26; border: 1px solid rgba(255,255,255,0.1); width: 100%; max-width: 500px; border-radius: 1.5rem; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .modal-title { font-size: 1.25rem; margin: 0; font-weight: 600; }
        .close-btn { background: transparent; border: none; color: #6b7280; font-size: 1.75rem; cursor: pointer; }
        .close-btn:hover { color: white; }

        .form-group { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.25rem; }
        .form-label { font-size: 0.75rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; }
        .form-input, .form-textarea { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.75rem; padding: 0.75rem; color: white; outline: none; font-family: inherit; }
        .form-input:focus, .form-textarea:focus { border-color: #4f46e5; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.75rem; }
    </style>

    <script>
        // Transforma a coleção de anotações enviadas pelo Controller em um objeto JS indexável por data
        // Formato esperado do banco: ['2026-05-20' => 'Conteúdo da anotação', ...]
        const databaseNotes = {!! json_encode($annotations->pluck('content', 'date')) !!};

        let currentDate = new Date();


        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            // Atualiza o Título do Mês/Ano
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            document.getElementById('currentMonthYear').textContent = `${monthNames[month]} ${year}`;

            const daysContainer = document.getElementById('calendarDays');
            daysContainer.innerHTML = '';

            // Primeiro dia do mês corrente e total de dias
            const firstDayIndex = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();
            const today = new Date();

            // Renderiza espaços vazios para alinhar o dia da semana inicial
            for (let i = 0; i < firstDayIndex; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.classList.add('calendar-day', 'day-empty');
                daysContainer.appendChild(emptyDiv);
            }

            // Cria os blocos numéricos dos dias
            for (let day = 1; day <= totalDays; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendar-day');

                // Formata a string ISO da data corrente (YYYY-MM-DD)
                const meshMonth = String(month + 1).padStart(2, '0');
                const meshDay = String(day).padStart(2, '0');
                const dateString = `${year}-${meshMonth}-${meshDay}`;

                dayDiv.setAttribute('onclick', `openNoteModal('${dateString}')`);

                // Verifica se é o dia de hoje
                if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    dayDiv.classList.add('day-today');
                }

                // Cria o número do dia
                const numberSpan = document.createElement('span');
                numberSpan.classList.add('day-number');
                numberSpan.textContent = day;
                dayDiv.appendChild(numberSpan);

                // Se houver anotação salva nessa data no banco, insere o pontinho ciano indicador
                if (databaseNotes[dateString]) {
                    const indicator = document.createElement('div');
                    indicator.classList.add('note-indicator');
                    dayDiv.appendChild(indicator);
                }

                daysContainer.appendChild(dayDiv);
            }
        }

        function moveMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            renderCalendar();
        }

        function openNoteModal(dateString) {
            document.getElementById('noteDate').value = dateString;

            // Inverte a visualização para formato local no campo visual de leitura do modal
            const [y, m, d] = dateString.split('-');
            document.getElementById('selectedDateDisplay').value = `${d}/${m}/${y}`;

            // Puxa o conteúdo existente se houver, ou limpa para nova anotação
            document.getElementById('noteContent').value = databaseNotes[dateString] || '';

            document.getElementById('noteModal').classList.remove('hidden');
        }

        function closeNoteModal() {
            document.getElementById('noteModal').classList.add('hidden');
        }

        // Renderiza o calendário ao carregar a página pela primeira vez
        document.addEventListener('DOMContentLoaded', renderCalendar);
    </script>
@endsection
