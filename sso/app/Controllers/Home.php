<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $apps = [];
        if (session()->has('user')) {
            $allowed = new \App\Libraries\AllowedUsers();
            $user = $allowed->findByEmail(session('user.email'));
            if ($user) {
                $config = new \Config\Applications();
                foreach ($user['apps'] as $id) {
                    if (isset($config->apps[$id])) {
                        $apps[$id] = $config->apps[$id];
                    }
                }
            }
        }
        return view('home', ['apps' => $apps]);
    }
}
