<?php

namespace App\Controllers\User;

use App\Controllers\User\BaseController;
use App\Models\PenulisModel;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\KategoriWisataModel;
use App\Models\KategoriOlehOlehModel;

class Penulisctrl extends BaseController
{
    private $PenulisModel;
    private $ArtikelModel;
    private $KategoriModel;
    private $KategoriWisataModel;
    private $KategoriOlehOlehModel;


    public function __construct()
    {
        $this->PenulisModel = new PenulisModel();
        $this->ArtikelModel = new ArtikelModel();
        $this->KategoriModel = new KategoriModel();
        $this->KategoriWisataModel = new KategoriWisataModel();
        $this->KategoriOlehOlehModel = new KategoriOlehOlehModel();
    }

    public function index()
    {
        $data = [

            'penulis' => $this->PenulisModel->findAll(),
            'kategori' => $this->KategoriModel->getKategori(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
        ];

        return view('user/penulis/index', $data);
    }

    public function viewPenulis($id_penulis)
    {
        $data = [
            'penulis' => $this->PenulisModel->find($id_penulis),
            'artikel' => $this->ArtikelModel->getArtikelPenulis($id_penulis, 5),
            'penulis_lain' => $this->PenulisModel->getPenulisLainnya($id_penulis, 4),
            'kategori' => $this->KategoriModel->getKategori()
        ];


        return view('user/penulis/detail', $data);
    }
    
    public function artikelPenulis($id_penulis)
    {
        // echo "Debug: ID Penulis = " . $id_penulis;
        $data = [
            'nama_penulis' => $this->PenulisModel->find($id_penulis),
            'artikel_penulis' => $this->ArtikelModel->getSemuaArtikelPenulis($id_penulis),
            'artikel' => $this->ArtikelModel->getArtikelRandom(),
            'kategori' => $this->KategoriModel->getKategori()
        ];


        return view('user/penulis/artikel_penulis', $data);
    }
}
