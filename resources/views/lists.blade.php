<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profiles</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
  <main>
    <div class="panel">
      <div class="nav"><a href="/">← Back to Home</a></div>
      <div class="header">
        <h2 class="title">Profiles <span class="muted">(<span id="count">0</span>)</span></h2>
        <div class="tools">
          <button id="toggleArchive" class="btn btn-outline" type="button">View Archived</button>
          <a class="btn btn-secondary" href="/">+ Add Profile</a>
          <input id="search" class="search" type="search" placeholder="Search customers..." />
        </div>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th id="th-first" class="sortable">First name <span id="si-first" class="sort-ind"></span></th>
              <th id="th-last" class="sortable">Last name <span id="si-last" class="sort-ind"></span></th>
              <th id="th-email" class="sortable">Email <span id="si-email" class="sort-ind"></span></th>
              <th style="width:200px">Actions</th>
            </tr>
          </thead>
          <tbody id="rows"></tbody>
        </table>
      </div>
      <!-- Toast notification -->
      <div id="toast" class="toast" role="status" aria-live="polite" aria-atomic="true" hidden></div>
    </div>
  </main>
  <script>
    (function(){
      const rows = document.getElementById('rows');
      const countEl = document.getElementById('count');
      const search = document.getElementById('search');
      const toggleBtn = document.getElementById('toggleArchive');
      const toast = document.getElementById('toast');
      let data = [];
      let editing = -1; // index in data
      let sortKey = 'first';
      let sortDir = 'asc';
      let mode = 'active'; // 'active' | 'archived'

      function showToast(message, duration=1600) {
        if (!toast) return;
        toast.textContent = message;
        toast.hidden = false;
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => {
          toast.classList.remove('show');
          setTimeout(() => { toast.hidden = true; }, 250);
        }, duration);
      }

      async function load(){
        try {
          const url = mode === 'archived' ? '/api/profiles/archived' : '/api/profiles';
          const res = await fetch(url, { headers: { 'Accept':'application/json' } });
          const arr = await res.json();
          data = (arr || []).map(p => ({ id: p.id, first: p.first_name || '', last: p.last_name || '', email: p.email || '' }));
        } catch (e) {
          data = [];
        }
      }

      function render(filter=''){
        const term = filter.toLowerCase();
        rows.innerHTML='';
        let shown = 0;
        // Build a filtered view with original indexes
        const view = data
          .map((u, idx) => ({ u, idx }))
          .filter(({u}) => {
            const hay = `${u.first} ${u.last} ${u.email}`.toLowerCase();
            return term ? hay.includes(term) : true;
          })
          .sort((a,b) => {
            const av = String(a.u[sortKey] || '').toLowerCase();
            const bv = String(b.u[sortKey] || '').toLowerCase();
            if (av < bv) return sortDir === 'asc' ? -1 : 1;
            if (av > bv) return sortDir === 'asc' ? 1 : -1;
            return 0;
          });

        // Update header indicators
        document.getElementById('si-first').textContent = sortKey==='first' ? (sortDir==='asc'?'▲':'▼') : '';
        document.getElementById('si-last').textContent = sortKey==='last' ? (sortDir==='asc'?'▲':'▼') : '';
        document.getElementById('si-email').textContent = sortKey==='email' ? (sortDir==='asc'?'▲':'▼') : '';

        view.forEach(({u, idx}) => {
          const tr = document.createElement('tr');
          if (idx === editing && mode === 'active') {
            tr.innerHTML = `
              <td><input class="cell-input" data-field="first" value="${u.first || ''}"></td>
              <td><input class="cell-input" data-field="last" value="${u.last || ''}"></td>
              <td><input class="cell-input" data-field="email" value="${u.email || ''}"></td>
              <td class="cell-actions">
                <a href="#" data-act="save" data-idx="${idx}" class="link">Save</a>
                <a href="#" data-act="cancel" data-idx="${idx}" class="link">Cancel</a>
              </td>`;
          } else {
            tr.innerHTML = `
              <td>${u.first || ''}</td>
              <td>${u.last || ''}</td>
              <td>${u.email || ''}</td>
              <td class="actions">
                ${mode==='active' ? `
                  <a href="#" data-act="edit" data-idx="${idx}" class="link">Edit</a>
                  <a href="#" data-act="del" data-idx="${idx}" class="link">Delete</a>
                  <a href="#" data-act="archive" data-idx="${idx}" class="link">Archive</a>
                ` : `
                  <a href="#" data-act="unarchive" data-idx="${idx}" class="link">Unarchive</a>
                  <a href="#" data-act="del" data-idx="${idx}" class="link">Delete</a>
                `}
              </td>`;
          }
          rows.appendChild(tr);
          shown++;
        });
        countEl.textContent = shown;
        // Update toggle button label
        toggleBtn.textContent = mode === 'archived' ? 'View Active' : 'View Archived';
      }

      rows.addEventListener('click', (e)=>{
        const a = e.target.closest('a[data-act]');
        if (!a) return;
        e.preventDefault();
        const i = Number(a.getAttribute('data-idx'));
        const act = a.getAttribute('data-act');
        if (act === 'del') {
          const u = data[i] || {first:'', last:'', email:''};
          const label = `${u.first || ''} ${u.last || ''}${u.email ? ' <'+u.email+'>' : ''}`.trim();
          const ok = confirm(`Delete this profile?\n\n${label}`);
          if (!ok) return;
          fetch(`/api/profiles/${data[i].id}`, { method:'DELETE' })
            .then(()=>{ data.splice(i,1); if (editing === i) editing = -1; render(search.value); })
            .catch(()=>{});
        } else if (act === 'edit') {
          editing = i;
          render(search.value);
        } else if (act === 'cancel') {
          editing = -1;
          render(search.value);
        } else if (act === 'save') {
          const row = a.closest('tr');
          const first = row.querySelector('input[data-field="first"]').value.trim();
          const last = row.querySelector('input[data-field="last"]').value.trim();
          const email = row.querySelector('input[data-field="email"]').value.trim();
          fetch(`/api/profiles/${data[i].id}`, {
            method:'PUT',
            headers: { 'Content-Type':'application/json', 'Accept':'application/json' },
            body: JSON.stringify({ first_name:first, last_name:last, email })
          })
          .then(async (res)=>{
            if(!res.ok){
              const err = await res.json().catch(()=>({}));
              alert((err && (Object.values(err.errors||{}).flat()[0])) || 'Update failed');
              return;
            }
            data[i] = { ...data[i], first, last, email };
            editing = -1;
            render(search.value);
          })
          .catch(()=>{});
        } else if (act === 'archive') {
          const u = data[i] || {first:'', last:'', email:''};
          const label = `${u.first || ''} ${u.last || ''}${u.email ? ' <'+u.email+'>' : ''}`.trim();
          const ok = confirm(`Archive this profile?\n\n${label}`);
          if (!ok) return;
          fetch(`/api/profiles/${data[i].id}/archive`, { method:'POST', headers: { 'Accept':'application/json' } })
            .then(async (res)=>{
              if (!res.ok) { return; }
              // Remove from current list when archived
              data.splice(i,1);
              render(search.value);
              showToast('Profile archived');
            })
            .catch(()=>{});
        } else if (act === 'unarchive') {
          fetch(`/api/profiles/${data[i].id}/unarchive`, { method:'POST', headers: { 'Accept':'application/json' } })
            .then(async (res)=>{
              if (!res.ok) { return; }
              // Remove from current list when unarchived
              data.splice(i,1);
              render(search.value);
              showToast('Profile unarchived');
            })
            .catch(()=>{});
        }
      });

      search.addEventListener('input', ()=> render(search.value));

      // Toggle between active and archived views
      toggleBtn.addEventListener('click', async ()=>{
        editing = -1;
        mode = (mode === 'active') ? 'archived' : 'active';
        await load();
        render(search.value);
      });

      function toggleSort(key){
        if (sortKey === key) {
          sortDir = sortDir === 'asc' ? 'desc' : 'asc';
        } else {
          sortKey = key; sortDir = 'asc';
        }
        render(search.value);
      }

      document.getElementById('th-first').addEventListener('click', ()=> toggleSort('first'));
      document.getElementById('th-last').addEventListener('click', ()=> toggleSort('last'));
      document.getElementById('th-email').addEventListener('click', ()=> toggleSort('email'));
      document.getElementById('th-age').addEventListener('click', ()=> toggleSort('age'));

      (async function(){
        await load();
        render();
      })();
    })();
  </script>
</body>
</html>
