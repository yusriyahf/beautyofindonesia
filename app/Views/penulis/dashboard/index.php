<?= $this->extend('admin/template/template'); ?>
    <?= $this->Section('content'); ?>

   
<div class="dashboard-wrapper" style="padding: 20px; background: #f5f7fa;">

  <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="font-size: 24px; font-weight: 600;">Dashboard Penulis - Beauty Of ndonesia</h1>
    <p>Selamat datang, <?= esc($username) ?>!</p>
  </div>

  <div class="cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center;">
      <h2><?= $total_artikel ?></h2>
      <p>Total Artikel</p>
    </div>
    <div class="card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center;">
      <h2><?=$total_wisata?></h2>
      <p>Total Tempat Wisata</p>
    </div>
    
    <div class="card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center;">
      <h2><?=$total_oleh?></h2>
      <p>Total Oleh-Oleh</p>
    </div>
    <div class="card" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center;">
      <h2>Rp<?= number_format($total_komisi, 0, ',', '.') ?></h2>
      <p>Total Komisi Bulan Ini</p>
    </div>
  </div>

    <div class="chart-section" style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
        <div class="chart-box" style="flex: 1; background: white; padding: 20px; border-radius: 10px; min-width: 300px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>Total Komisi per Bulan</h3>
            <canvas id="komisiChart" height="150">
            </canvas>
        </div>
        <div class="chart-box" style="flex: 1; background: white; padding: 20px; border-radius: 10px; min-width: 300px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <h3>Sumber Trafik</h3>
        <canvas id="trafikChart" height="400"></canvas>
        </div>
    </div>

  <div class="history-table" style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <h3>Riwayat Komisi</h3>
    <div class="table-responsive">
      <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <thead>
          <tr style="background-color: #f0f0f0;">
            <th style="padding: 10px; text-align: left;">Nama</th>
            <th style="padding: 10px; text-align: left;">ID</th>
            <th style="padding: 10px; text-align: left;">Tanggal</th>
            <th style="padding: 10px; text-align: left;">Jam</th>
            <th style="padding: 10px; text-align: left;">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="padding: 10px;">Pradeep Bansal</td>
            <td style="padding: 10px;">PBSD8638</td>
            <td style="padding: 10px;">25 Jul 2020</td>
            <td style="padding: 10px;">10:00 AM</td>
            <td style="padding: 10px;"><span style="padding: 5px 10px; border-radius: 5px; background: #ff9800; color: white;">In Progress</span></td>
          </tr>
          <tr>
            <td style="padding: 10px;">Sameer Sahay</td>
            <td style="padding: 10px;">SSND5668</td>
            <td style="padding: 10px;">28 Jul 2020</td>
            <td style="padding: 10px;">11:20 AM</td>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            
            <script>
                const ctx = document.getElementById('komisiChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Komisi Bulanan',
                        data: [1200000, 1500000, 1700000, 1400000, 2000000, 1800000],
                        backgroundColor: '#4e73df'
                    }]
                    },
                    options: {
                    scales: {
                        y: {
                        beginAtZero: true
                        }
                    }
                    }
                });

                // Doughnut Chart (Sumber Trafik)
                const ctx2 = document.getElementById('trafikChart').getContext('2d');
                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                    labels: ['Desktop', 'Mobile', 'Tablet', 'Direct'],
                    datasets: [{
                        data: [12.5, 49.1, 23.2, 15.2],
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
                    }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false
                    }
                });
            </script>

    <?= $this->endSection('content')?>