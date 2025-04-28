<?php

namespace App\Controllers\admin;

use App\Models\ArtikelIklanModel;
use App\Models\ArtikelModel;
use App\Models\HargaIklanModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\TentangModel;
use CodeIgniter\Config\Services;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{

    private $ArtikelModel;
    private $hargaIklanModel;
    private $KategoriModel;
    private $PenulisModel;
    private $TentangModel;
    private $ArtikelIklanModel;


    public function __construct()
    {
        $this->hargaIklanModel = new HargaIklanModel();
        $this->ArtikelModel = new ArtikelModel();
        $this->KategoriModel = new KategoriModel();
        $this->PenulisModel = new PenulisModel();
        $this->TentangModel = new TentangModel();
        $this->ArtikelIklanModel = new ArtikelIklanModel();
    }

    public function index()
    {
        // Pengecekan apakah pengguna sudah login atau belum
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
            // Ubah 'login' sesuai dengan halaman login Anda
        }
        $all_data_artikel = $this->ArtikelModel->getArtikel();
        $validation = \Config\Services::validation();
        return view('admin/artikel/index', [
            'all_data_artikel' => $all_data_artikel,
            'validation' => $validation
        ]);
    }
    public function viewArtikel($id_artikel, $slug)
    {
        $lang = session()->get('lang') ?? 'id'; // 'id' as default if not set

        $detail_artikel = $this->ArtikelModel->getDetailArtikel($id_artikel, $slug);

        if (!$detail_artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $judul_artikel = $detail_artikel['judul_artikel'] ?? 'Judul Artikel Tidak Ditemukan';
        $judul_artikel = strlen($judul_artikel) > 50 ? substr($judul_artikel, 0, 50) . '...' : $judul_artikel;

        $nama_tentang = $this->TentangModel->getNamaTentang(); // Jika Anda ingin menggunakan TentangModel, pastikan sudah di-load

        $title = "$judul_artikel - $nama_tentang";

        // Mengambil foto artikel dari data yang ditemukan
        $foto_artikel = $detail_artikel['foto_artikel'] ?? 'default.jpg';

        $data = [
            'artikel' => $detail_artikel,
            'artikel_lain' => $this->ArtikelModel->getArtikelLainnya($id_artikel, 4),
            'kategori' => $this->KategoriModel->getKategori(),
            'tentang' => $this->TentangModel->getTentangDepan(), // Pastikan sudah ada instance TentangModel
            'title' => $title,
            'foto_artikel' => $foto_artikel // Menyertakan foto artikel ke data yang dikirimkan ke view
        ];

        return view('user/home/detail', $data);
    }


    public function tambah()
    {
        $all_data_artikel = $this->ArtikelModel->findAll();
        $all_data_kategori = $this->KategoriModel->findAll();
        $all_data_penulis = $this->PenulisModel->findAll();
        $validation = \Config\Services::validation();
        return view('admin/artikel/tambah', [
            'all_data_artikel' => $all_data_artikel,
            'all_data_kategori' => $all_data_kategori,
            'all_data_penulis' => $all_data_penulis,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $validationRules = [
            'foto_artikel' => [
                'rules' => 'uploaded[foto_artikel]|is_image[foto_artikel]|mime_in[foto_artikel,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih foto terlebih dahulu',
                    'is_image' => 'File yang anda pilih bukan gambar',
                    'mime_in' => 'File yang anda pilih wajib berekstensikan jpg/jpeg/png'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        } else {
            $file = $this->request->getFile('foto_artikel');

            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $path = './assets-baru/img/foto_artikel/' . $newName;

                $file->move('./assets-baru/img/foto_artikel/', $newName);

                $this->resizeImage($path, 572, 572); // Mengubah ukuran gambar

                $data = [
                    'judul_artikel' => $this->request->getPost("judul_artikel"),
                    'judul_artikel_en' => $this->request->getPost("judul_artikel_en"),
                    'id_kategori' => $this->request->getPost("id_kategori"),
                    'id_penulis' => $this->request->getPost("id_penulis"),
                    'deskripsi_artikel' => $this->request->getPost("deskripsi_artikel"),
                    'deskripsi_artikel_en' => $this->request->getPost("deskripsi_artikel_en"),
                    'tags' => $this->request->getPost("tags"),

                    'tags_en' => $this->request->getPost("tags_en"),
                    'sumber_foto' => $this->request->getPost("sumber_foto"),
                    'meta_title_id' => $this->request->getPost("meta_title_id"),
                    'meta_title_en' => $this->request->getPost("meta_title_en"),
                    'meta_deskription_id' => $this->request->getPost("meta_deskription_id"),
                    'meta_description_en' => $this->request->getPost("meta_description_en"),
                    'tgl_publish' => $this->request->getPost("tgl_publish"),
                    'foto_artikel' => $newName,
                    'slug' => url_title($this->request->getPost('judul_artikel'), '-', TRUE),
                    'slug_en' => url_title($this->request->getPost('judul_artikel_en'), '-', TRUE)
                ];

                $this->ArtikelModel->insert($data);

                session()->setFlashdata('success', 'Data berhasil disimpan');
                return redirect()->to(base_url('admin/artikel/index'));
            } else {
                session()->setFlashdata('error', 'File gagal diunggah');
                return redirect()->back()->withInput();
            }
        }
    }



    public function edit($id_artikel)
    {
        $artikelData = $this->ArtikelModel->find($id_artikel);

        $validation = \Config\Services::validation();

        return view('admin/artikel/edit', [
            'artikelData' => $artikelData,
            'validation' => $validation
        ]);
    }

    // Artikel.php (Controller)
    public function proses_edit($id_artikel = null)
    {
        $artikelData = $this->ArtikelModel->find($id_artikel);

        if (!$artikelData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'judul_artikel' => $this->request->getPost("judul_artikel"),
            'judul_artikel_en' => $this->request->getPost("judul_artikel_en"),
            'deskripsi_artikel' => $this->request->getPost("deskripsi_artikel"),
            'deskripsi_artikel_en' => $this->request->getPost("deskripsi_artikel_en"),
            'tags' => $this->request->getPost("tags"),
            'tags_en' => $this->request->getPost("tags_en"),
            'meta_title_id' => $this->request->getPost("meta_title_id"),
            'meta_title_en' => $this->request->getPost("meta_title_en"),
            'meta_description_id' => $this->request->getPost("meta_description_id"),
            'meta_description_en' => $this->request->getPost("meta_description_en"),
            'tgl_publish' => $this->request->getPost("tgl_publish"),
            'slug' => url_title($this->request->getPost('judul_artikel'), '-', TRUE)
        ];

        $file = $this->request->getFile('foto_artikel');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $path = './assets-baru/img/foto_artikel/' . $newName;

            $file->move('./assets-baru/img/foto_artikel/', $newName);
            $this->resizeImage($path, 572, 572);
            $data['foto_artikel'] = $newName;
        }

        $this->ArtikelModel->update($id_artikel, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/artikel/index'));
    }


    public function resizeImage($file, $width, $height)
    {
        $image = Services::image()
            ->withFile($file)
            ->fit($width, $height, 'center')
            ->save($file);
    }

    public function delete($id = false)
    {
        $artikelModel = new ArtikelModel();

        // Cari data artikel berdasarkan ID
        $data = $artikelModel->find($id);

        if (!$data) {
            session()->setFlashdata('error', 'Data artikel tidak ditemukan');
            return redirect()->to(base_url('admin/artikel/index'));
        }

        // Lokasi file gambar
        $filePath = 'assets-baru/img/foto_artikel/' . $data->foto_artikel;

        // Cek apakah file ada sebelum menghapus
        if (file_exists($filePath)) {
            unlink($filePath);
        } else {
            session()->setFlashdata('warning', 'File gambar tidak ditemukan, hanya data yang dihapus');
        }

        // Hapus data artikel dari database
        $artikelModel->delete($id);

        session()->setFlashdata('success', 'Artikel berhasil dihapus');
        return redirect()->to(base_url('admin/artikel/index'));
    }

    // Artikel Iklan
    public function artikel_iklan()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Ambil data artikel beriklan berdasarkan filter tanggal jika ada
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $all_data = $this->ArtikelIklanModel->getArtikelIklanByDateFilter($startDate, $endDate) ?? [];

        // Validasi
        $validation = \Config\Services::validation();

        return view('admin/artikel/artikel_iklan', [
            'all_data' => $all_data,
            'validation' => $validation
        ]);
    }

    public function tambah_artikel_iklan()
    {
        $artikelModel = new \App\Models\ArtikelModel();
        $hargaIklanModel = new \App\Models\HargaIklanModel(); // model harga iklan

        $data['artikel'] = $artikelModel->findAll(); // object
        $data['harga_iklan'] = $hargaIklanModel->findAll(); // object

        return view('admin/artikel/tambah_artikel_iklan', $data);
    }

    public function simpan_iklan()
    {
        // Memuat model yang diperlukan
        $model = new \App\Models\ArtikelIklanModel();
        $hargaIklanModel = new \App\Models\HargaIklanModel();

        // Ambil ID user dari session
        $idPenulis = session()->get('id_user');

        // Validasi jika tidak ada ID user di session
        if (!$idPenulis) {
            return redirect()->back()->with('error', 'User tidak ditemukan dalam sesi.');
        }

        // Ambil harga iklan berdasarkan ID yang dipilih
        $hargaData = $hargaIklanModel->find($this->request->getPost('id_harga_iklan'));
        if (!$hargaData) {
            return redirect()->back()->with('error', 'Harga iklan tidak ditemukan.');
        }

        // Ambil harga per bulan dan rentang bulan dari input
        $hargaPerBulan = (int) $hargaData['harga'];
        $rentangBulan = (int) $this->request->getPost('rentang_bulan');

        // Hitung total harga
        $totalHarga = $hargaPerBulan * $rentangBulan;

        // Menyiapkan data untuk disimpan
        $data = [
            'id_artikel'        => $this->request->getPost('id_artikel'),
            'id_harga_iklan'    => $this->request->getPost('id_harga_iklan'),
            'id_marketing'      => $idPenulis,
            'rentang_bulan'     => $rentangBulan,
            'total_harga'       => $totalHarga,
            'tanggal_pengajuan' => date('Y-m-d'), // Tanggal pengajuan otomatis
            'status_iklan'      => 'Diajukan',    // Status default adalah 'Diajukan'
            'catatan_admin'     => $this->request->getPost('catatan_admin'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Menyimpan data iklan ke database
        $model->insert($data);

        // Kembali ke halaman artikel beriklan dengan pesan sukses
        return redirect()->to(base_url('admin/artikel/artikel_beriklan'))->with('success', 'Data iklan berhasil disimpan');
    }
}
