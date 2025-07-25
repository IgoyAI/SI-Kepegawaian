<?php
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use Firebase\JWT\JWT;

final class SsoLoginTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $db = db_connect();
        $db->query("CREATE TABLE IF NOT EXISTS db_users (id INTEGER PRIMARY KEY AUTOINCREMENT, google_id TEXT, email TEXT UNIQUE, name TEXT, role TEXT, created_at TEXT)");
    }

    public function testValidTokenCreatesSession(): void
    {
        putenv('JWT_SECRET=secret');
        $payload = [
            'sub'  => 'jane@example.com',
            'name' => 'Jane Doe',
            'iat'  => time(),
        ];
        $token = JWT::encode($payload, 'secret', 'HS256');

        $this->withUri('http://example.com/sso-login')
             ->controller(\App\Controllers\Auth::class);
        $this->request->setGlobal('get', ['token' => $token]);

        $result = $this->execute('ssoLogin');
        $result->assertRedirectTo('/dashboard');
        $user = session('user');
        $this->assertSame('jane@example.com', $user['email']);
        $this->assertSame('Jane Doe', $user['name']);
    }

    public function testIndexPhpPathCreatesSession(): void
    {
        putenv('JWT_SECRET=secret');
        $payload = [
            'sub'  => 'john@example.com',
            'name' => 'John Doe',
            'iat'  => time(),
        ];
        $token = JWT::encode($payload, 'secret', 'HS256');

        $this->withUri('http://example.com/index.php/sso-login')
             ->controller(\App\Controllers\Auth::class);
        $this->request->setGlobal('get', ['token' => $token]);

        $result = $this->execute('ssoLogin');
        $result->assertRedirectTo('/dashboard');
        $user = session('user');
        $this->assertSame('john@example.com', $user['email']);
        $this->assertSame('John Doe', $user['name']);
    }
}
