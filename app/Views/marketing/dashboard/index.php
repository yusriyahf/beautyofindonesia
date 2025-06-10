<?= $this->extend('admin/template/template'); ?>
    <?= $this->Section('content'); ?>

   
<div class="dashboard-wrapper" style="padding: 20px; background: #f5f7fa;">

  <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="font-size: 24px; font-weight: 600;"> Dashboard Marketing -Beauty Of Indonesia</h1>
    <p>Selamat datang, <?= esc($username) ?>!</p>
  </div>

    <!-- Header Section -->
  <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
    <div>
      <h1 style="font-size: 28px; font-weight: 700; color: #2d3748; margin-bottom: 5px;">Dashboard - Beauty Of Indonesia</h1>
      <p style="color: #718096; font-size: 14px;">Selamat datang, <?= esc($username) ?>! <span id="greeting-time"></span></p>
    </div>
    <div style="display: flex; align-items: center; gap: 15px;">
      <div style="position: relative;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #718096;">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>
        <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 10px;">3</span>
      </div>
      <div style="width: 40px; height: 40px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
      </div>
    </div>
  </div>

    <div class="cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-left: 4px solid #4f46e5;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <p style="color: #718096; font-size: 14px; margin-bottom: 8px;">Total Iklan Diterima</p>
          <h2 style="font-size: 24px; font-weight: 700; color: #2d3748;"><?= $iklanDiterima ?></h2>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 8px; background: #e0e7ff; display: flex; align-items: center; justify-content: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
          </svg>
        </div>
      </div>
      <div style="margin-top: 12px; display: flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
          <polyline points="17 6 23 6 23 12"></polyline>
        </svg>
        <span style="color: #10b981; font-size: 12px; margin-left: 4px;">12% dari bulan lalu</span>
      </div>
    </div>

    <div class="card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-left: 4px solid #10b981;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <p style="color: #718096; font-size: 14px; margin-bottom: 8px;">Total iklan Ditolak</p>
          <h2 style="font-size: 24px; font-weight: 700; color: #2d3748;"><?= $iklanDitolak ?></h2>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 8px; background: #d1fae5; display: flex; align-items: center; justify-content: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
            <circle cx="12" cy="10" r="3"></circle>
          </svg>
        </div>
      </div>
      <div style="margin-top: 12px; display: flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
          <polyline points="17 6 23 6 23 12"></polyline>
        </svg>
        <span style="color: #10b981; font-size: 12px; margin-left: 4px;">8% dari bulan lalu</span>
      </div>
    </div>

    <div class="card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-left: 4px solid #f59e0b;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <p style="color: #718096; font-size: 14px; margin-bottom: 8px;">Total Iklan Diajukan</p>
          <h2 style="font-size: 24px; font-weight: 700; color: #2d3748;"><?= $iklanDiajukan ?></h2>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 8px; background: #fef3c7; display: flex; align-items: center; justify-content: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
          </svg>
        </div>
      </div>
      <div style="margin-top: 12px; display: flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
          <polyline points="17 18 23 18 23 12"></polyline>
        </svg>
        <span style="color: #ef4444; font-size: 12px; margin-left: 4px;">5% dari bulan lalu</span>
      </div>
    </div>

    <div class="card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-left: 4px solid #f59e0b;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <p style="color: #718096; font-size: 14px; margin-bottom: 8px;">Total iklan Aktif</p>
          <h2 style="font-size: 24px; font-weight: 700; color: #2d3748;"><?= $total_iklan ?></h2>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 8px; background: #fef3c7; display: flex; align-items: center; justify-content: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
          </svg>
        </div>
      </div>
      <div style="margin-top: 12px; display: flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
          <polyline points="17 18 23 18 23 12"></polyline>
        </svg>
        <span style="color: #ef4444; font-size: 12px; margin-left: 4px;">5% dari bulan lalu</span>
      </div>
    </div>

    <div class="card" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-left: 4px solid #6366f1;">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
          <p style="color: #718096; font-size: 14px; margin-bottom: 8px;">Total Komisi Bulan Ini</p>
          <h2 style="font-size: 24px; font-weight: 700; color: #2d3748;">Rp<?= number_format($total_komisi, 0, ',', '.') ?></h2>
        </div>
        <div style="width: 48px; height: 48px; border-radius: 8px; background: #e0e7ff; display: flex; align-items: center; justify-content: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
            <line x1="8" y1="21" x2="16" y2="21"></line>
            <line x1="12" y1="17" x2="12" y2="21"></line>
          </svg>
        </div>
      </div>
      <div style="margin-top: 12px; display: flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
          <polyline points="17 6 23 6 23 12"></polyline>
        </svg>
        <span style="color: #10b981; font-size: 12px; margin-left: 4px;">22% dari bulan lalu</span>
      </div>
    </div>
  </div>


  <!-- Charts and Quick Stats -->
  <div class="dashboard-content" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px;">
    <!-- Main Charts -->
    <div class="main-charts" style="display: flex; flex-direction: column; gap: 20px;">
      <div class="chart-box" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
          <h3 style="font-size: 18px; font-weight: 600; color: #2d3748;">Total Komisi per Bulan</h3>
          
        </div>
        <canvas id="komisiChart" height="250"></canvas>
      </div>
    </div>

    <!-- Sidebar - Quick Stats and Recent Activity -->
    <div class="sidebar" style="display: flex; flex-direction: column; gap: 20px;">
      <!-- Quick Actions -->
      <div class="quick-actions" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 16px;">Quick Actions</h3>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
          <a href="<?= base_url('marketing/daftariklankonten/tambah') ?>" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 12px; background: #f3f4f6; border-radius: 8px; text-decoration: none; color: #4b5563; transition: all 0.2s;">
            <div style="width: 32px; height: 32px; background: #e0e7ff; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-bottom: 8px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
              </svg>
            </div>
            <span style="font-size: 12px; text-align: center;">Tambah Iklan Konten</span>
          </a>
          <a href="<?= base_url('marketing/iklanutama/tambah') ?>" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 12px; background: #f3f4f6; border-radius: 8px; text-decoration: none; color: #4b5563; transition: all 0.2s;">
            <div style="width: 32px; height: 32px; background: #d1fae5; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-bottom: 8px;">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981  " stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                <line x1="8" y1="21" x2="16" y2="21"></line>
                <line x1="12" y1="17" x2="12" y2="21"></line>
             </svg>
            </div>
            <span style="font-size: 12px; text-align: center;">Tambah Iklan Utama</span>
          </a>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="recent-activity" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 18px; font-weight: 600; color: #2d3748; margin-bottom: 16px;">Aktivitas Terakhir</h3>

        <div style="display: flex; flex-direction: column; gap: 16px;">
          <?php
            if (!empty($aktivitas)) {
              // Ambil 3 aktivitas terakhir
              $aktivitas_terakhir = $aktivitas;

              function waktu_lalu($datetime) {
                $now = new DateTime();
                $waktu = new DateTime($datetime);
                $diff = $now->diff($waktu);

                if ($diff->y > 0) return $diff->y . ' tahun lalu';
                if ($diff->m > 0) return $diff->m . ' bulan lalu';
                if ($diff->d > 0) return $diff->d . ' hari lalu';
                if ($diff->h > 0) return $diff->h . ' jam lalu';
                if ($diff->i > 0) return $diff->i . ' menit lalu';
                return 'Baru saja';
              }

              foreach ($aktivitas_terakhir as $item):
                $jenis = trim(strtolower($item['jenis']));
                $tanggal = $item['tanggal']; // format: Y-m-d H:i:s atau hanya Y-m-d
                $waktu_ago = waktu_lalu($tanggal);

                switch ($jenis) {
                  case 'komisi':
                    $title = 'Anda menerima komisi';
                    $bgColor = '#e0e7ff';
                    $iconColor = '#4f46e5';
                    $icon = '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>';
                    break;
                  case 'penarikan':
                    $title = 'Penarikan saldo Anda disetujui';
                    $bgColor = '#d1fae5';
                    $iconColor = '#10b981';
                    $icon = '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 ..."></path>';
                    break;
                  case 'iklan':
                    $title = 'Iklan Anda ditempatkan di Artikel';
                    $bgColor = '#fef3c7';
                    $iconColor = '#f59e0b';
                    $icon = '<path d="M21 15a2 2 0 0 1-2 2H7l-4-4..."></path>';
                    break;
                  default:
                    $title = 'Jenis aktivitas tidak dikenal';
                    $bgColor = '#e5e7eb';
                    $iconColor = '#6b7280';
                    $icon = '';
                }
          ?>
          <div style="display: flex; gap: 12px; align-items: center;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background: <?= $bgColor ?>; display: flex; align-items: center; justify-content: center;">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="<?= $iconColor ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <?= $icon ?>
              </svg>
            </div>
            <div>
              <p style="font-size: 14px; color: #2d3748; margin: 0;"><?= $title ?></p>
              <p style="font-size: 12px; color: #718096; margin: 0;"><?= $waktu_ago ?></p>
            </div>
          </div>
          <?php endforeach;
            } else {
              echo "<p>Tidak ada aktivitas terbaru.</p>";
            }
          ?>
        </div>



      </div>


    </div>

  </div>

  <!-- Riwayat komisi terakhir -->
  <div class="history-table" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 600; color: #2d3748;">Riwayat Komisi Terbaru</h3>

      <button onclick="window.location.href='<?= base_url('marketing/saldo')?>'" style="padding: 8px 16px; background: #4f46e5; color: white; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;">
        Lihat Selengkapnya
      </button>
    </div>
    <div class="table-responsive">
      <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead>
          <tr style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
            <th style="padding: 12px; text-align: left; font-size: 14px; color: #6b7280; font-weight: 500;">No</th>
            <th style="padding: 12px; text-align: left; font-size: 14px; color: #6b7280; font-weight: 500;">Jumlah</th>
            <th style="padding: 12px; text-align: left; font-size: 14px; color: #6b7280; font-weight: 500;">Tanggal</th>
            <th style="padding: 12px; text-align: left; font-size: 14px; color: #6b7280; font-weight: 500;">Jam</th>
            <th style="padding: 12px; text-align: left; font-size: 14px; color: #6b7280; font-weight: 500;">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $count = count($semua_jumlah); 
          for ($i = 0; $i < $count; $i++): ?>
          <tr>
            <td style="padding: 10px;"><?= $i + 1 ?></td>
            <td style="padding: 10px;">
              Rp <?= number_format($semua_jumlah[$i]['jumlah'], 0, ',', '.') ?>
            </td>
            <td style="padding: 10px;">
              <?= date('d M Y', strtotime($tanggal_terakhir[$i]['tanggal_pemasukan'])) ?>
            </td>
            <td style="padding: 10px;">
              <?= $jam_terakhir[$i]['jam'] ?>
            </td>
            <td>
              <?php 
                $status = strtolower(esc($status_terakhir[$i]['status']));
                $bgColor = match ($status) {
                    'disetujui' => '#d1fae5',     // hijau
                    'diproses' => '#fef3c7',   // oranye
                    'ditolak' => '#fee2e2',       // merah
                };
                $strokeColor = match ($status) {
                    'disetujui' => '#065f46',     // hijau tua
                    'diproses' => '#92400e',      // oranye tua
                    'ditolak'  => '#991b1b',      // merah tua
                };
              ?>
              <div style="margin-bottom: 6px;">
                <span style="padding: 4px 12px; border-radius: 999px; background: <?= $bgColor ?>; color: <?= $strokeColor ?>; font-size: 12px; display: inline-block;">
                  <?= ucfirst($status) ?>
                </span>
              </div>
            </td>
          </tr>
          <?php endfor; ?>
        </tbody>

      </table>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Time-based greeting
                const hour = new Date().getHours();
                const greeting = document.getElementById('greeting-time');
                if (hour < 12) {
                  greeting.textContent = 'Selamat pagi!';
                } else if (hour < 18) {
                  greeting.textContent = 'Selamat siang!';
                } else {
                  greeting.textContent = 'Selamat malam!';
                }

                // Komisi Chart
                const ctx = document.getElementById('komisiChart').getContext('2d');
                const komisiData = <?= json_encode($komisi_chart) ?>;

                new Chart(ctx, {
                type: 'line', 
                data: {
                  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                  datasets: [{
                    label: 'Komisi Bulanan',
                    data: komisiData,
                    borderColor: '#4f46e5',       // Warna garis
                    backgroundColor: '#4f46e580', // Warna area bawah garis (dengan transparansi)
                    tension: 0.4,                 // Lengkung garis, mirip efek halus
                    fill: true,                  // Aktifkan fill di bawah garis
                    pointBackgroundColor: '#4f46e5',
                    pointRadius: 5,
                    pointHoverRadius: 7
                  }]
                },
                options: {
                  responsive: true,
                  plugins: {
                    legend: {
                      display: false
                    },
                    tooltip: {
                      callbacks: {
                        label: function(context) {
                          return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                      }
                    }
                  },
                  scales: {
                    y: {
                      beginAtZero: true,
                      ticks: {
                        callback: function(value) {
                          return 'Rp ' + value.toLocaleString('id-ID');
                        }
                      },
                      grid: {
                        drawBorder: false,
                        color: '#e5e7eb'
                      }
                    },
                    x: {
                      grid: {
                        display: false
                      }
                    }
                  }
                }
              });
</script>                         


<?= $this->endSection('content')?>