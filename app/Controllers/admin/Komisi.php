<?php

namespace App\Controllers\admin;

use App\Models\KomisiModel;
use App\Models\komisiUser;
use App\Models\KomisiUserModel;
use App\Models\PemasukanUserModel;
use App\Models\PenarikanUserModel;
use App\Models\SaldoModel;
use App\Models\UserModel;

class Komisi extends BaseController
{
    private $penarikanSaldo;
    private $pemasukanSaldo;
    private $userModel;

    public function __construct()
    {
        $this->penarikanSaldo = new PenarikanUserModel();
        $this->pemasukanSaldo = new PemasukanUserModel();
        $this->userModel = new UserModel();
    }

    public function saldo()
    {
        // dd(session()->get());
        // Model saldo
        $saldoModel = new SaldoModel();

        // Ambil ID user yang sedang login
        $user_id = session('id_user');

        // Ambil saldo user
        $saldo = $saldoModel->where('user_id', $user_id)->first();

        // Ambil pemasukan saldo sesuai user login
        $all_data_pemasukan_saldo = $this->pemasukanSaldo->where('user_id', $user_id)->findAll();

        // Ambil pengeluaran (penarikan) sesuai user login
        $all_data_penarikan_saldo = $this->penarikanSaldo->where('user_id', $user_id)->findAll();

        // Buat map username agar bisa tampil di transaksi
        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll();
        $user_map = [];
        foreach ($users as $user) {
            $user_map[$user['id_user']] = $user['username'];
        }

        // Tambahkan username di pemasukan
        foreach ($all_data_pemasukan_saldo as &$pemasukan) {
            $pemasukan['tipe'] = 'pemasukan';
            $pemasukan['tanggal'] = $pemasukan['tanggal_pemasukan'];
            $id_user = $pemasukan['user_id'];
            $pemasukan['username'] = $user_map[$id_user] ?? 'Tidak diketahui';
        }

        // Tambahkan username di pengeluaran
        foreach ($all_data_penarikan_saldo as &$penarikan) {
            $penarikan['tipe'] = 'penarikan';
            $penarikan['tanggal'] = $penarikan['tanggal_pengajuan'];
            $id_user = $penarikan['user_id'];
            $penarikan['username'] = $user_map[$id_user] ?? 'Tidak diketahui';
        }

        // Gabungkan dan urutkan transaksi berdasarkan tanggal terbaru
        $semua_transaksi = array_merge($all_data_pemasukan_saldo, $all_data_penarikan_saldo);
        usort($semua_transaksi, function ($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        // Hitung total pemasukan dan pengeluaran
        $total_pemasukan = array_sum(array_column($all_data_pemasukan_saldo, 'jumlah'));
        $total_pengeluaran = array_sum(array_column($all_data_penarikan_saldo, 'jumlah'));

        // Ambil data komisi dengan join ke role untuk mendapatkan peran dan persentase
        $komisiModel = new \App\Models\PemasukanUserModel();
        $komisiList = $komisiModel
            ->select('tb_pemasukan_komisi.*, tb_users.username as peran')
            ->join('tb_users', 'tb_pemasukan_komisi.user_id = tb_users.id_user', 'left')
            ->where('tb_pemasukan_komisi.user_id', $user_id)
            ->findAll();

        // Model untuk iklan dan konten
        $iklanModel = new \App\Models\ArtikelIklanModel();
        $artikelModel = new \App\Models\ArtikelModel();
        $wisataModel = new \App\Models\TempatWisataModel();
        $oleholehModel = new \App\Models\OlehOlehModel();

        $iklan_info = [];

        // Ambil info iklan untuk setiap komisi yang punya id_iklan
        foreach ($komisiList as &$komisi) {
            // Pastikan peran dan persentase ada (fallback)
            $komisi['peran'] = $komisi['peran'] ?? 'Tidak diketahui';
            $komisi['persentase'] = $komisi['persentase'] ?? 0;

            if (!empty($komisi['id_iklan'])) {
                $id_iklan = $komisi['id_iklan'];
                $iklan = $iklanModel->find($id_iklan);
                if ($iklan) {
                    $tipe_content = $iklan['tipe_content'];
                    $detail_konten = null;
                    if ($tipe_content == 'artikel') {
                        $detail_konten = $artikelModel->find($iklan['id_content']);
                    } elseif ($tipe_content == 'tempatwisata') {
                        $detail_konten = $wisataModel->find($iklan['id_content']);
                    } elseif ($tipe_content == 'oleholeh') {
                        $detail_konten = $oleholehModel->find($iklan['id_content']);
                    }
                    $iklan_info[$id_iklan] = [
                        'tipe_content' => $tipe_content,
                        'status_iklan' => $iklan['status_iklan'],
                        'total_harga' => $iklan['total_harga'],
                        'detail_konten' => $detail_konten,
                    ];
                }
            }
        }


        // Kirim semua data ke view
        return view('saldo/index', [
            'saldo' => $saldo,
            'semua_transaksi' => $semua_transaksi,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'pemasukan' => $all_data_pemasukan_saldo,
            'pengeluaran' => $all_data_penarikan_saldo,
            'komisiList' => $komisiList,
            'iklan_info' => $iklan_info, // data iklan lengkap untuk ditampilkan di view
        ]);
    }



    public function penarikan()
    {
        $validation = \Config\Services::validation();

        // Ambil semua data pemasukan
        $all_data_pemasukan_saldo = $this->pemasukanSaldo->findAll();

        // Hitung total pemasukan
        $total_pemasukan = 0;
        foreach ($all_data_pemasukan_saldo as $pemasukan) {
            $total_pemasukan += $pemasukan['jumlah'];
        }

        return view('saldo/penarikan', [
            'validation' => $validation,
            'total_pemasukan' => $total_pemasukan,
        ]);
    }


    public function proses_penarikan()
    {
        date_default_timezone_set('Asia/Jakarta');

        $jumlah = $this->request->getPost('jumlah');
        $status = 'diproses';
        $role   = session('role'); // Ambil role dari session

        // Validasi jumlah
        if ($jumlah <= 0) {
            return redirect()->back()->withInput()->with('error', 'Jumlah tidak valid');
        }

        // Simpan ke database
        $this->penarikanSaldo->save([
            'user_id' => session('id_user'),
            'jumlah' => $jumlah,
            'status' => $status,
            'tanggal_pengajuan' => date('Y-m-d H:i:s'),
        ]);

        // Redirect sesuai role
        if ($role === 'admin') {
            return redirect()->to('admin/saldo')->with('success', 'Pengajuan berhasil dikirim');
        } elseif ($role === 'marketing') {
            return redirect()->to('marketing/saldo')->with('success', 'Pengajuan berhasil dikirim');
        } else {
            return redirect()->to('penulis/saldo')->with('success', 'Pengajuan berhasil dikirim');
        }
    }


    public function permintaan()
    {
        $validation = \Config\Services::validation();

        // Ambil semua data pemasukan
        $all_data_penarikan_saldo = $this->penarikanSaldo->getPenarikan();

        return view('saldo/permintaan', [
            'validation' => $validation,
            'all_data_penarikan_saldo' => $all_data_penarikan_saldo,
        ]);
    }

    public function ubahstatus()
    {
        $id = $this->request->getPost('id_penarikan_komisi');
        // dd($id);
        $catatan = $this->request->getPost('catatan');
        $bukti = $this->request->getFile('bukti_transfer');

        if (!$id || !$bukti->isValid()) {
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        // Simpan file
        $namaFile = $bukti->getRandomName();
        $bukti->move('uploads/bukti_transfer/', $namaFile);

        // Update ke database
        $this->penarikanSaldo->update($id, [
            'status' => 'disetujui',
            'bukti_transfer' => $namaFile,
            'catatan' => $catatan,
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah.');
    }
}
