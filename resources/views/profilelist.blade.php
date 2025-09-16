<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profiles</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-3">Profiles</h1>
    <div class="mb-3">
      <a href="/submit" class="btn btn-primary">Add New</a>
      <a href="/" class="btn btn-link">Home</a>
    </div>

    <div id="alert"></div>

    <table class="table table-striped" id="profilesTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Age</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <script>
    const tableBody = document.querySelector('#profilesTable tbody');
    const alertBox = document.getElementById('alert');

    async function loadProfiles() {
      const res = await fetch('/api/profilelist');
      const json = await res.json();
      const rows = (json.data || []).map(p => `
        <tr>
          <td>${p.id}</td>
          <td><input class="form-control form-control-sm" value="${p.name}" data-field="name" data-id="${p.id}"></td>
          <td><input class="form-control form-control-sm" value="${p.email}" data-field="email" data-id="${p.id}"></td>
          <td><input class="form-control form-control-sm" value="${p.age ?? ''}" data-field="age" data-id="${p.id}" type="number" min="0"></td>
          <td>
            <button class="btn btn-sm btn-success" onclick="updateProfile(${p.id})">Save</button>
            <button class="btn btn-sm btn-danger" onclick="deleteProfile(${p.id})">Delete</button>
          </td>
        </tr>`).join('');
      tableBody.innerHTML = rows;
    }

    async function updateProfile(id) {
      const inputs = document.querySelectorAll(`[data-id="${id}"]`);
      const payload = {};
      inputs.forEach(i => payload[i.dataset.field] = i.value);
      try {
        const res = await fetch(`/api/profile/${id}`, {
          method: 'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Update failed');
        showAlert('Profile updated', 'success');
      } catch (e) {
        showAlert(e.message, 'danger');
      }
    }

    async function deleteProfile(id) {
      if (!confirm('Delete this profile?')) return;
      try {
        const res = await fetch(`/api/profile/${id}`, { method: 'DELETE' });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Delete failed');
        showAlert('Profile deleted', 'success');
        loadProfiles();
      } catch (e) {
        showAlert(e.message, 'danger');
      }
    }

    function showAlert(msg, type) {
      alertBox.innerHTML = `<div class="alert alert-${type}">${msg}</div>`;
      setTimeout(() => alertBox.innerHTML = '', 3000);
    }

    loadProfiles();
  </script>
</body>
</html>
