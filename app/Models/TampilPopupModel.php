<?php

namespace App\Models;

use CodeIgniter\Model;

class TampilPopupModel extends Model
{
    protected $table = 'tb_link_tampil_popup';
    protected $primaryKey = 'id_link_tampil_popup';
    protected $returnType = 'array';
    protected $allowedFields = ['id_link_tampil_popup', 'id_popup', 'url_tampil_popup', 'jenis_url_tampil_popup'];

    public function getPopupByUrl($url)
    {
        return $this->select('tb_popup.*, tb_link_tampil_popup.jenis_url_tampil_popup, tb_link_tampil_popup.url_tampil_popup')
            ->join('tb_popup', 'tb_popup.id_popup = tb_link_tampil_popup.id_popup')
            ->where('tb_link_tampil_popup.url_tampil_popup', $url)
            ->orWhere('tb_link_tampil_popup.jenis_url_tampil_popup', 'URL & Prefix')
            ->findAll();
    }
}
