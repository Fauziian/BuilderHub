@extends('layouts.app')
@section('title', 'Messenger')
@section('content')
<div style="background:linear-gradient(135deg,#0F0C20,#151030);color:#fff;min-height:92vh;padding:2rem 1rem">
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:350px 1fr;gap:1.5rem;height:78vh;background:rgba(255,255,255,0.03);backdrop-filter:blur(20px);border-radius:24px;border:1px solid rgba(255,255,255,0.1);overflow:hidden;box-shadow:0 20px 50px rgba(0,0,0,0.3)">
    
    <!-- LEFT PANEL: THREADS -->
    <div style="border-right:1px solid rgba(255,255,255,0.08);display:flex;flex-direction:column;background:rgba(0,0,0,0.2);min-height:0">
      <!-- Panel Header -->
      <div style="padding:1.5rem;border-bottom:1px solid rgba(255,255,255,0.08)">
        <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:1rem;display:flex;align-items:center;gap:8px">💬 Messenger Hub</h2>
        <!-- Thread Search -->
        <input type="text" id="threadSearch" placeholder="Cari kontak..." onkeyup="filterThreads()" style="width:100%;padding:10px 16px;border-radius:12px;border:1px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.05);color:#fff;font-size:.85rem;outline:none;transition:border-color .2s" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
      </div>

      <!-- Threads List -->
      <div id="threadsList" style="flex:1;overflow-y:auto;padding:.75rem">
        <div style="text-align:center;color:rgba(255,255,255,.4);font-size:.85rem;padding:2rem">Memuat daftar obrolan...</div>
      </div>

      <!-- Return Button -->
      <div style="padding:1rem;border-top:1px solid rgba(255,255,255,0.08);text-align:center">
        <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm" style="width:100%;font-weight:600;display:inline-flex;align-items:center;justify-content:center;gap:6px">
          ← Kembali ke Dashboard
        </a>
      </div>
    </div>

    <!-- RIGHT PANEL: CHAT WINDOW -->
    <div style="display:flex;flex-direction:column;background:rgba(0,0,0,0.1);min-height:0">
      <!-- Active Thread Header -->
      <div id="chatHeader" style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.08);display:none;align-items:center;justify-content:between;background:rgba(0,0,0,0.15)">
        <div style="display:flex;align-items:center;gap:.75rem">
          <div id="headerAvatar" style="width:42px;height:42px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.1rem;box-shadow:0 4px 10px rgba(0,0,0,0.2)"></div>
          <div>
            <div id="headerName" style="font-weight:800;font-size:1.05rem"></div>
            <div style="display:flex;align-items:center;gap:.5rem;margin-top:2px">
              <span id="headerRoleBadge" style="font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:99px"></span>
              <span id="headerContextLabel" style="font-size:.75rem;color:rgba(255,255,255,0.5)"></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Messages Area -->
      <div id="messagesArea" style="flex:1;overflow-y:auto;padding:1.5rem;display:flex;flex-direction:column;gap:.85rem">
        <!-- Default State -->
        <div id="chatPlaceholder" style="margin:auto;text-align:center;max-width:360px;padding:2rem">
          <div style="font-size:3.5rem;margin-bottom:1rem;filter:drop-shadow(0 10px 15px rgba(139,92,246,0.3))">💬</div>
          <h3 style="font-weight:800;font-size:1.25rem;margin-bottom:.5rem">Mari Berkolaborasi!</h3>
          <p style="font-size:.875rem;color:rgba(255,255,255,0.5);line-height:1.5">Pilih salah satu kontak di panel kiri untuk memulai chat diskusi, negosiasi project, atau tanya jawab materi course.</p>
        </div>
        <!-- Loaded messages go here -->
        <div id="messagesList" style="display:none"></div>
      </div>

      <!-- Input Bar -->
      <div id="chatInputArea" style="padding:1.25rem 1.5rem;border-top:1px solid rgba(255,255,255,0.08);background:rgba(0,0,0,0.15);display:none">
        <form onsubmit="handleSend(event)" style="display:flex;gap:.75rem;align-items:center">
          <input type="text" id="chatInput" placeholder="Tulis pesan Anda di sini..." autocomplete="off" style="flex:1;padding:12px 18px;border-radius:14px;border:1px solid rgba(255,255,255,0.15);background:rgba(255,255,255,0.06);color:#fff;font-size:.9rem;outline:none;transition:all .2s" onfocus="this.style.borderColor='var(--primary)';this.style.background='rgba(255,255,255,0.09)'" onblur="this.style.borderColor='rgba(255,255,255,0.15)';this.style.background='rgba(255,255,255,0.06)'">
          <button type="submit" class="btn btn-primary" style="padding:12px 24px;border-radius:14px;font-weight:700;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 15px rgba(79,70,229,0.4)">
            Kirim 🚀
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  let threads = [];
  let activeContactId = null;
  let activeProjectId = null;
  let activeCourseId = null;
  let pollInterval = null;

  // Initial params
  const paramContactId = "{{ $selectedContactId }}";
  const paramProjectId = "{{ $selectedProjectId }}";
  const paramCourseId = "{{ $selectedCourseId }}";

  document.addEventListener('DOMContentLoaded', () => {
    loadThreads().then(() => {
      if (paramContactId) {
        const matchingThread = threads.find(t => t.contact_id == paramContactId);
        if (matchingThread) {
          selectThread(matchingThread.contact_id, matchingThread.contact_name, matchingThread.contact_role, matchingThread.project_id || paramProjectId, matchingThread.course_id || paramCourseId);
        } else {
          // If not in existing threads list but requested, try loading direct
          selectThread(paramContactId, 'User #' + paramContactId, 'MESSENGER', paramProjectId, paramCourseId);
        }
      }
    });
  });

  async function loadThreads() {
    try {
      const response = await fetch("{{ route('chat.threads') }}", {
        headers: { 'Accept': 'application/json' }
      });
      threads = await response.json();
      renderThreads();
    } catch (e) {
      console.error(e);
    }
  }

  function renderThreads() {
    const listEl = document.getElementById('threadsList');
    if (!threads.length) {
      listEl.innerHTML = '<div style="text-align:center;color:rgba(255,255,255,.4);font-size:.82rem;padding:2rem">Belum ada relasi bisnis aktif untuk dihubungi.</div>';
      return;
    }

    listEl.innerHTML = threads.map(t => {
      const isSelected = activeContactId == t.contact_id;
      const initial = t.contact_name.charAt(0).toUpperCase();
      
      // Theme colors depending on role
      let badgeBg = 'var(--primary)';
      if (t.contact_role === 'UMKM') badgeBg = 'var(--accent)';
      if (t.contact_role === 'PELAJAR') badgeBg = 'var(--orange)';

      return `
        <div onclick="selectThread(${t.contact_id}, '${escapeQuote(t.contact_name)}', '${t.contact_role}', ${t.project_id}, ${t.course_id})" 
             style="display:flex;align-items:center;gap:.75rem;padding:12px;border-radius:16px;margin-bottom:6px;cursor:pointer;transition:all .2s;background:${isSelected ? 'rgba(79,70,229,0.15)' : 'transparent'};border:${isSelected ? '1px solid rgba(79,70,229,0.3)' : '1px solid transparent'}"
             class="thread-item"
             data-name="${t.contact_name.toLowerCase()}">
          
          <!-- Avatar -->
          <div style="width:40px;height:40px;border-radius:50%;background:${badgeBg};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1.1rem;box-shadow:0 2px 8px rgba(0,0,0,0.15);flex-shrink:0">
            ${initial}
          </div>

          <!-- Thread Meta -->
          <div style="flex:1;min-width:0">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
              <strong style="font-size:.9rem;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:140px">${t.contact_name}</strong>
              <span style="font-size:.7rem;font-weight:700;background:${badgeBg};color:#fff;padding:2px 8px;border-radius:99px;line-height:1">${t.contact_role}</span>
            </div>
            
            <div style="font-size:.78rem;color:rgba(255,255,255,.5);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:2px">
              ${t.last_message.replace(/</g,'&lt;')}
            </div>

            ${t.context_label ? `
              <div style="font-size:.7rem;color:var(--primary);font-weight:600;display:flex;align-items:center;gap:4px">
                ${t.context_label}
              </div>
            ` : ''}
          </div>

          <!-- Unread/Time -->
          <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0">
            <span style="font-size:.65rem;color:rgba(255,255,255,0.45)">${t.last_message_time}</span>
            ${t.unread_count > 0 ? `
              <span style="width:18px;height:18px;border-radius:50%;background:var(--red);color:#fff;font-size:.65rem;font-weight:800;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(239,68,68,0.4)">
                ${t.unread_count}
              </span>
            ` : ''}
          </div>
        </div>
      `;
    }).join('');
  }

  function filterThreads() {
    const q = document.getElementById('threadSearch').value.toLowerCase();
    document.querySelectorAll('.thread-item').forEach(el => {
      const name = el.getAttribute('data-name');
      el.style.display = name.includes(q) ? 'flex' : 'none';
    });
  }

  function selectThread(contactId, contactName, contactRole, projectId, courseId) {
    activeContactId = contactId;
    activeProjectId = projectId || null;
    activeCourseId = courseId || null;

    // Show Chat Workspace
    document.getElementById('chatPlaceholder').style.display = 'none';
    document.getElementById('chatHeader').style.display = 'flex';
    document.getElementById('messagesArea').style.display = 'flex';
    document.getElementById('messagesList').style.display = 'block';
    document.getElementById('chatInputArea').style.display = 'block';

    // Set Header
    const initial = contactName.charAt(0).toUpperCase();
    let badgeBg = 'var(--primary)';
    if (contactRole === 'UMKM') badgeBg = 'var(--accent)';
    if (contactRole === 'PELAJAR') badgeBg = 'var(--orange)';

    const avatarEl = document.getElementById('headerAvatar');
    avatarEl.textContent = initial;
    avatarEl.style.backgroundColor = badgeBg;
    
    document.getElementById('headerName').textContent = contactName;
    
    const badgeEl = document.getElementById('headerRoleBadge');
    badgeEl.textContent = contactRole;
    badgeEl.style.backgroundColor = badgeBg;

    let ctxText = '';
    if (projectId) ctxText = '💼 Negosiasi Project';
    else if (courseId) ctxText = '📚 Diskusi Belajar Course';
    document.getElementById('headerContextLabel').textContent = ctxText;

    // Load Messages
    loadMessages();
    renderThreads();

    // Start polling
    if (pollInterval) clearInterval(pollInterval);
    pollInterval = setInterval(() => { loadMessages(); loadThreads(); }, 3000);
  }

  async function loadMessages() {
    if (!activeContactId) return;
    try {
      const response = await fetch(window.APP_URL + `/api/chat/messages/${activeContactId}`);
      const msgs = await response.json();
      const listEl = document.getElementById('messagesList');
      
      if (!msgs.length) {
        listEl.innerHTML = '<div style="text-align:center;color:rgba(255,255,255,.3);font-size:.85rem;padding:3rem">Belum ada obrolan. Tulis pesan Anda di bawah!</div>';
        return;
      }

      listEl.innerHTML = msgs.map(m => `
        <div style="display:flex;flex-direction:column;align-items:${m.is_me ? 'flex-end' : 'flex-start'};margin-bottom:1rem">
          <div style="font-size:.68rem;color:rgba(255,255,255,.45);margin-bottom:3px;padding:0 4px">${m.sender} · ${m.created_at}</div>
          <div style="max-width:70%;padding:10px 16px;border-radius:${m.is_me ? '16px 16px 4px 16px' : '16px 16px 16px 4px'};background:${m.is_me ? 'var(--primary)' : 'rgba(255,255,255,0.08)'};border:1px solid ${m.is_me ? 'rgba(79,70,229,0.3)' : 'rgba(255,255,255,0.05)'};color:#fff;font-size:.875rem;line-height:1.5;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
            ${m.message.replace(/</g,'&lt;')}
          </div>
        </div>
      `).join('');

      // Scroll to bottom
      const area = document.getElementById('messagesArea');
      area.scrollTop = area.scrollHeight;
    } catch(e) {
      console.error(e);
    }
  }

  async function handleSend(e) {
    e.preventDefault();
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if (!msg) return;

    input.value = '';

    try {
      const response = await fetch("{{ route('chat.send') }}", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
          receiver_id: activeContactId,
          project_id: activeProjectId,
          course_id: activeCourseId,
          message: msg
        })
      });

      const res = await response.json();
      if (res.ok) {
        loadMessages();
        loadThreads();
      }
    } catch (e) {
      console.error(e);
    }
  }

  function escapeQuote(str) {
    return str.replace(/'/g, "\\'");
  }
</script>
@endsection
