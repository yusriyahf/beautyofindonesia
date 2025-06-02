<?php

namespace App\Models;

use CodeIgniter\Model;


class KomisiIklanModel extends Model
{
    protected $table = 'tb_komisi_iklan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_iklan',
        'tipe_iklan',
        'id_user',
        'peran',
        'persen',
        'jumlah_komisi',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    // Validation
    protected $validationRules = [
        'id_iklan' => 'required|integer',
        'tipe_iklan' => 'required|in_list[konten,utama]',
        'id_user' => 'required|integer',
        'peran' => 'required|in_list[penulis,marketing,admin]',
        'persen' => 'required|integer|greater_than[0]|less_than_equal_to[100]',
        'jumlah_komisi' => 'required|integer|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'id_iklan' => [
            'required' => 'ID Iklan harus diisi',
            'integer' => 'ID Iklan harus berupa angka'
        ],
        'tipe_iklan' => [
            'required' => 'Tipe Iklan harus diisi',
            'in_list' => 'Tipe Iklan tidak valid'
        ],
        'id_user' => [
            'required' => 'ID User harus diisi',
            'integer' => 'ID User harus berupa angka'
        ],
        'peran' => [
            'required' => 'Peran harus diisi',
            'in_list' => 'Peran tidak valid'
        ],
        'persen' => [
            'required' => 'Persentase harus diisi',
            'integer' => 'Persentase harus berupa angka',
            'greater_than' => 'Persentase harus lebih dari 0',
            'less_than_equal_to' => 'Persentase tidak boleh lebih dari 100'
        ],
        'jumlah_komisi' => [
            'required' => 'Jumlah komisi harus diisi',
            'integer' => 'Jumlah komisi harus berupa angka',
            'greater_than_equal_to' => 'Jumlah komisi tidak boleh negatif'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['setCreatedAt'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];


    /**
     * Set created_at field before insert
     */
    protected function setCreatedAt(array $data)
    {
        if (!isset($data['data']['created_at'])) {
            $data['data']['created_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }

    /**
     * Get komisi by iklan id
     * 
     * @param int $iklanId
     * @return array
     */
    public function getKomisiByIklan($iklanId)
    {
        return $this->where('id_iklan', $iklanId)->findAll();
    }

    /**
     * Get komisi by iklan and peran
     * 
     * @param int $iklanId
     * @param string $peran
     * @return array|null
     */
    public function getKomisiByPeran($iklanId, $peran)
    {
        return $this->where([
            'id_iklan' => $iklanId,
            'peran' => $peran
        ])->first();
    }

    /**
     * Get komisi by iklan and user
     * 
     * @param int $iklanId
     * @param int $userId
     * @return array|null
     */
    public function getKomisiByUser($iklanId, $userId)
    {
        return $this->where([
            'id_iklan' => $iklanId,
            'id_user' => $userId
        ])->first();
    }

    /**
     * Check if custom commission exists for iklan
     * 
     * @param int $iklanId
     * @return bool
     */
    public function hasCustomCommission($iklanId)
    {
        $count = $this->where('id_iklan', $iklanId)->countAllResults();
        return $count > 0;
    }

    /**
     * Get total komisi for iklan
     * 
     * @param int $iklanId
     * @return float
     */
    public function getTotalKomisi($iklanId)
    {
        $result = $this->selectSum('jumlah_komisi')
            ->where('id_iklan', $iklanId)
            ->first();

        return $result['jumlah_komisi'] ?? 0;
    }

    /**
     * Get total persen for iklan
     * 
     * @param int $iklanId
     * @return int
     */
    public function getTotalPersen($iklanId)
    {
        $result = $this->selectSum('persen')
            ->where('id_iklan', $iklanId)
            ->first();

        return $result['persen'] ?? 0;
    }

    /**
     * Delete komisi by iklan
     * 
     * @param int $iklanId
     * @return bool
     */
    public function deleteKomisiByIklan($iklanId)
    {
        return $this->where('id_iklan', $iklanId)->delete();
    }

    /**
     * Update or insert komisi
     * 
     * @param array $data
     * @return bool
     */
    public function updateOrInsertKomisi($data)
    {
        $existing = $this->getKomisiByPeran($data['id_iklan'], $data['peran']);

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    /**
     * Get komisi with user details
     * 
     * @param int $iklanId
     * @return array
     */
    public function getKomisiWithUser($iklanId)
    {
        return $this->select('tb_komisi_iklan.*, tb_users.username, tb_users.full_name, tb_users.email')
            ->join('tb_users', 'tb_users.id_user = tb_komisi_iklan.id_user', 'left')
            ->where('tb_komisi_iklan.id_iklan', $iklanId)
            ->findAll();
    }

    /**
     * Get komisi by user ID across all iklan
     * 
     * @param int $userId
     * @return array
     */
    public function getKomisiByUserId($userId)
    {
        return $this->where('id_user', $userId)->findAll();
    }

    /**
     * Get komisi statistics by peran
     * 
     * @return array
     */
    public function getKomisiStatsByPeran()
    {
        return $this->select('peran, COUNT(*) as total_records, SUM(jumlah_komisi) as total_komisi')
            ->groupBy('peran')
            ->findAll();
    }


    // Tambahkan di bagian atas class


    // Method untuk memformat jumlah komisi setelah query
    protected function formatAmount(array $data)
    {
        if (!empty($data['data'])) {
            if (isset($data['data'][0])) {
                foreach ($data['data'] as &$row) {
                    if (isset($row['jumlah_komisi'])) {
                        $row['jumlah_komisi_formatted'] = 'Rp ' . number_format($row['jumlah_komisi'], 0, ',', '.');
                    }
                }
            } else {
                if (isset($data['data']['jumlah_komisi'])) {
                    $data['data']['jumlah_komisi_formatted'] = 'Rp ' . number_format($data['data']['jumlah_komisi'], 0, ',', '.');
                }
            }
        }
        return $data;
    }

    // Perbaikan getKomisiWithDetails
public function getKomisiWithDetails()
{
    return $this->select('tb_komisi_iklan.*, tb_users.username, tb_users.email')
        ->join('tb_users', 'tb_users.id_user = tb_komisi_iklan.id_user', 'left')
        ->orderBy('tb_komisi_iklan.created_at', 'DESC')
        ->findAll();
}

// Perbaikan getWithIklanDetails
public function getWithIklanDetails($id)
{
    return $this->select('tb_komisi_iklan.*, tb_artikel_iklan.judul as judul_iklan, tb_users.username')
        ->join('tb_artikel_iklan', 'tb_artikel_iklan.id = tb_komisi_iklan.id_iklan', 'left')
        ->join('tb_users', 'tb_users.id_user = tb_komisi_iklan.id_user', 'left')
        ->where('tb_komisi_iklan.id', $id)
        ->first();
}

// Tambahkan method baru untuk dashboard
public function getRecentKomisi($limit = 5)
{
    return $this->select('tb_komisi_iklan.*, tb_users.username, tb_artikel_iklan.judul as judul_iklan')
        ->join('tb_users', 'tb_users.id_user = tb_komisi_iklan.id_user', 'left')
        ->join('tb_artikel_iklan', 'tb_artikel_iklan.id = tb_komisi_iklan.id_iklan', 'left')
        ->orderBy('tb_komisi_iklan.created_at', 'DESC')
        ->limit($limit)
        ->findAll();
}

// Method untuk laporan bulanan
public function getMonthlyReport($year, $month)
{
    return $this->select("DATE_FORMAT(created_at, '%Y-%m-%d') as tanggal, peran, SUM(jumlah_komisi) as total")
        ->where('YEAR(created_at)', $year)
        ->where('MONTH(created_at)', $month)
        ->groupBy('tanggal, peran')
        ->orderBy('tanggal')
        ->findAll();
}
}
