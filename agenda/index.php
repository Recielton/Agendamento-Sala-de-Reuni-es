<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Agendamento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    :root{
      --primary-blue:#3b82f6;
      --bg-light:#f0f7ff;
      --card-bg:#ffffff;
      --text-muted:#6b7280;
    }
    body{
      background:var(--bg-light);
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      color:#1f2937;
    }
    .top-bar{
      background:#fff;
      padding:1rem 0;
      box-shadow:0 1px 3px rgba(0,0,0,0.05);
      margin-bottom:1.5rem;
    }
    .top-bar h5{
      color:var(--primary-blue);
      font-weight:600;
      margin:0;
      font-size:1.25rem;
    }
    .top-bar .time-display{
      color:var(--text-muted);
      font-size:0.95rem;
    }
    .top-bar .btn-settings{
      background:transparent;
      border:none;
      color:var(--primary-blue);
      font-size:1.3rem;
      cursor:pointer;
      transition:all 0.3s ease;
    }
    .top-bar .btn-settings:hover{
      transform:rotate(90deg);
      color:#2563eb;
    }
    .hero-section{
      background:linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
      border-radius:16px;
      padding:2rem;
      margin-bottom:1.5rem;
      transition:all 0.3s ease;
    }
    .hero-section:hover{
      box-shadow:0 8px 24px rgba(59,130,246,0.15);
      transform:translateY(-2px);
    }
    .hero-section h2{
      color:var(--primary-blue);
      font-weight:700;
      font-size:1.75rem;
      margin-bottom:0.5rem;
    }
    .hero-section p{
      color:var(--text-muted);
      margin-bottom:1.5rem;
    }
    .btn-novo{
      background:var(--primary-blue);
      color:#fff;
      border:none;
      border-radius:12px;
      padding:0.75rem 1.5rem;
      font-weight:600;
      box-shadow:0 4px 12px rgba(59,130,246,0.3);
      transition:all 0.3s ease;
    }
    .btn-novo:hover{
      background:#2563eb;
      color:#fff;
      transform:translateY(-2px);
      box-shadow:0 6px 20px rgba(59,130,246,0.4);
    }
    .stats-card{
      background:#fff;
      border-radius:16px;
      padding:1.5rem;
      box-shadow:0 2px 8px rgba(0,0,0,0.06);
      text-align:center;
      transition:all 0.3s ease;
      cursor:pointer;
    }
    .stats-card:hover{
      transform:translateY(-5px);
      box-shadow:0 8px 24px rgba(59,130,246,0.15);
    }
    .stats-card .icon-box{
      width:64px;
      height:64px;
      background:var(--primary-blue);
      border-radius:12px;
      display:flex;
      align-items:center;
      justify-content:center;
      margin:0 auto 1rem;
      color:#fff;
      font-size:1.75rem;
      transition:all 0.3s ease;
    }
    .stats-card:hover .icon-box{
      transform:scale(1.1) rotate(5deg);
    }
    .stats-card .number{
      font-size:2.5rem;
      font-weight:700;
      color:var(--primary-blue);
      margin:0;
    }
    .stats-card .label{
      color:var(--text-muted);
      font-size:0.85rem;
      text-transform:uppercase;
      font-weight:600;
      letter-spacing:0.5px;
    }
    .calendar-section{
      background:#fff;
      border-radius:16px;
      padding:1.5rem;
      box-shadow:0 2px 8px rgba(0,0,0,0.06);
      margin-bottom:1.5rem;
      transition:all 0.3s ease;
    }
    .calendar-section:hover{
      box-shadow:0 4px 16px rgba(0,0,0,0.1);
    }
    .calendar-section h5{
      color:var(--primary-blue);
      font-weight:700;
      margin-bottom:1rem;
    }
    .filter-pills{
      display:flex;
      gap:0.5rem;
      align-items:center;
      margin-bottom:1rem;
    }
    .filter-pills .label{
      color:var(--text-muted);
      font-weight:600;
      font-size:0.9rem;
    }
    .filter-pill{
      background:var(--primary-blue);
      color:#fff;
      border:none;
      border-radius:20px;
      padding:0.4rem 1rem;
      font-size:0.85rem;
      font-weight:600;
      cursor:pointer;
      transition:all 0.3s ease;
    }
    .filter-pill:hover{
      background:#2563eb;
      transform:translateY(-2px);
      box-shadow:0 4px 12px rgba(59,130,246,0.3);
    }
    .filter-pill.inactive{
      background:#e5e7eb;
      color:#6b7280;
    }
    .filter-pill.inactive:hover{
      background:#d1d5db;
    }
    .week-calendar{
      display:grid;
      grid-template-columns:repeat(5, 1fr);
      gap:0.75rem;
      margin-top:1rem;
    }
    .day-col{
      background:#f9fafb;
      border-radius:8px;
      padding:0.75rem 0.5rem;
      min-height:120px;
      transition:all 0.3s ease;
      position:relative;
    }
    .day-col:hover{
      background:#f3f4f6;
      box-shadow:0 4px 12px rgba(0,0,0,0.08);
      transform:translateY(-2px);
    }
    .day-header{
      text-align:center;
      margin-bottom:0.5rem;
    }
    .day-name{
      font-size:0.75rem;
      color:var(--text-muted);
      text-transform:uppercase;
      font-weight:600;
    }
    .day-number{
      font-size:1.25rem;
      font-weight:700;
      color:var(--primary-blue);
    }
    .event-item{
      background:#fff;
      border-left:3px solid var(--primary-blue);
      border-radius:4px;
      padding:0.4rem;
      margin-bottom:0.4rem;
      font-size:0.75rem;
      cursor:pointer;
      box-shadow:0 1px 3px rgba(0,0,0,0.08);
      transition:all 0.3s ease;
    }
    .event-item:hover{
      box-shadow:0 4px 12px rgba(0,0,0,0.15);
      transform:translateX(4px);
    }
    .event-time{
      color:var(--primary-blue);
      font-weight:700;
    }
    .event-title{
      color:#1f2937;
      font-weight:600;
    }
    .event-room{
      color:var(--text-muted);
      font-size:0.7rem;
    }
    .btn-add-event{
      position:absolute;
      bottom:0.5rem;
      left:0.5rem;
      background:var(--primary-blue);
      color:#fff;
      border:none;
      border-radius:50%;
      width:28px;
      height:28px;
      display:flex;
      align-items:center;
      justify-content:center;
      font-size:0.9rem;
      cursor:pointer;
      transition:all 0.3s ease;
      opacity:0;
    }
    .day-col:hover .btn-add-event{
      opacity:1;
    }
    .btn-add-event:hover{
      background:#2563eb;
      transform:scale(1.15);
    }
    .table-section{
      background:#fff;
      border-radius:16px;
      padding:1.5rem;
      box-shadow:0 2px 8px rgba(0,0,0,0.06);
      margin-bottom:1.5rem;
      transition:all 0.3s ease;
    }
    .table-section:hover{
      box-shadow:0 4px 16px rgba(0,0,0,0.1);
    }
    .table-section h5{
      color:var(--primary-blue);
      font-weight:700;
      margin-bottom:1rem;
    }
    .table thead{
      background:var(--primary-blue);
      color:#fff;
    }
    .table thead th{
      border:none;
      font-weight:600;
      padding:0.75rem;
    }
    .table tbody td{
      padding:0.75rem;
      vertical-align:middle;
    }
    .table tbody tr{
      transition:all 0.3s ease;
    }
    .table tbody tr:hover{
      background:#f0f7ff;
      transform:scale(1.01);
    }
    .badge-sala{
      background:var(--primary-blue);
      color:#fff;
      border-radius:20px;
      padding:0.4rem 0.8rem;
      font-weight:600;
      font-size:0.8rem;
      transition:all 0.3s ease;
    }
    .badge-sala:hover{
      transform:scale(1.05);
    }
    .action-btn{
      border:none;
      border-radius:6px;
      padding:0.4rem 0.6rem;
      margin:0 0.2rem;
      cursor:pointer;
      font-size:0.9rem;
      transition:all 0.3s ease;
    }
    .action-btn:hover{
      transform:translateY(-2px);
      box-shadow:0 4px 8px rgba(0,0,0,0.2);
    }
    .action-btn.view{background:#3b82f6;color:#fff}
    .action-btn.edit{background:#f59e0b;color:#fff}
    .action-btn.delete{background:#ef4444;color:#fff}
    .footer{
      text-align:center;
      padding:2rem 0;
      color:var(--text-muted);
      font-size:0.85rem;
    }
    .modal-header{
      background:var(--primary-blue);
      color:#fff;
      border-radius:12px 12px 0 0;
    }
    .modal-header .btn-close{
      filter:invert(1);
    }
    .nav-arrows{
      display:flex;
      gap:0.5rem;
      align-items:center;
    }
    .nav-arrow{
      background:var(--primary-blue);
      color:#fff;
      border:none;
      border-radius:50%;
      width:36px;
      height:36px;
      display:flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      transition:all 0.3s ease;
    }
    .nav-arrow:hover{
      background:#2563eb;
      transform:scale(1.1);
    }
    .date-range{
      font-weight:600;
      color:#1f2937;
    }
  </style>
</head>
<body>
  <div class="top-bar">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h5><i class="far fa-calendar-alt"></i> Sistema de Agendamento</h5>
        <div class="d-flex align-items-center gap-3">
          <span class="time-display" id="manausTime">2025/11/17 23:01:02</span>
          <button class="btn-settings" id="btnSettings"><i class="fas fa-cog"></i></button>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="hero-section">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2><i class="far fa-clock"></i> Dashboard de Agendamentos</h2>
          <p class="mb-0"><i class="fas fa-info-circle"></i> Bem-vindo ao sistema de agendamento de salas de reuniões</p>
        </div>
        <button class="btn-novo" id="btnNovo">+ Novo Agendamento</button>
      </div>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="stats-card">
          <div class="icon-box"><i class="far fa-calendar-check"></i></div>
          <h3 class="number" id="countToday">0</h3>
          <p class="label">Reuniões Hoje</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stats-card">
          <div class="icon-box"><i class="far fa-clock"></i></div>
          <h3 class="number" id="count7">0</h3>
          <p class="label">Próximas 7 Dias</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stats-card">
          <div class="icon-box"><i class="fas fa-door-open"></i></div>
          <h3 class="number" id="countRooms">4</h3>
          <p class="label">Salas Disponíveis</p>
        </div>
      </div>
    </div>

    <div class="calendar-section">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5><i class="far fa-calendar"></i> Calendário Semanal</h5>
        <div class="nav-arrows">
          <button class="nav-arrow" id="prevWeek"><i class="fas fa-chevron-left"></i></button>
          <span class="date-range" id="dateRange">16 Nov - 22 Nov 2025</span>
          <button class="nav-arrow" id="nextWeek"><i class="fas fa-chevron-right"></i></button>
        </div>
      </div>
      <div class="filter-pills">
        <span class="label"><i class="fas fa-filter"></i> Filtrar por Sala:</span>
        <button class="filter-pill" data-room="TODAS">TODAS</button>
        <button class="filter-pill inactive" data-room="SALA 00">SALA 00</button>
        <button class="filter-pill inactive" data-room="SALA 01">SALA 01</button>
        <button class="filter-pill inactive" data-room="SALA 02">SALA 02</button>
        <button class="filter-pill inactive" data-room="SALA GERENCIAL">GERENCIAL</button>
      </div>
      <div class="week-calendar" id="weekCalendar"></div>
    </div>

    <div class="table-section">
      <h5><i class="fas fa-list"></i> Todos os Agendamentos</h5>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Sala</th>
              <th>Título</th>
              <th>Responsável</th>
              <th>Data Início</th>
              <th>Data Fim</th>
              <th>Horário</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
      </div>
    </div>

    <div class="footer">
      <p><i class="far fa-calendar-alt"></i> Sistema de Agendamento</p>
      <p>© 2025 Sistema de Agendamento. Todos os direitos reservados.</p>
      <p><i class="fas fa-code"></i> Desenvolvido com Bootstrap & SweetAlert2</p>
    </div>
  </div>

  <!-- Modal Configurações -->
  <div class="modal fade" id="modalSettings" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-cog"></i> Configurações</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="formSettings">
          <div class="modal-body">
            <h6 class="mb-3">Alterar Senha de Administrador</h6>
            <div class="mb-3">
              <label class="form-label">Senha Atual</label>
              <input type="password" id="currentPassword" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Nova Senha</label>
              <input type="password" id="newPassword" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Confirmar Nova Senha</label>
              <input type="password" id="confirmPassword" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar Senha</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Novo/Editar -->
  <div class="modal fade" id="modalAgendamento" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Novo Agendamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="formAgendamento">
          <div class="modal-body">
            <input type="hidden" id="eventId">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Sala</label>
                <select id="sala" class="form-select" required>
                  <option value="SALA 00">SALA 00</option>
                  <option value="SALA 01">SALA 01</option>
                  <option value="SALA 02">SALA 02</option>
                  <option value="SALA GERENCIAL">SALA GERENCIAL</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Responsável</label>
                <input type="text" id="responsavel" class="form-control" required>
              </div>
              <div class="col-12">
                <label class="form-label">Título da Reunião</label>
                <input type="text" id="titulo" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Data/Hora Início</label>
                <input type="datetime-local" id="start" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Data/Hora Término</label>
                <input type="datetime-local" id="end" class="form-control" required>
              </div>
              <div class="col-12">
                <label class="form-label">Descrição da Reunião</label>
                <textarea id="descricao" class="form-control" rows="3"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Detalhes -->
  <div class="modal fade" id="modalDetalhes" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalhes da Reunião</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="detalhesBody"></div>
        <div class="modal-footer">
          <button class="btn btn-danger" id="btnDelete">Excluir</button>
          <button class="btn btn-warning" id="btnEdit">Editar</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const API_BASE = './api.php'; // ajuste conforme necessário
    const ZONE = 'America/Manaus';
    const ROOMS = ['SALA 00','SALA 01','SALA 02','SALA GERENCIAL'];
    const DateTime = luxon.DateTime;

    const modalAgendamento = new bootstrap.Modal(document.getElementById('modalAgendamento'));
    const modalDetalhes = new bootstrap.Modal(document.getElementById('modalDetalhes'));
    const modalSettings = new bootstrap.Modal(document.getElementById('modalSettings'));
    const form = document.getElementById('formAgendamento');
    const formSettings = document.getElementById('formSettings');

    let eventos = [];
    let currentFilter = 'TODAS';
    let currentWeekStart = DateTime.now().setZone(ZONE).startOf('week');
    let selectedDate = null;

    function updateManausClock(){
      document.getElementById('manausTime').textContent = DateTime.now().setZone(ZONE).toFormat('yyyy/LL/dd HH:mm:ss');
    }
    setInterval(updateManausClock, 1000);
    updateManausClock();

    async function loadEvents(){
      try {
        const res = await fetch(API_BASE + '/events');
        const data = await res.json();
        if(data.ok) eventos = data.events;
        else console.error('Erro ao carregar eventos:', data.error);
      } catch(e){ console.error('Erro ao carregar eventos:', e); }
    }

    async function changePassword(){
      const current = document.getElementById('currentPassword').value;
      const newPass = document.getElementById('newPassword').value;
      const confirm = document.getElementById('confirmPassword').value;

      if(newPass !== confirm){
        Swal.fire('Erro','As senhas não coincidem','error');
        return;
      }

      if(newPass.length < 4){
        Swal.fire('Erro','A senha deve ter pelo menos 4 caracteres','error');
        return;
      }

      try {
        const res = await fetch(API_BASE + '/admin/change-password', {
          method: 'POST',
          headers: {'Content-Type':'application/json'},
          body: JSON.stringify({current_password: current, new_password: newPass, confirm_password: confirm})
        });
        const data = await res.json();
        if(data.ok){
          Swal.fire('Sucesso','Senha alterada com sucesso','success');
          modalSettings.hide();
          formSettings.reset();
        } else {
          Swal.fire('Erro', data.error || 'Erro ao alterar senha','error');
        }
      } catch(e){
        Swal.fire('Erro','Erro ao conectar com servidor','error');
      }
    }

    async function verifyAdminPassword(){
      const { value: password } = await Swal.fire({
        title: 'Senha de Administrador',
        input: 'password',
        inputLabel: 'Digite a senha de administrador',
        inputPlaceholder: 'Senha',
        inputAttributes: { autocapitalize: 'off', autocorrect: 'off' },
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
      });

      if(!password) return null;
      return password;
    }

    function renderWeekCalendar(){
      const weekEnd = currentWeekStart.plus({days:4});
      document.getElementById('dateRange').textContent = currentWeekStart.toFormat('dd LLL') + ' - ' + weekEnd.toFormat('dd LLL yyyy');

      const container = document.getElementById('weekCalendar');
      container.innerHTML = '';

      const dayNames = ['SEG','TER','QUA','QUI','SEX'];

      for(let i=0; i<5; i++){
        const day = currentWeekStart.plus({days:i});
        const dayCol = document.createElement('div');
        dayCol.className = 'day-col';

        const header = document.createElement('div');
        header.className = 'day-header';
        header.innerHTML = `<div class="day-name">${dayNames[i]}</div><div class="day-number">${day.day}</div>`;
        dayCol.appendChild(header);

        const dayStart = day.startOf('day');
        const dayEnd = day.endOf('day');

        const dayEvents = eventos.filter(ev=>{
          if(currentFilter !== 'TODAS' && ev.room !== currentFilter) return false;
          const evStart = DateTime.fromSQL(ev.start, {zone:ZONE});
          return evStart >= dayStart && evStart <= dayEnd;
        });

        dayEvents.forEach(ev=>{
          const evStart = DateTime.fromSQL(ev.start, {zone:ZONE});
          const eventDiv = document.createElement('div');
          eventDiv.className = 'event-item';
          eventDiv.innerHTML = `
            <div class="event-time">${evStart.toFormat('HH:mm')}</div>
            <div class="event-title">${ev.title}</div>
            <div class="event-room">${ev.room}</div>
          `;
          eventDiv.addEventListener('click', ()=> openDetailsById(ev.id));
          dayCol.appendChild(eventDiv);
        });

        const btnAdd = document.createElement('button');
        btnAdd.className = 'btn-add-event';
        btnAdd.innerHTML = '<i class="fas fa-plus"></i>';
        btnAdd.title = 'Adicionar reunião';
        btnAdd.addEventListener('click', (e)=>{
          e.stopPropagation();
          selectedDate = day;
          openNewModalWithDate(day);
        });
        dayCol.appendChild(btnAdd);

        container.appendChild(dayCol);
      }
    }

    function renderTable(){
      const tbody = document.getElementById('tableBody');
      tbody.innerHTML = '';
      const sorted = eventos.slice().sort((a,b)=> new Date(a.start) - new Date(b.start));
      sorted.forEach(ev=>{
        const s = DateTime.fromSQL(ev.start, {zone:ZONE}).toFormat('dd/LL/yyyy');
        const e = DateTime.fromSQL(ev.end, {zone:ZONE}).toFormat('dd/LL/yyyy');
        const horario = DateTime.fromSQL(ev.start, {zone:ZONE}).toFormat('HH:mm') + ' - ' + DateTime.fromSQL(ev.end, {zone:ZONE}).toFormat('HH:mm');
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td><span class="badge-sala">${ev.room}</span></td>
          <td>${ev.title}</td>
          <td>${ev.responsavel || ''}</td>
          <td>${s}</td>
          <td>${e}</td>
          <td>${horario}</td>
          <td>
            <button class="action-btn view" data-id="${ev.id}" title="Ver"><i class="fas fa-eye"></i></button>
            <button class="action-btn edit" data-id="${ev.id}" title="Editar"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete" data-id="${ev.id}" title="Excluir"><i class="fas fa-trash"></i></button>
          </td>
        `;
        tbody.appendChild(tr);
      });

      document.querySelectorAll('.action-btn.view').forEach(b=> b.addEventListener('click', ()=> openDetailsById(b.dataset.id)));
      document.querySelectorAll('.action-btn.edit').forEach(b=> b.addEventListener('click', async ()=> {
        const pw = await verifyAdminPassword();
        if(pw) populateEditForm(b.dataset.id, pw);
      }));
      document.querySelectorAll('.action-btn.delete').forEach(b=> b.addEventListener('click', async ()=> {
        const pw = await verifyAdminPassword();
        if(pw) confirmDelete(b.dataset.id, pw);
      }));
    }

    function updateCounts(){
      const todayStart = DateTime.now().setZone(ZONE).startOf('day');
      const todayEnd = todayStart.endOf('day');
      const in7 = DateTime.now().setZone(ZONE).plus({days:7});
      const countToday = eventos.filter(ev=>{ const s = DateTime.fromSQL(ev.start, {zone:ZONE}); return s>=todayStart && s<=todayEnd; }).length;
      const count7 = eventos.filter(ev=>{ const s = DateTime.fromSQL(ev.start, {zone:ZONE}); return s>=DateTime.now().setZone(ZONE) && s<=in7; }).length;
      document.getElementById('countToday').textContent = countToday;
      document.getElementById('count7').textContent = count7;
      document.getElementById('countRooms').textContent = ROOMS.length;
    }

    function openNewModal(){
      document.getElementById('modalTitle').textContent = 'Novo Agendamento';
      form.reset();
      document.getElementById('eventId').value = '';
      modalAgendamento.show();
    }

    function openNewModalWithDate(date){
      document.getElementById('modalTitle').textContent = 'Novo Agendamento';
      form.reset();
      document.getElementById('eventId').value = '';
      const startTime = date.set({hour:9, minute:0}).toFormat("yyyy-LL-dd'T'HH:mm");
      const endTime = date.set({hour:10, minute:0}).toFormat("yyyy-LL-dd'T'HH:mm");
      document.getElementById('start').value = startTime;
      document.getElementById('end').value = endTime;
      modalAgendamento.show();
    }

    function openDetailsById(id){
      const ev = eventos.find(x=>x.id==id);
      if(!ev) return;
      const start = DateTime.fromSQL(ev.start, {zone:ZONE}).toFormat('dd/LL/yyyy HH:mm');
      const end = DateTime.fromSQL(ev.end, {zone:ZONE}).toFormat('dd/LL/yyyy HH:mm');
      const html = `
        <p><strong>Sala:</strong> ${ev.room}</p>
        <p><strong>Título:</strong> ${ev.title}</p>
        <p><strong>Responsável:</strong> ${ev.responsavel || ''}</p>
        <p><strong>Início:</strong> ${start}</p>
        <p><strong>Término:</strong> ${end}</p>
        <p><strong>Descrição:</strong><br/>${ev.descricao || ''}</p>
      `;
      document.getElementById('detalhesBody').innerHTML = html;
      modalDetalhes.show();
      document.getElementById('btnDelete').onclick = async ()=> {
        const pw = await verifyAdminPassword();
        if(pw) confirmDelete(id, pw);
      };
      document.getElementById('btnEdit').onclick = async ()=>{
        const pw = await verifyAdminPassword();
        if(pw){ modalDetalhes.hide(); populateEditForm(id, pw); }
      };
    }

    function populateEditForm(id, adminPassword){
      const ev = eventos.find(x=>x.id==id);
      if(!ev) return;
      document.getElementById('modalTitle').textContent = 'Editar Agendamento';
      document.getElementById('eventId').value = ev.id;
      document.getElementById('eventId').dataset.adminPassword = adminPassword;
      document.getElementById('sala').value = ev.room;
      document.getElementById('responsavel').value = ev.responsavel || '';
      document.getElementById('titulo').value = ev.title || '';
      document.getElementById('start').value = DateTime.fromSQL(ev.start, {zone:ZONE}).toFormat("yyyy-LL-dd'T'HH:mm");
      document.getElementById('end').value = DateTime.fromSQL(ev.end, {zone:ZONE}).toFormat("yyyy-LL-dd'T'HH:mm");
      document.getElementById('descricao').value = ev.descricao || '';
      modalAgendamento.show();
    }

    async function saveForm(){
      const id = document.getElementById('eventId').value;
      const room = document.getElementById('sala').value;
      const responsavel = document.getElementById('responsavel').value.trim();
      const titulo = document.getElementById('titulo').value.trim();
      const startVal = document.getElementById('start').value;
      const endVal = document.getElementById('end').value;
      const descricao = document.getElementById('descricao').value;

      if(!startVal || !endVal){ Swal.fire('Erro','Preencha datas e horários','error'); return; }
      const startDT = DateTime.fromFormat(startVal, "yyyy-LL-dd'T'HH:mm", { zone: ZONE });
      const endDT = DateTime.fromFormat(endVal, "yyyy-LL-dd'T'HH:mm", { zone: ZONE });
      if(!startDT.isValid || !endDT.isValid){ Swal.fire('Erro','Datas inválidas','error'); return; }
      if(endDT <= startDT){ Swal.fire('Erro','Data/Hora término deve ser maior que início','error'); return; }

      const payload = {
        title: titulo,
        room: room,
        responsavel: responsavel,
        descricao: descricao,
        start: startDT.toFormat('yyyy-LL-dd HH:mm:ss'),
        end: endDT.toFormat('yyyy-LL-dd HH:mm:ss')
      };

      try {
        if(id){
          // editar
          const adminPassword = document.getElementById('eventId').dataset.adminPassword;
          payload.admin_password = adminPassword;
          const res = await fetch(API_BASE + '/events/' + id, {
            method: 'PUT',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify(payload)
          });
          const data = await res.json();
          if(data.ok){
            Swal.fire('Salvo','Agendamento atualizado','success');
            modalAgendamento.hide();
            await refresh();
          } else {
            Swal.fire('Erro', data.error || 'Erro ao atualizar','error');
          }
        } else {
          // criar
          const res = await fetch(API_BASE + '/events', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify(payload)
          });
          const data = await res.json();
          if(data.ok){
            Swal.fire('Salvo','Agendamento criado','success');
            modalAgendamento.hide();
            await refresh();
          } else {
            Swal.fire('Erro', data.error || 'Erro ao criar','error');
          }
        }
      } catch(e){
        Swal.fire('Erro','Erro ao conectar com servidor','error');
      }
    }

    async function confirmDelete(id, adminPassword){
      const result = await Swal.fire({ 
        title:'Excluir agendamento?', 
        text:'Ação não pode ser desfeita', 
        icon:'warning', 
        showCancelButton:true, 
        confirmButtonText:'Sim, excluir', 
        cancelButtonText:'Cancelar' 
      });
      if(result.isConfirmed){
        await deleteEvent(id, adminPassword);
        modalDetalhes.hide();
      }
    }

    async function deleteEvent(id, adminPassword){
      try {
        const res = await fetch(API_BASE + '/events/' + id, {
          method: 'DELETE',
          headers: {'Content-Type':'application/json'},
          body: JSON.stringify({admin_password: adminPassword})
        });
        const data = await res.json();
        if(data.ok){
          await refresh();
          Swal.fire('Excluído','Agendamento removido','success');
        } else {
          Swal.fire('Erro', data.error || 'Erro ao excluir','error');
        }
      } catch(e){
        Swal.fire('Erro','Erro ao conectar com servidor','error');
      }
    }

    async function refresh(){
      await loadEvents();
      renderWeekCalendar();
      renderTable();
      updateCounts();
    }

    document.addEventListener('DOMContentLoaded', async ()=>{
      await loadEvents();
      renderWeekCalendar();
      renderTable();
      updateCounts();

      document.getElementById('btnNovo').addEventListener('click', openNewModal);
      document.getElementById('btnSettings').addEventListener('click', ()=> modalSettings.show());
      form.addEventListener('submit', e=>{ e.preventDefault(); saveForm(); });
      formSettings.addEventListener('submit', e=>{ e.preventDefault(); changePassword(); });

      document.querySelectorAll('.filter-pill').forEach(pill => pill.addEventListener('click', ()=>{
        document.querySelectorAll('.filter-pill').forEach(p=>{ p.classList.remove('inactive'); p.classList.add('inactive'); });
        pill.classList.remove('inactive');
        currentFilter = pill.dataset.room;
        renderWeekCalendar();
      }));

      document.getElementById('prevWeek').addEventListener('click', ()=>{
        currentWeekStart = currentWeekStart.minus({weeks:1});
        renderWeekCalendar();
      });

      document.getElementById('nextWeek').addEventListener('click', ()=>{
        currentWeekStart = currentWeekStart.plus({weeks:1});
        renderWeekCalendar();
      });
    });
  </script>
</body>
</html>
