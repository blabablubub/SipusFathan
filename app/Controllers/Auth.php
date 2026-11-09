<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function login()
    {
        if(session()->get('Logged_In')) {
            return redirect()->to('dashboard');
        }
        return view('auth/login', [
            'error' => session()->getFlashdata('error') ?? []
        ]);
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            session()->setFlashdata('error', 'Email atau password salah.');
            return redirect()->back()->withInput();
        }

        session()->set([
            'LoggedIn' => true,
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
            'user_role' => $user['role'],
        ]);

        return redirect()->to('dashboard');
        
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}