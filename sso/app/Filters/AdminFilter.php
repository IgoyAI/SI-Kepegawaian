<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\AllowedUsers;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('user')) {
            return redirect()->to('/login');
        }
        $allowed = new AllowedUsers();
        $record = $allowed->findByEmail(session('user.email'));
        if (!$record || empty($record['is_admin'])) {
            return service('response')->setStatusCode(403, 'Forbidden');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action
    }
}
