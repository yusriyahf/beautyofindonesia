<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RedirectOleholeh implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $request = service('request'); // Ambil request instance dengan benar
        $uri = service('uri');

        if ($uri->getPath() === 'oleholeh') {
            // Ambil provinsiSlug dan kabupatenSlug jika tersedia
            $provinsiSlug = $request->getGet('provinsiSlug') ?? '';
            $kabupatenSlug = $request->getGet('kabupatenSlug') ?? ''; // Jika tidak ada, kosong

            // Bangun URL tujuan dengan mempertahankan query string
            $newUrl = base_url("id/oleh-oleh?provinsiSlug={$provinsiSlug}&kabupatenSlug={$kabupatenSlug}");

            return redirect()->to($newUrl);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diubah
    }
}
