<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Submit Profile</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-3">Submit Profile</h1>
    <form id="profileForm" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required />
      </div>
      <div class="col-md-3">
        <label class="form-label">Age</label>
        <input type="number" name="age" class="form-control" min="0" />
      </div>
      <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit</button>
        <a href="/profiles" class="btn btn-secondary">View Profiles</a>
        <a href="/" class="btn btn-link">Home</a>
      </div>
    </form>
    <div id="result" class="mt-3"></div>
  </div>

  <script>
    const form = document.getElementById('profileForm');
    const resultDiv = document.getElementById('result');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(form);
      const payload = Object.fromEntries(formData.entries());

      try {
        const res = await fetch('/api/submit', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Error');
        resultDiv.innerHTML = `<div class="alert alert-success">Created ID: ${data.data.id}</div>`;
        form.reset();
      } catch (err) {
        resultDiv.innerHTML = `<div class="alert alert-danger">${err.message}</div>`;
      }
    });
  </script>
</body>
</html>
