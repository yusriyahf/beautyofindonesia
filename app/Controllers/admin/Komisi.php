<?php

namespace App\Controllers\admin;

use App\Models\komisiUser;
use App\Models\KomisiUserModel;
use App\Models\PemasukanUserModel;
use App\Models\PenarikanUserModel;
use App\Models\SaldoModel;

class Komisi extends BaseController
{
    private $penarikanSaldo;
    private $pemasukanSaldo;

    public function __construct()
    {
        $this->penarikanSaldo = new PenarikanUserModel();
        $this->pemasukanSaldo = new PemasukanUserModel();
    }

    public function saldo()
    {
        // ini view
        $model = new SaldoModel();

        // Ambil ID user yang sedang login
        $user_id = session('id_user');


        $saldo = $model->where('user_id', $user_id)->first();



        // Ambil pemasukan sesuai user login
        $all_data_pemasukan_saldo = $this->pemasukanSaldo->where('user_id', $user_id)->findAll();
        foreach ($all_data_pemasukan_saldo as &$pemasukan) {
            $pemasukan['tipe'] = 'pemasukan';
            $pemasukan['tanggal'] = $pemasukan['tanggal_pemasukan'];
        }

        // Ambil pengeluaran (penarikan) sesuai user login
        $all_data_penarikan_saldo = $this->penarikanSaldo->where('user_id', $user_id)->findAll();
        foreach ($all_data_penarikan_saldo as &$penarikan) {
            $penarikan['tipe'] = 'penarikan';
            $penarikan['tanggal'] = $penarikan['tanggal_pengajuan'];
        }

        // Gabungkan dan urutkan transaksi
        $semua_transaksi = array_merge($all_data_pemasukan_saldo, $all_data_penarikan_saldo);
        usort($semua_transaksi, function ($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        // Hitung total pemasukan
        $total_pemasukan = 0;
        foreach ($all_data_pemasukan_saldo as $pemasukan) {
            $total_pemasukan += $pemasukan['jumlah'];
        }

        // Hitung total pengeluaran
        $total_pengeluaran = 0;
        foreach ($all_data_penarikan_saldo as $penarikan) {
            $total_pengeluaran += $penarikan['jumlah'];
        }

        // Kirim ke view
        return view('saldo/index', [
            'saldo' => $saldo,
            'semua_transaksi' => $semua_transaksi,
            'total_pemasukan' => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'pemasukan' => $all_data_pemasukan_saldo,
            'pengeluaran' => $all_data_penarikan_saldo,
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
        $jumlah = $this->request->getPost('jumlah');
        $status = 'diproses';

        // validasi jika perlu
        if ($jumlah <= 0) {
            return redirect()->back()->withInput()->with('error', 'Jumlah tidak valid');
        }

        // Simpan ke database
        $this->penarikanSaldo->save([
            'user_id' => session('id_user'),
            'jumlah' => $jumlah,
            'status' => $status,
            'tanggal_pengajuan' => date('Y-m-d'),
        ]);

        return redirect()->to('admin/saldo')->with('success', 'Pengajuan berhasil dikirim');
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
