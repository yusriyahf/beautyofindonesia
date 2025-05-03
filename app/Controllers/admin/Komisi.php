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

        $saldo = $model->where('user_id', session('id_user'))->first();



        $all_data_pemasukan_saldo = $this->pemasukanSaldo->findAll();
        foreach ($all_data_pemasukan_saldo as &$pemasukan) {
            $pemasukan['tipe'] = 'pemasukan';
            $pemasukan['tanggal'] = $pemasukan['tanggal_pemasukan'];
        }

        // Ambil data penarikan dan tambahkan field tipe
        $all_data_penarikan_saldo = $this->penarikanSaldo->findAll();
        foreach ($all_data_penarikan_saldo as &$penarikan) {
            $penarikan['tipe'] = 'penarikan';
            $penarikan['tanggal'] = $penarikan['tanggal_pengajuan'];
        }

        // Gabungkan kedua array
        $semua_transaksi = array_merge($all_data_pemasukan_saldo, $all_data_penarikan_saldo);

        // Urutkan berdasarkan tanggal terbaru
        usort($semua_transaksi, function ($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });


        // Kirim data ke view dalam bentuk array terpisah
        return view('saldo/index', [
            'saldo' => $saldo,
            'semua_transaksi' => $semua_transaksi,
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

        $id_penarikan_komisi = $this->request->getPost('id_penarikan_komisi');

        $this->penarikanSaldo->update($id_penarikan_komisi, [
            'status' => 'disetujui'
        ]);

        // Opsional: Redirect atau set flashdata
        return redirect()->back()->with('success', 'Status penarikan berhasil diubah menjadi disetujui.');
    }
}
