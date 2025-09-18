<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Profile</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
  </head>
  <body>
    <div class="top-left"><a class="btn-link" href="/Lists">View All Profiles</a></div>
    <main class="page">
      <div id="toast" class="toast" role="status" aria-live="polite" aria-atomic="true" hidden>Profile added to the list!</div>
      <section class="split" aria-labelledby="add-profile-title">
        <div class="panel-left">
          <div class="brand">
            <div class="brand-mark" aria-hidden="true"></div>
            <h1 class="brand-title">Starlink University</h1>
          </div>
          <div class="pattern" aria-hidden="true"></div>
        </div>
        <div class="panel-right">
          <div class="panel-right-inner">
            <h2 id="add-profile-title" class="title">Add New Profile</h2>
            <form id="profileForm" action="#" method="post" novalidate>
              <label class="sr-only" for="firstName">First Name</label>
              <input id="firstName" class="input" type="text" placeholder="First name" />
              <div class="spacer"></div>
              <label class="sr-only" for="lastName">Last Name</label>
              <input id="lastName" class="input" type="text" placeholder="Last name" />
              <div class="spacer"></div>
              <label class="sr-only" for="email">Email</label>
              <input id="email" class="input" type="email" placeholder="Email" />
              <div class="spacer"></div>
              <button id="submitProfile" class="btn btn-primary" type="submit">Add Profile</button>
            </form>
          </div>
        </div>
      </section>
    </main>

    <script>
      // Submit to backend API (MySQL) and show toast
      (function(){
        const form = document.getElementById('profileForm');
        const toast = document.getElementById('toast');

        function showToast(message, duration=1700) {
          if (!toast) return;
          toast.textContent = message;
          toast.hidden = false;
          requestAnimationFrame(() => toast.classList.add('show'));
          setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => { toast.hidden = true; }, 250);
          }, duration);
        }

        form.addEventListener('submit', async function(e){
          e.preventDefault();
          const first_name = document.getElementById('firstName').value.trim();
          const last_name  = document.getElementById('lastName').value.trim();
          const email      = document.getElementById('email').value.trim();
          if(!first_name){ showToast('First name is required', 1800); return; }
          if(!email){ showToast('Email is required', 1800); return; }
          try {
            const res = await fetch('/api/profiles', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
              body: JSON.stringify({ first_name, last_name, email })
            });
            if (!res.ok) {
              const err = await res.json().catch(()=>({}));
              const msg = err?.message || Object.values(err?.errors||{}).flat().join('\n') || 'Failed to add profile';
              showToast(msg, 2200);
              return;
            }
            form.reset();
            showToast('Profile added to the list!');
          } catch (error) {
            showToast('Network error. Please try again.');
          }
        });
      })();
    </script>
  </body>
</html>
