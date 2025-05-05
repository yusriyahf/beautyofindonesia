<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tb_users'; // Nama tabel di database
    protected $primaryKey = 'id_user'; // Nama kolom primary key
    protected $allowedFields = [
        'photo_user',
        'username',
        'email',
        'password',
        'full_name',
        'role',
        'bank_account_number',
        'contact',
        'is_active',
        'created_at',
        'updated_at'
    ]; // Kolom yang dapat diinsert/update
    protected $useTimestamps = true; // Menggunakan timestamp untuk created_at dan updated_at
    protected $createdField = 'created_at'; // Kolom untuk menyimpan waktu dibuat
    protected $updatedField = 'updated_at'; // Kolom untuk menyimpan waktu diperbarui
    protected $returnType = 'array'; // Mengembalikan hasil sebagai array

    // Validasi aturan input untuk user
    protected $validationRules = [
    ];

    // Custom error messages untuk validasi
    protected $validationMessages = [
        'photo_user' => [
            'is_image' => 'File yang diunggah harus berupa gambar.',
            'mime_in' => 'Jenis gambar harus JPG, JPEG, atau PNG.',
            'max_size' => 'Ukuran gambar maksimal 2MB.',
        ],

        'username' => [
            'required' => 'Username harus diisi.',
            'min_length' => 'Username harus terdiri dari minimal 3 karakter.',
            'max_length' => 'Username tidak boleh lebih dari 50 karakter.',
            'is_unique' => 'Username sudah terdaftar.',
        ],
        'email' => [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Email yang dimasukkan tidak valid.',
            'is_unique' => 'Email sudah terdaftar.',
        ],
        'password' => [
            'required' => 'Password harus diisi.',
            'min_length' => 'Password harus terdiri dari minimal 6 karakter.',
        ],
        'full_name' => [
            'required' => 'Nama lengkap harus diisi.',
            'min_length' => 'Nama lengkap harus terdiri dari minimal 3 karakter.',
            'max_length' => 'Nama lengkap tidak boleh lebih dari 100 karakter.',
        ],
        'role' => [
            'required' => 'Role harus diisi.',
            'in_list' => 'Role tidak valid. Pilih antara "admin" atau "user".',
        ],
        'bank_account_number' => [
            'required' => 'Nomor rekening harus diisi.',
            'min_length' => 'Nomor rekening harus terdiri dari minimal 10 karakter.',
            'max_length' => 'Nomor rekening tidak boleh lebih dari 20 karakter.',
        ],
        'is_active' => [
            'required' => 'Status aktif harus diisi.',
            'in_list' => 'Status aktif hanya dapat 0 atau 1.',
        ],
    ];
    // Custom error message untuk validasi
    protected $skipValidation = false; // Set ke false jika Anda ingin validasi dijalankan

    // Fungsi untuk mendapatkan data user berdasarkan ID
    public function getUserById($id)
    {
        return $this->where('id', $id)->first();
    }

    // Fungsi untuk mendapatkan data user berdasarkan username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
