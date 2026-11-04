<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filter akses user.
 * Pemakaian di Routes: ['filter' => 'auth'] (cukup login) atau
 * ['filter' => 'auth:admin'] / 'auth:customer' (login + role tertentu).
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('logged_in')) {
            // Ingat tujuan agar setelah login kembali ke halaman ini
            $session->set('intended', uri_string());

            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (! empty($arguments) && ! in_array($session->get('role'), $arguments, true)) {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
