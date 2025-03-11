<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UrlRedirectFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $url = $request->getUri()->getPath();
        

        // Cek apakah URL sudah benar, jika benar, abaikan
        if (
            strpos($url, 'en/destinations/nature-tourism') !== false ||
            strpos($url, 'id/wisata/wisata-alam') !== false
        ) {
            return; // Tidak perlu redirect
        }

        // Jika URL berisi -beach, arahkan ke URL yang benar dalam bahasa Inggris
        if (strpos($url, '-beach') !== false) {
            // Ambil hanya segmen terakhir dari URL yang berisi nama tempat
            $lastSegment = basename($url);
            // Redirect ke URL yang benar dalam bahasa Inggris
            return redirect()->to('/en/destinations/nature-tourism/' . $lastSegment)->setStatusCode(301);
        }

        // Jika URL berisi pantai-, arahkan ke URL yang benar dalam bahasa Indonesia
        if (strpos($url, 'pantai-') !== false) {
            // Ambil hanya segmen terakhir dari URL yang berisi nama tempat
            $lastSegment = basename($url);
            // Redirect ke URL yang benar dalam bahasa Indonesia
            return redirect()->to('/id/wisata/wisata-alam/' . $lastSegment)->setStatusCode(301);
        }

        // Redirect untuk URL yang mengandung angka
        if (preg_match('/\/[0-9]+\//', $url)) {
            $lastSegment = basename($url); // Ambil segmen terakhir (nama tempat)
            if (strpos($url, '-beach') !== false) {
                return redirect()->to('/en/destinations/nature-tourism/' . $lastSegment)->setStatusCode(301);
            } elseif (strpos($url, 'pantai-') !== false) {
                return redirect()->to('/id/wisata/wisata-alam/' . $lastSegment)->setStatusCode(301);
            }
        }
        
        

        




        // // Cek apakah URL sudah benar, jika benar, abaikan
        // if (
        //     strpos($url, 'id/wisata') !== false || // Jika sudah berada di URL yang benar dalam bahasa Indonesia
        //     strpos($url, 'en/destinations') !== false // Atau jika sudah berada di URL dalam bahasa Inggris
        // ) {
        //     return; // Tidak perlu redirect
        // }

        // // Jika URL berisi /wisata atau /Wisata, arahkan ke URL yang benar dalam bahasa Indonesia
        // if (strpos(strtolower($url), 'wisata') !== false) {
        //     // Redirect ke URL yang benar dalam bahasa Indonesia
        //     return redirect()->to('/id/wisata')->setStatusCode(301);
        // }

        // // Jika URL berisi /wisata atau /Wisata, arahkan ke URL yang benar dalam bahasa Indonesia
        // if (strpos(strtolower($url), 'destinations') !== false) {
        //     // Redirect ke URL yang benar dalam bahasa Indonesia
        //     return redirect()->to('/en/destinations')->setStatusCode(301);
        // }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada tindakan setelah request
    }
}
