<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use Google\Client as GoogleClient;
use Google\Service\Oauth2 as GoogleServiceOauth2;
use App\Libraries\AllowedUsers;


class Auth extends Controller
{
    public function login()
    {
        $client = $this->getGoogleClient();
        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $client = $this->getGoogleClient();
        if ($this->request->getGet('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($this->request->getGet('code'));
            if (!isset($token['error'])) {
                $service = new GoogleServiceOauth2($client);
                $userinfo = $service->userinfo->get();
                $allowed = new AllowedUsers();
                $record = $allowed->findByEmail($userinfo->email);
                if (!$record) {
                    return view('access_denied');
                }
                session()->set('access_token', $token);
                session()->set('user', [
                    'email' => $userinfo->email,
                    'name'  => $userinfo->name,
                    'picture' => $userinfo->picture,
                ]);
                session()->set('user_apps', $record['apps']);
                session()->set('is_admin', !empty($record['is_admin']));

                $redirect = session('after_login_app');
                if ($redirect) {
                    session()->remove('after_login_app');
                    return redirect()->to('/launch/' . $redirect);
                }

                return redirect()->to('/');
            }
        }
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function token()
    {
        if (! session()->has('user')) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthenticated']);
        }

        $appId = $this->request->getGet('app');
        $allowed = new AllowedUsers();
        $record  = $allowed->findByEmail(session('user.email'));
        if (! $record || ($appId && ! in_array($appId, $record['apps'], true))) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Access denied']);
        }

        $payload = [
            'sub'  => session('user.email'),
            'name' => session('user.name'),
            'app'  => $appId,
            'iat'  => time(),
        ];
        $secret = env('jwt.secret') ?: getenv('JWT_SECRET');
        if (! is_string($secret) || $secret === '') {
            throw new \RuntimeException('JWT secret is not configured');
        }
        $token  = \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');

        return $this->response->setJSON(['token' => $token]);
    }

    public function launch($appId = null)
    {
        if (! $appId) {
            return redirect()->to('/');
        }

        if (! session()->has('user')) {
            session()->set('after_login_app', $appId);
            return redirect()->to('/login');
        }

        $allowed = new AllowedUsers();
        $record  = $allowed->findByEmail(session('user.email'));
        if (! $record || ! in_array($appId, $record['apps'], true)) {
            return redirect()->to('/');
        }

        $config = new \Config\Applications();
        if (! isset($config->apps[$appId])) {
            return redirect()->to('/');
        }

        $payload = [
            'sub'  => session('user.email'),
            'name' => session('user.name'),
            'app'  => $appId,
            'iat'  => time(),
        ];
        $secret = env('jwt.secret') ?: getenv('JWT_SECRET');
        if (! is_string($secret) || $secret === '') {
            throw new \RuntimeException('JWT secret is not configured');
        }
        $token  = \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');

        $target = rtrim($config->apps[$appId]['url'], '/');
        $redirectUrl = $target . '?token=' . urlencode($token);

        return redirect()->to($redirectUrl);
    }

    private function getGoogleClient(): GoogleClient
    {
        $client = new GoogleClient();
        $client->setClientId(env('google.oauthClientId'));
        $client->setClientSecret(env('google.oauthClientSecret'));
        $client->setRedirectUri(base_url('callback'));
        $client->addScope('email');
        $client->addScope('profile');
        if (session()->has('access_token')) {
            $client->setAccessToken(session('access_token'));
        }
        return $client;
    }
}
