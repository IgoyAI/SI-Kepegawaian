<?php
namespace App\Controllers;

use App\Models\UserModel;
use League\OAuth2\Client\Provider\Google;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends BaseController
{
    private Google $provider;
    private UserModel $users;

    public function __construct()
    {
        $this->provider = new Google([
            'clientId'     => getenv('GOOGLE_CLIENT_ID'),
            'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => base_url('auth/callback'),
        ]);
        $this->users = new UserModel();
    }

    public function index()
    {
        $authUrl = $this->provider->getAuthorizationUrl(['scope' => ['openid','email','profile']]);
        session()->set('oauth2state', $this->provider->getState());
        return view('auth/login', ['authUrl' => $authUrl]);
    }

    public function callback()
    {
        $state = $this->request->getGet('state');
        if (empty($state) || $state !== session()->get('oauth2state')) {
            session()->remove('oauth2state');
            return redirect()->to('/');
        }
        try {
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $this->request->getGet('code'),
            ]);
            $googleUser = $this->provider->getResourceOwner($token);
        } catch (\Throwable $e) {
            log_message('error', 'OAuth callback failed: ' . $e->getMessage());
            session()->setFlashdata('error', 'Failed to authenticate with Google.');
            return redirect()->to('/');
        }
        $data = [
            'google_id' => $googleUser->getId(),
            'email' => $googleUser->getEmail(),
            'name' => $googleUser->getName(),
        ];
        // determine HR emails from environment variable
        $hrEmails = array_map('trim', explode(',', getenv('HR_EMAILS') ?: ''));
        $isHr = in_array($data['email'], $hrEmails, true);

        $user = $this->users->where('google_id', $data['google_id'])->first();
        if (!$user) {
            $user = $this->users->where('email', $data['email'])->first();
        }

        if (!$user) {
            $data['role'] = $isHr ? 'hr' : 'employee';
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->users->insert($data);
            $user = $this->users->where('google_id', $data['google_id'])->first();
        } else {
            if (empty($user['google_id'])) {
                $this->users->update($user['id'], ['google_id' => $data['google_id']]);
                $user['google_id'] = $data['google_id'];
            }
            if ($isHr && $user['role'] !== 'hr') {
                // upgrade existing user to HR if listed
                $this->users->update($user['id'], ['role' => 'hr']);
                $user['role'] = 'hr';
            }
        }
        session()->set('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);
        return redirect()->to('/dashboard');
    }

    public function ssoLogin()
    {
        $token = $this->request->getGet('token');
        if (!$token) {
            return redirect()->to('/');
        }

        try {
            $data = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
        } catch (\Throwable $e) {
            log_message('error', 'SSO token decode failed: ' . $e->getMessage());
            return redirect()->to('/');
        }

        $email = $data->sub ?? null;
        $name  = $data->name ?? '';
        if (!$email) {
            return redirect()->to('/');
        }

        $user = $this->users->where('email', $email)->first();
        if (!$user) {
            $this->users->insert([
                'email'      => $email,
                'name'       => $name,
                'role'       => 'employee',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $user = $this->users->where('email', $email)->first();
        }

        session()->set('user', [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
