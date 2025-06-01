<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OlehOlehModel;
use App\Models\KategoriOlehOlehModel;
use App\Models\KabupatenModel;
use CodeIgniter\Config\Services;
use App\Models\ProvinsiModel;

class OlehOleh extends BaseController
{
    protected $olehOlehModel;
    protected $kategoriOlehOlehModel;
    protected $kabupatenModel;
    protected $db;

    public function __construct()
    {
        $this->olehOlehModel = new OlehOlehModel();
        $this->kategoriOlehOlehModel = new KategoriOlehOlehModel();
        $this->kabupatenModel = new KabupatenModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id_user'); // Asumsikan id user disimpan di session

        if ($role == 'penulis') {
            // Jika penulis, hanya ambil oleh-oleh yang dibuatnya
            $data_oleh_oleh = $this->olehOlehModel->getOlehOlehByPenulis($userId);
        } else {
            // Jika admin, ambil semua oleh-oleh
            $data_oleh_oleh = $this->olehOlehModel->getAllOlehOleh();
        }

        return view('admin/oleh_oleh/index', [
            'data_oleh_oleh' => $data_oleh_oleh,
            'pager' => $this->olehOlehModel->pager
        ]);
    }


    public function tambah()
    {
        $kategori_oleh_oleh = $this->kategoriOlehOlehModel->findAll();
        $data_oleh_oleh = $this->olehOlehModel->findAll();
        $kotakabupaten = $this->kabupatenModel->findAll();
        $validation = \Config\Services::validation();
        $provinsi_model = new ProvinsiModel();
        $all_data_provinsi = $provinsi_model->findAll();

        return view('admin/oleh_oleh/tambah', [
            'kategori_oleh_oleh' => $kategori_oleh_oleh,
            'data_oleh_oleh' => $data_oleh_oleh,
            'kotakabupaten' => $kotakabupaten,
            'all_data_provinsi' => $all_data_provinsi,
            'validation' => $validation
        ]);
    }

    public function proses_tambah()
    {
        $validationRules = [
            'foto_oleholeh' => [
                'rules' => 'uploaded[foto_oleholeh]|is_image[foto_oleholeh]|mime_in[foto_oleholeh,image/jpg,image/jpeg,image/png]',
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
            $file = $this->request->getFile('foto_oleholeh');

            if ($file->isValid() && !$file->hasMoved()) {
                // Generate nama file dari input nama_oleholeh
                $namaOlehOleh = $this->request->getPost('nama_oleholeh');
                $slugName = url_title($namaOlehOleh, '-', true);
                $newName = $slugName . '-' . time() . '.' . $file->getExtension();

                // Simpan gambar
                $file->move('./assets-baru/img/foto_oleholeh/', $newName);

                // Resize gambar dan pastikan 1:1 rasio
                $this->resizeImage('./assets-baru/img/foto_oleholeh/' . $newName, 572, 572);

                // Simpan ke database
                $data = [
                    'id_kategori_oleholeh' => $this->request->getPost('id_kategori_oleholeh'),
                    'nama_oleholeh' => $this->request->getPost('nama_oleholeh'),
                    'nama_oleholeh_eng' => $this->request->getPost('nama_oleholeh_eng'),
                    'foto_oleholeh' => $newName,
                    'sumber_foto' => $this->request->getPost('sumber_foto'),
                    'deskripsi_oleholeh' => $this->request->getPost('deskripsi_oleholeh'),
                    'deskripsi_oleholeh_eng' => $this->request->getPost('deskripsi_oleholeh_eng'),
                    'id_kotakabupaten' => $this->request->getPost('id_kotakabupaten'),
                    'views' => 0,
                    'slug_oleholeh' => url_title($this->request->getPost('nama_oleholeh'), '-', true),
                    'slug_en' => url_title($this->request->getPost('nama_oleholeh_eng'), '-', true),
                    'nomor_tlp' => $this->request->getPost('nomor_tlp'),
                    'link_website' => $this->request->getPost('link_website'),
                    'oleholeh_latitude' => $this->request->getPost('oleholeh_latitude'),
                    'oleholeh_longitude' => $this->request->getPost('oleholeh_longitude'),
                    'meta_title_id' => $this->request->getPost('meta_title_id'),
                    'meta_title_en' => $this->request->getPost('meta_title_en'),
                    'meta_description_id' => $this->request->getPost('meta_description_id'),
                    'meta_description_en' => $this->request->getPost('meta_description_en'),
                    'id_penulis' => session()->get('id_user'), // Ambil id penulis dari session
                ];

                $this->olehOlehModel->insert($data);

                session()->setFlashdata('success', 'Data berhasil disimpan');
                 $role = session()->get('role');
                return redirect()->to(base_url($role . '/oleh_oleh/index'));
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
            ->fit($width, $height, 'center') // Pastikan rasio 1:1 dengan memotong jika diperlukan
            ->save($file);
    }



    public function edit($id_oleholeh)
    {
        $kategori_oleh_oleh = $this->kategoriOlehOlehModel->findAll();
        $data_oleh_oleh = $this->olehOlehModel->find($id_oleholeh);
        $kotakabupaten = $this->kabupatenModel->findAll();
        $validation = \Config\Services::validation();
        $provinsi_model = new ProvinsiModel();
        $all_data_provinsi = $provinsi_model->findAll();

        return view('admin/oleh_oleh/edit', [
            'kategori_oleh_oleh' => $kategori_oleh_oleh,
            'oleh_oleh' => $data_oleh_oleh,
            'kotakabupaten' => $kotakabupaten,
            'all_data_provinsi' => $all_data_provinsi,
            'validation' => $validation
        ]);
    }




    public function proses_edit($id_oleholeh = null)
    {
        $oleh_oleh_data = $this->olehOlehModel->find($id_oleholeh);

        if (!$oleh_oleh_data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Data default
        $data = [
            'id_kategori_oleholeh' => $this->request->getPost('id_kategori_oleholeh'),
            'id_kotakabupaten' => $this->request->getPost('id_kotakabupaten'),
            'nama_oleholeh' => $this->request->getPost('nama_oleholeh'),
            'nama_oleholeh_eng' => $this->request->getPost('nama_oleholeh_eng'),
            'deskripsi_oleholeh' => $this->request->getPost('deskripsi_oleholeh'),
            'deskripsi_oleholeh_eng' => $this->request->getPost('deskripsi_oleholeh_eng'),
            'nomor_tlp' => $this->request->getPost('nomor_tlp'),
            'link_website' => $this->request->getPost('link_website'),
            'sumber_foto' => $this->request->getPost('sumber_foto'),
            'oleholeh_latitude' => $this->request->getPost('oleholeh_latitude'),
            'oleholeh_longitude' => $this->request->getPost('oleholeh_longitude'),
            'slug_oleholeh' => url_title($this->request->getPost('nama_oleholeh'), '-', true),
            'slug_en' => url_title($this->request->getPost('nama_oleholeh_eng'), '-', true),
            'meta_title_id' => $this->request->getPost('meta_title_id'),
            'meta_title_en' => $this->request->getPost('meta_title_en'),
            'meta_description_id' => $this->request->getPost('meta_description_id'),
            'meta_description_en' => $this->request->getPost('meta_description_en'),
        ];

        // Proses upload gambar jika ada file baru
        $file = $this->request->getFile('foto_oleholeh');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($oleh_oleh_data['foto_oleholeh']) && file_exists('./assets-baru/img/foto_oleholeh/' . $oleh_oleh_data['foto_oleholeh'])) {
                unlink('./assets-baru/img/foto_oleholeh/' . $oleh_oleh_data['foto_oleholeh']);
            }

            // Generate nama file baru berdasarkan nama_oleholeh
            $slugNamaOlehOleh = url_title($this->request->getPost('nama_oleholeh'), '-', true);
            $newName = $slugNamaOlehOleh . '_' . time() . '.' . $file->getExtension(); // Contoh: nama-oleh-oleh_1700000000.jpg

            // Simpan gambar baru
            $path = './assets-baru/img/foto_oleholeh/' . $newName;
            $file->move('./assets-baru/img/foto_oleholeh/', $newName);

            // Resize gambar
            $this->resizeImage($path, 572, 572);

            $data['foto_oleholeh'] = $newName; // Tambahkan ke data
        }

        // Update data di database
        $this->olehOlehModel->update($id_oleholeh, $data);

        session()->setFlashdata('success', 'Data berhasil diperbarui');
        $role = session()->get('role');
        return redirect()->to(base_url($role . '/oleh_oleh/index'));
    }


    public function delete($id_oleholeh)
    {
        $this->olehOlehModel->delete($id_oleholeh);
        $role = session()->get('role');
        return redirect()->to($role . '/oleh_oleh/index');
    }

    public function detail($slug)
    {
        // Get the oleh-oleh detail by slug
        $oleholeh = $this->olehOlehModel->getOlehOlehDetailBySlug($slug);

        // Check if data exists
        if (!$oleholeh) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Oleh-oleh tidak ditemukan');
        }

        // Increment view count
        $this->olehOlehModel->increaseViews($oleholeh['id_oleholeh']);

        // Get related oleh-oleh from same category
        $relatedOlehOleh = $this->olehOlehModel->getRandomOlehOlehByKategori($oleholeh['id_kategori_oleholeh']);

        // Get related oleh-oleh from same kabupaten
        $relatedByKabupaten = $this->olehOlehModel->getRandomOlehOlehByKabupaten($oleholeh['id_kotakabupaten']);

        $data = [
            'title' => $oleholeh['nama_oleholeh'] . ' | Detail Oleh-Oleh',
            'oleholeh' => $oleholeh,
            'relatedOlehOleh' => $relatedOlehOleh,
            'relatedByKabupaten' => $relatedByKabupaten,
        ];

        return view('admin/oleh_oleh/detail', $data);
    }

    public function incrementWhatsapp($id)
    {
        // Increment whatsapp click count
        $this->olehOlehModel->incrementWhatsappClicks($id);

        // Return JSON response
        return $this->response->setJSON(['success' => true]);
    }
}
