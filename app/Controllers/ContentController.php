<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PopupModel;

class ContentController extends BaseController
{
    protected $lang;
    protected $uri;
    private $popupModel;

    public function __construct()
    {
        $this->lang = session()->get('lang') ?? 'id';
        $this->uri = service('uri');
        $this->popupModel = new PopupModel();
    }

    public function index()
    {
        // Ambil segmen kedua dari URL
        $segment = $this->uri->getSegment(2);
        $canonical = site_url();

        // Tentukan canonical URL berdasarkan segment yang diminta
        if ($segment === 'destinations' || $segment === 'wisata') {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'wisata' : 'destinations'));
        } elseif ($segment === 'souvenirs' || $segment === 'oleh-oleh') {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'oleh-oleh' : 'souvenirs'));
        } elseif ($segment === 'about' || $segment === 'tentang') {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'tentang' : 'about'));
        } elseif ($segment === 'article' || $segment === 'artikel') {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'artikel' : 'article'));
        }

        // Jika URL tidak sesuai dengan canonical, lakukan redirect
        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }

        // Cek popup untuk halaman ini
        // $currentUrl = current_url();
        // $popupData = $this->popupModel->findByUrl($currentUrl);
        // $popupView = $popupData ? view('user/popup/index', ['popup' => $popupData]) : null;

        // // Render tampilan dengan popup jika ada
        // return view('content/index', ['popup' => $popupView]);
    }

    public function category()
    {
        $segment1 = $this->uri->getSegment(2); // aktivitas atau artikel
        $segment2 = $this->uri->getSegment(3); // kategori
        $canonical = site_url();

        if (($segment1 === 'wisata' || $segment1 === 'destinations') && $segment2) {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'wisata' : 'destinations') . "/$segment2");
        } elseif (($segment1 === 'oleh-oleh' || $segment1 === 'souvenirs') && $segment2) {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'oleh-oleh' : 'souvenirs') . "/$segment2");
        } elseif (($segment1 === 'artikel' || $segment1 === 'article') && $segment2) {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'artikel' : 'article') . "/$segment2");
        }

        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }
    }

    public function detail()
    {
        $segment1 = $this->uri->getSegment(2); // aktivitas atau artikel
        $segment2 = $this->uri->getSegment(3); // kategori
        $segment3 = $this->uri->getSegment(4); // slug detail
        $canonical = site_url();

        if (($segment1 === 'wisata' || $segment1 === 'destinations') && $segment2 && $segment3) {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'wisata' : 'destinations') . "/$segment2/$segment3");
        } elseif (($segment1 === 'artikel' || $segment1 === 'article') && $segment2 && $segment3) {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'artikel' : 'article') . "/$segment2/$segment3");
        } elseif (($segment1 === 'oleh-oleh' || $segment1 === 'souvenirs') && $segment2 && $segment3) {
            $canonical = base_url("$this->lang/" . ($this->lang === 'id' ? 'oleh-oleh' : 'souvenirs') . "/$segment2/$segment3");
        }

        if (current_url() !== $canonical) {
            return redirect()->to($canonical);
        }
    }
}
