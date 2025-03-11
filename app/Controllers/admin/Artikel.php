<?php

namespace App\Controllers\admin;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\TentangModel;
use CodeIgniter\Config\Services;

class Artikel extends BaseController
{

    private $ArtikelModel;
    private $KategoriModel;
    private $PenulisModel;
    private $TentangModel;


    public function __construct()
    {
        $this->ArtikelModel = new ArtikelModel();
        $this->KategoriModel = new KategoriModel();
        $this->PenulisModel = new PenulisModel();
        $this->TentangModel = new TentangModel();
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
}
