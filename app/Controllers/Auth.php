<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $userModel = new User();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();
        
        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'role' => $user['role'],
                'isLoggedIn' => true,
            ];
            $session->set($sessionData);

            log_activity('Login berhasil sebagai ' . $user['email']);

            return redirect()->to('/');
        } else {
            log_activity('Percobaan login gagal dengan email: ' . $email);

            session()->setFlashdata('pesan', 'Email atau Password Salah');
            return redirect()->to('/Home/loginForm');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
    {
        $userModel = new User();
        
        $data = [
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];
        
        $userModel->insert($data);

        log_activity('Registrasi user baru dengan email: ' . $data['email']);

        return redirect()->to('/Home/loginForm')->with('success', 'Registration successful. Please login.');
    }

    public function logout()
    {
        if (session()->has('email')) {
            log_activity('Logout oleh ' . session()->get('email'));
        }

        session()->destroy();
        return redirect()->to('/');
    }
}
