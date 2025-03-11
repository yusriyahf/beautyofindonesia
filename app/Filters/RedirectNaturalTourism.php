<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RedirectNaturalTourism implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = service('uri');

        if (strpos($uri->getPath(), 'natural-tourism') !== false) {
            $newPath = str_replace('natural-tourism', 'nature-tourism', $uri->getPath());
            return redirect()->to(base_url($newPath));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu perubahan di sini.
    }
}
