<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\PopupModel;

class PopupController extends BaseController
{
    private $popupModel;

    public function __construct()
    {
        $this->popupModel = new PopupModel();
    }

    public function checkPopup()
    {
        // Ambil URL saat ini
        $currentUrl = current_url();

        // Cek apakah URL ada di link_tampil
        $popupData = $this->popupModel->findByUrl($currentUrl);

        if ($popupData) {
            // Siapkan data untuk tampilan popup
            return view('user/popup/index', ['popup' => $popupData]);
        }

        // Jika tidak ada popup, kembalikan null atau kosong
        return null;
    }
}
