<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PopupModel;
use App\Models\TampilPopupModel;

class PopupController extends BaseController
{
    private $popupModel;
    private $tampilPopupModel;

    public function __construct()
    {
        $this->popupModel = new PopupModel();
        $this->tampilPopupModel = new TampilPopupModel();
    }

    public function checkPopup()
    {
        $currentUrl = current_url();

        // Ambil data popup dari model
        $popupLinks = $this->tampilPopupModel->getPopupByUrl($currentUrl);

        foreach ($popupLinks as $popup) {
            if ($popup['jenis_url_tampil_popup'] === 'URL Only' && $popup['url_tampil_popup'] === $currentUrl) {
                return view('user/popup/index', ['popup' => $popup]);
            } elseif ($popup['jenis_url_tampil_popup'] === 'URL & Prefix' && strpos($currentUrl, $popup['url_tampil_popup']) === 0) {
                return view('user/popup/index', ['popup' => $popup]);
            }
        }

        return null;
    }
}
