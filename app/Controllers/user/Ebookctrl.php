<?php

namespace App\Controllers\user;

use App\Controllers\user\BaseController;
use App\Models\EbookModel;
use App\Models\KategoriModel;
use App\Models\KategoriWisataModel;
use App\Models\KategoriOlehOlehModel;

class Ebookctrl extends BaseController
{
    private $EbookModel;
    private $KategoriModel;
    private $KategoriWisataModel;
    private $KategoriOlehOlehModel;


    public function __construct()
    {
        $this->EbookModel = new EbookModel();
        $this->KategoriModel = new KategoriModel();
        $this->KategoriWisataModel = new KategoriWisataModel();
        $this->KategoriOlehOlehModel = new KategoriOlehOlehModel();
    }

    public function index()
    {
        $data = [

            'ebook' => $this->EbookModel->findAll(),
            'kategori' => $this->KategoriModel->getKategori()
        ];

        return view('user/ebook/index', $data);
    }

    public function viewEbook($id_ebook)
    {
        $data = [
            'ebook' => $this->EbookModel->find($id_ebook),
            // 'artikel' => $this->ArtikelModel->getArtikelPenulis($id_penulis, 5),
            'ebook_lain' => $this->EbookModel->getEbookLainnya($id_ebook, 8),
            'kategori' => $this->KategoriModel->getKategori(),
            'kategoriwisata' => $this->KategoriWisataModel->getKategoriWisata(),
            'kategoriOlehOleh' => $this->KategoriOlehOlehModel->getKategoriOlehOleh(),
        ];


        return view('user/ebook/detail', $data);
    }
    
    // public function artikelPenulis($id_penulis)
    // {
    //     // echo "Debug: ID Penulis = " . $id_penulis;
    //     $data = [
    //         'nama_penulis' => $this->PenulisModel->find($id_penulis),
    //         'artikel_penulis' => $this->ArtikelModel->getSemuaArtikelPenulis($id_penulis),
    //         'artikel' => $this->ArtikelModel->getArtikelRandom(),
    //         'kategori' => $this->KategoriModel->getKategori()
    //     ];


    //     return view('user/penulis/artikel_penulis', $data);
    // }
}
