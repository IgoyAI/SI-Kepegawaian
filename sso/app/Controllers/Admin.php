<?php
namespace App\Controllers;

use App\Libraries\AllowedUsers;
use Config\Applications;

class Admin extends BaseController
{
    public function index(): string
    {
        $allowed = new AllowedUsers();
        $data = [
            'users' => $allowed->getUsers(),
            'apps'  => (new Applications())->apps,
        ];
        return view('admin/index', $data);
    }

    public function add()
    {
        $allowed = new AllowedUsers();
        $email = $this->request->getPost('email');
        $apps = $this->request->getPost('apps') ?? [];
        $isAdmin = $this->request->getPost('is_admin') === '1';
        if ($email) {
            $allowed->addUser($email, $apps, $isAdmin);
        }
        return redirect()->to('/admin');
    }

    public function delete($email)
    {
        $allowed = new AllowedUsers();
        $allowed->removeUser($email);
        return redirect()->to('/admin');
    }
}
