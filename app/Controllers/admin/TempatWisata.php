<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TempatWisataModel;
use App\Models\KategoriWisataModel;
use App\Models\KabupatenModel;  // Corrected Model

class TempatWisata extends BaseController
{
    protected $tempatWisataModel;
    protected $kategoriWisataModel;
    protected $kabupatenModel;  // Corrected property

    public function __construct()
    {
        $this->tempatWisataModel = new TempatWisataModel();
        $this->kategoriWisataModel = new KategoriWisataModel();
        $this->kabupatenModel = new KabupatenModel();  // Corrected initialization
    }

    // Display list of wisata
    public function index()
    {
        $data['wisata'] = $this->tempatWisataModel->getAllWisataAdmin();
        return view('admin/wisata/index', $data);
    }

    // Show the form to add new wisata
    public function tambah()
    {
        $kategori_wisata = $this->kategoriWisataModel->findAll();
        $data_wisata = $this->tempatWisataModel->findAll();
        $kotakabupaten = $this->kabupatenModel->findAll();
        $validation = \Config\Services::validation();

        return view('admin/wisata/tambah', [
            'kategori_wisata' => $kategori_wisata,
            'data_wisata' => $data_wisata,
            'kotakabupaten' => $kotakabupaten,
            'validation' => $validation
        ]);
    }

    // Process the form submission for adding new wisata
    public function proses_tambah()
    {
        $validationRules = [
            'foto_wisata' => [
                'rules' => 'uploaded[foto_wisata]|is_image[foto_wisata]|mime_in[foto_wisata,image/jpg,image/jpeg,image/png]',
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
            $file = $this->request->getFile('foto_wisata');

            if ($file->isValid() && !$file->hasMoved()) {
                // Generate nama file dari input nama_oleholeh
                $nama_wisata_ind = $this->request->getPost('nama_wisata_ind');
                $slugName = url_title($nama_wisata_ind, '-', true);
                $newName = $slugName . '-' . time() . '.' . $file->getExtension();

                // Simpan gambar
                $file->move('./asset-user/uploads/foto_wisata/', $newName);

                // Resize gambar
                $this->resizeImage('./asset-user/uploads/foto_wisata/' . $newName, 572, 572);

                $data = [
                    'id_kategori_wisata' => $this->request->getPost('id_kategori_wisata'),
                    'nama_wisata_ind' => $this->request->getPost('nama_wisata_ind'),
                    'nama_wisata_eng' => $this->request->getPost('nama_wisata_eng'),
                    'foto_wisata' => $newName,
                    'sumber_foto' => $this->request->getPost('sumber_foto'),
                    'deskripsi_wisata_ind' => $this->request->getPost('deskripsi_wisata_ind'),
                    'deskripsi_wisata_eng' => $this->request->getPost('deskripsi_wisata_eng'),
                    'id_kotakabupaten' => $this->request->getPost('id_kotakabupaten'),
                    'wisata_latitude' => $this->request->getPost('wisata_latitude'),
                    'wisata_longitude' => $this->request->getPost('wisata_longitude'),
                    'meta_title_id' => $this->request->getPost('meta_title_id'),
                    'meta_title_en' => $this->request->getPost('meta_title_en'),
                    'meta_deskription_id' => $this->request->getPost('meta_deskription_id'),
                    'meta_description_en' => $this->request->getPost('meta_description_en'),
                    'slug_wisata_ind' => url_title($this->request->getPost('nama_wisata_ind'), '-', true),
                    'slug_wisata_eng' => url_title($this->request->getPost('nama_wisata_eng'), '-', true),
                    'views' => 0,
                    'id_penulis' => 1, // Ganti dengan ID user aktif
                ];
                $this->tempatWisataModel->insert($data);

                session()->setFlashdata('success', 'Data berhasil disimpan');
                return redirect()->to(base_url('admin/tempat_wisata/index'));
            } else {
                session()->setFlashdata('error', 'File gagal diunggah');
                return redirect()->back()->withInput();
            }
        }
    }

    public function resizeImage($file, $width, $height)
    {
        $image = \Config\Services::image()
            ->withFile($file)
            ->fit($width, $height, 'center')
            ->save($file);
    }


    // Show the form to edit existing wisata
    public function edit($id_wisata)
    {
        $kategori_wisata = $this->kategoriWisataModel->findAll();
        $data_wisata = $this->tempatWisataModel->find($id_wisata);
        $kotakabupaten = $this->kabupatenModel->findAll();
        $validation = \Config\Services::validation();

        return view('admin/wisata/edit', [
            'kategori_wisata' => $kategori_wisata,
            'wisata' => $data_wisata,
            'kotakabupaten' => $kotakabupaten,
            'validation' => $validation
        ]);
    }

    // Process the form submission for editing existing wisata
    public function proses_edit($id_wisata = null)
    {
        $wisata_data = $this->tempatWisataModel->find($id_wisata);

        if (!$wisata_data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }


        $data = [
            'id_kategori_wisata' => $this->request->getPost('id_kategori_wisata'),
            'nama_wisata_ind' => $this->request->getPost('nama_wisata_ind'),
            'nama_wisata_eng' => $this->request->getPost('nama_wisata_eng'),
            'deskripsi_wisata_ind' => $this->request->getPost('deskripsi_wisata_ind'),
            'deskripsi_wisata_eng' => $this->request->getPost('deskripsi_wisata_eng'),
            'sumber_foto' => $this->request->getPost('sumber_foto'),
            'wisata_latitude' => $this->request->getPost('wisata_latitude'),
            'wisata_longitude' => $this->request->getPost('wisata_longitude'),
            'meta_title_id' => $this->request->getPost('meta_title_id'),
            'meta_title_en' => $this->request->getPost('meta_title_en'),
            'meta_deskription_id' => $this->request->getPost('meta_deskription_id'),
            'meta_description_en' => $this->request->getPost('meta_description_en'),

        ];

        $file = $this->request->getFile('foto_wisata');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($wisata_data['foto_wisata']) && file_exists('./asset-user/uploads/foto_wisata/' . $wisata_data['foto_wisata'])) {
                unlink('./asset-user/uploads/foto_wisata/' . $wisata_data['foto_wisata']);
            }

            // Generate nama file baru berdasarkan nama_oleholeh
            $slugNamaWisata = url_title($this->request->getPost('nama_wisata_ind'), '-', true);
            $newName = $slugNamaWisata . '_' . time() . '.' . $file->getExtension(); // Contoh: nama-wisata_1700000000.jpg

            // Simpan gambar baru
            $path = './asset-user/uploads/foto_wisata/' . $newName;
            $file->move('./asset-user/uploads/foto_wisata/', $newName);

            // Resize gambar
            $this->resizeImage($path, 572, 572);

            $data['foto_wisata'] = $newName; // Tambahkan ke data
        }

        // Update data di database
        $this->tempatWisataModel->update($id_wisata, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to(base_url('admin/tempat_wisata/index'));
    }

    // View detail wisata
    public function detail($id_wisata)
    {
        $wisata = $this->tempatWisataModel->find($id_wisata);

        if (!$wisata) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tempat wisata dengan ID $id_wisata tidak ditemukan.");
        }

        $kategori = $this->kategoriWisataModel->find($wisata['id_kategori_wisata']);
        $kotakab = $this->kabupatenModel->find($wisata['id_kotakabupaten']);

        return view('admin/wisata/detail', [
            'wisata' => $wisata,
            'kategori' => $kategori,
            'kotakabupaten' => $kotakab
        ]);
    }



    // Delete wisata
    public function delete($id_wisata)
    {
        $this->tempatWisataModel->delete($id_wisata);
        return redirect()->to('admin/tempat_wisata/index');
    }
}
