<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
</head>
<body>
  <div class="layout">
    <aside class="sidebar">
      <div class="logo">
        <img src="{{ asset('images/8907269.png') }}" alt="Starlink" style="width:48px;height:48px;border-radius:10px;object-fit:cover;">
        <div style="font-weight:800;font-size:16px;">Starlink University</div>
      </div>
      <div style="margin-top:24px;margin-bottom:8px;font-size:13px;font-weight:700;opacity:.7;">Home ▲</div>
      <nav class="menu">
        <a href="{{ route('admin.dashboard') }}" class="active">📊 Dashboard</a>
        <a href="#">Students</a>
        <a href="#">Faculty</a>
        <a href="#">Archives</a>
      </nav>
    </aside>

    <div>
      <header class="topbar">
        <div class="search"><input type="text" placeholder="What do you wanna find?" /></div>
        <div style="display:flex;gap:12px;align-items:center;">
          <div style="position:relative;">
            <span style="font-size:24px;cursor:pointer;">🔔</span>
            <span style="position:absolute;top:-4px;right:-4px;background:#ef4444;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;">1</span>
          </div>
          <div style="position:relative;">
            <span style="font-size:24px;cursor:pointer;">📧</span>
            <span style="position:absolute;top:-4px;right:-4px;background:#ef4444;color:#fff;border-radius:50%;width:18px;height:18px;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;">1</span>
          </div>
          <div style="position:relative;">
            <div onclick="toggleDropdown()" style="cursor:pointer;width:42px;height:42px;border-radius:50%;background:#fbbf24;display:flex;align-items:center;justify-content:center;font-size:24px;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.15);">
              👨‍🎓
            </div>
            <div id="profileDropdown" style="display:none;position:absolute;top:52px;right:0;background:#fff;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.15);min-width:200px;overflow:hidden;z-index:1000;">
              <a href="#" style="display:flex;align-items:center;gap:12px;padding:14px 18px;text-decoration:none;color:#1f2937;font-weight:600;border-bottom:1px solid #f3f4f6;transition:background .2s;">
                <span style="font-size:20px;">⚙️</span>
                <span>Settings</span>
                <span style="margin-left:auto;width:22px;height:22px;background:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;">!</span>
              </a>
              <a href="#" style="display:flex;align-items:center;gap:12px;padding:14px 18px;text-decoration:none;color:#1f2937;font-weight:600;border-bottom:1px solid #f3f4f6;transition:background .2s;">
                <span style="font-size:20px;">ℹ️</span>
                <span>About</span>
                <span style="margin-left:auto;width:22px;height:22px;background:#ef4444;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;">!</span>
              </a>
              <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" style="width:100%;display:flex;align-items:center;gap:12px;padding:14px 18px;text-decoration:none;background:#fee2e2;color:#991b1b;font-weight:700;border:0;cursor:pointer;transition:background .2s;font-size:15px;">
                  <span style="font-size:20px;">🔴</span>
                  <span>Log Out</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </header>

      <div class="content">
        <h2 style="margin:0 0 12px 0;font-weight:800;color:#1f2937;font-size:20px;">Admin Dashboard</h2>

        <section class="stats-grid">
          <div class="stat stat--students">
            <div class="label">Students:</div>
            <div class="value">21.39K</div>
            <div style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:42px;opacity:.3;">🎓</div>
          </div>
          <div class="stat stat--teachers">
            <div class="label">Teachers:</div>
            <div class="value">200</div>
            <div style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:42px;opacity:.3;">👨‍🏫</div>
          </div>
          <div class="stat stat--projects">
            <div class="label">Departments:</div>
            <div class="value">4</div>
            <div style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:42px;opacity:.3;">📚</div>
          </div>
          <div class="stat stat--earnings">
            <div class="label">Earnings:</div>
            <div class="value">23.27M</div>
            <div style="position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:42px;opacity:.3;">💰</div>
          </div>
        </section>

        <div class="grid">
          <section>
            <div class="charts-grid">
              <div class="panel-card">
                <h3 style="margin:0 0 8px 0;font-size:13px;font-weight:700;color:#6b7280;">Programs</h3>
                <canvas id="donut" style="max-height:200px;"></canvas>
              </div>
              <div class="panel-card">
                <h3 style="margin:0 0 8px 0;font-size:13px;font-weight:700;color:#6b7280;">Top Earnings</h3>
                <canvas id="bars" style="max-height:200px;"></canvas>
              </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
              <div class="panel-card">
                <h3 style="margin:0 0 8px 0;font-size:13px;font-weight:700;color:#6b7280;">Top Performer</h3>
                <div style="font-size:11px;color:#9ca3af;margin-bottom:6px;">Week | Month | Year</div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                  <div style="display:flex;align-items:center;gap:8px;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                    <div style="width:32px;height:32px;border-radius:50%;background:#ddd;"></div>
                    <div style="flex:1;font-size:13px;font-weight:600;">Kristian Martinko</div>
                    <div style="font-size:12px;color:#6b7280;">2334425322</div>
                    <div style="font-size:12px;color:#6b7280;">3rd Year</div>
                    <div style="font-size:13px;font-weight:700;color:#10b981;">98.8%</div>
                  </div>
                  <div style="display:flex;align-items:center;gap:8px;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                    <div style="width:32px;height:32px;border-radius:50%;background:#ddd;"></div>
                    <div style="flex:1;font-size:13px;font-weight:600;">Angel Acilo</div>
                    <div style="font-size:12px;color:#6b7280;">2334427233</div>
                    <div style="font-size:12px;color:#6b7280;">2nd Year</div>
                    <div style="font-size:13px;font-weight:700;color:#10b981;">96.2%</div>
                  </div>
                  <div style="display:flex;align-items:center;gap:8px;padding:8px 0;">
                    <div style="width:32px;height:32px;border-radius:50%;background:#ddd;"></div>
                    <div style="flex:1;font-size:13px;font-weight:600;">Kit Saguday</div>
                    <div style="font-size:12px;color:#6b7280;">2338455548</div>
                    <div style="font-size:12px;color:#6b7280;">4th Year</div>
                    <div style="font-size:13px;font-weight:700;color:#10b981;">95.4%</div>
                  </div>
                </div>
              </div>

              <div class="panel-card">
                <h3 style="margin:0 0 8px 0;font-size:13px;font-weight:700;color:#6b7280;">Attendance</h3>
                <div style="display:flex;justify-content:center;align-items:center;height:150px;">
                  <canvas id="attendance" style="max-width:180px;max-height:180px;"></canvas>
                </div>
              </div>
            </div>

            <div class="panel-card" style="margin-top:12px;">
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <h3 style="margin:0;font-size:13px;font-weight:700;color:#6b7280;">Library</h3>
                <a href="#" style="font-size:11px;color:#3b82f6;text-decoration:none;">View All</a>
              </div>
              <div style="display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                  <div style="width:40px;height:40px;background:#ddd;border-radius:4px;"></div>
                  <div style="flex:1;font-size:13px;font-weight:600;">Literature</div>
                  <div style="font-size:12px;color:#6b7280;">View Book</div>
                </div>
                <div style="display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                  <div style="width:40px;height:40px;background:#ddd;border-radius:4px;"></div>
                  <div style="flex:1;font-size:13px;font-weight:600;">Mathematics</div>
                  <div style="font-size:12px;color:#6b7280;">View Book</div>
                </div>
                <div style="display:flex;align-items:center;gap:12px;padding:8px 0;border-bottom:1px solid #f3f4f6;">
                  <div style="width:40px;height:40px;background:#ddd;border-radius:4px;"></div>
                  <div style="flex:1;font-size:13px;font-weight:600;">Science</div>
                  <div style="font-size:12px;color:#6b7280;">View Book</div>
                </div>
                <div style="display:flex;align-items:center;gap:12px;padding:8px 0;">
                  <div style="width:40px;height:40px;background:#ddd;border-radius:4px;"></div>
                  <div style="flex:1;font-size:13px;font-weight:600;">English</div>
                  <div style="font-size:12px;color:#6b7280;">View Book</div>
                </div>
              </div>
            </div>
          </section>

          <aside class="notifications">
            <div class="panel-card">
              <h3 style="margin:0 0 12px 0;font-size:14px;font-weight:700;color:#1f2937;">Notifications</h3>
              <div class="note">
                <div style="width:48px;height:48px;background:#3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:24px;">👨‍🏫</div>
                <div>
                  <div style="font-weight:700;font-size:14px;color:#1f2937;">New Teacher</div>
                  <div class="meta" style="color:#9ca3af;">New teacher has added on the...</div>
                </div>
                <div style="font-size:11px;color:#9ca3af;">Just now</div>
              </div>
              <div class="note">
                <div style="width:48px;height:48px;background:#ec4899;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:24px;">📅</div>
                <div>
                  <div style="font-weight:700;font-size:14px;color:#1f2937;">Meetings Sched</div>
                  <div class="meta" style="color:#9ca3af;">Meeting will be on schedule at 4:30...</div>
                </div>
                <div style="font-size:11px;color:#9ca3af;">Today</div>
              </div>
              <div class="note">
                <div style="width:48px;height:48px;background:#3b82f6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:24px;">📚</div>
                <div>
                  <div style="font-weight:700;font-size:14px;color:#1f2937;">New Course</div>
                  <div class="meta" style="color:#9ca3af;">New course has added on 1st...</div>
                </div>
                <div style="font-size:11px;color:#9ca3af;">2 hours ago</div>
              </div>
              <div class="note">
                <div style="width:48px;height:48px;background:#10b981;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:24px;">📄</div>
                <div>
                  <div style="font-weight:700;font-size:14px;color:#1f2937;">Free Structure</div>
                  <div class="meta" style="color:#9ca3af;">Free structure has...</div>
                </div>
                <div style="font-size:11px;color:#9ca3af;">5 hours ago</div>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById('profileDropdown');
      dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
      const dropdown = document.getElementById('profileDropdown');
      const profileBtn = event.target.closest('[onclick="toggleDropdown()"]');
      if (!profileBtn && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
      }
    });

    const donutCtx = document.getElementById('donut');
    if (donutCtx && window.Chart) {
      new Chart(donutCtx, {
        type: 'doughnut',
        data: {
          labels: ['Nursing Program', 'Business in Administration Program', 'Computer Science Program', 'Engineering Program'],
          datasets: [{ 
            data: [2855, 3566, 4263, 8156], 
            backgroundColor: ['#60a5fa','#f59e0b','#ec4899','#a78bfa'],
            borderWidth: 0
          }]
        },
        options: { 
          plugins: { 
            legend: { 
              position: 'right',
              labels: { boxWidth: 12, padding: 10, font: { size: 11 } }
            } 
          },
          maintainAspectRatio: true
        }
      });
    }

    const barsCtx = document.getElementById('bars');
    if (barsCtx && window.Chart) {
      new Chart(barsCtx, {
        type: 'bar',
        data: {
          labels: ['2023','2024','2025'],
          datasets: [{ 
            label: '',
            data: [15,18,22], 
            backgroundColor: '#eef467',
            borderRadius: 4
          }]
        },
        options: { 
          plugins: { legend: { display: false } },
          scales: { 
            y: { 
              beginAtZero: true,
              ticks: { callback: (val) => val + 'M' }
            } 
          },
          maintainAspectRatio: true
        }
      });
    }

    const attendanceCtx = document.getElementById('attendance');
    if (attendanceCtx && window.Chart) {
      new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
          labels: ['Present: 98.8%', 'Absent: 1.2%'],
          datasets: [{ 
            data: [98.8, 1.2], 
            backgroundColor: ['#a78bfa','#fbbf24'],
            borderWidth: 0
          }]
        },
        options: { 
          plugins: { 
            legend: { 
              position: 'bottom',
              labels: { boxWidth: 12, padding: 8, font: { size: 10 } }
            } 
          },
          cutout: '70%',
          maintainAspectRatio: true
        }
      });
    }
  </script>
</body>
</html>
