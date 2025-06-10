<?php

namespace App\Models;

use CodeIgniter\Model;

class PemasukanUserModel extends Model
{
    protected $table = 'tb_pemasukan_komisi';
    protected $primaryKey = 'id_pemasukan_komisi';
    protected $returnType = 'array';
    protected $allowedFields = ['id_pemasukan_komisi ', 'user_id', 'jumlah', 'status', 'tanggal_pemasukan', 'keterangan', 'id_iklan', 'tipe_iklan'];

      public function getTotalKomisi($user_id)
        {
            return $this->selectSum('jumlah')
                        ->where('user_id', $user_id)
                        ->get()
                        ->getRowArray();
        }

        public function getKomisiPerBulan($user_id)
        {
            return $this->select("MONTH(tanggal_pemasukan) as bulan, SUM(jumlah) as total")
                        ->where('user_id', $user_id)
                        ->groupBy("MONTH(tanggal_pemasukan)")
                        ->orderBy("bulan", "ASC")
                        ->findAll();
        }

       
        public function getLast3Jumlah($user_id)
        {
            return $this->select('jumlah')
                        ->where('user_id', $user_id)
                        ->orderBy('tanggal_pemasukan', 'DESC')
                        ->limit(3)
                        ->get()
                        ->getResultArray(); // hasilnya array of array
        }

       public function getLast3Tanggal($user_id)
        {
            return $this->select('tanggal_pemasukan')
                        ->where('user_id', $user_id)
                        ->orderBy('tanggal_pemasukan', 'DESC')
                        ->limit(3)
                        ->get()
                        ->getResultArray(); // hasil: array of array
        }

    
        public function getLast3JamPemasukan($user_id)
        {
            return $this->select("TIME(tanggal_pemasukan) as jam")
                        ->where('user_id', $user_id)
                        ->orderBy('tanggal_pemasukan', 'DESC')
                        ->limit(3)
                        ->get()
                        ->getResultArray();
        }

        public function getLast3Status($user_id)
        {
            return $this->select("status")
                        ->where('user_id', $user_id)
                        ->orderBy('tanggal_pemasukan', 'DESC')
                        ->limit(3)
                        ->get()
                        ->getResultArray();
        }

        // ambil kolom tanggal
        public function getAktivitasPemasukan($user_id)
        {
            return $this->select("tanggal_pemasukan as tanggal, 'komisi' as jenis, 'Anda menerima komisi' as keterangan")
                        ->where('user_id', $user_id)
                        ->where('tanggal_pemasukan IS NOT NULL', null, false)
                        ->where('LENGTH(tanggal_pemasukan) > 0', null, false)
                        ->orderBy('tanggal_pemasukan', 'DESC')
                        ->findAll();
        }






}
