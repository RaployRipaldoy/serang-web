<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminManagementFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
       
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('Home/loginForm'))->with('error', 'You must be logged in to access this page.');
        }

       
        $userRole = session()->get('role'); 
        
        
        if (!in_array($userRole, ['admin', 'management'])) {
            return redirect()->to(base_url('/'))->with('error', 'Access denied. Only admin and management can access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after
    }
}
