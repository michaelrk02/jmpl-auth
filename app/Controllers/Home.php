<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        $userModel = model(UserModel::class);
        $user = $userModel->find(session()->get('auth'));

        echo view('header', ['title' => 'Home']);
        echo view('home', compact('user'));
        echo view('footer');
    }
}
