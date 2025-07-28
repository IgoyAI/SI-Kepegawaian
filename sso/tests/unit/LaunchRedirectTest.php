<?php
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

final class LaunchRedirectTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    public function testLaunchStoresRedirectWhenNotLoggedIn(): void
    {
        $this->withUri('http://example.com/launch/kepegawaian')
             ->controller(\App\Controllers\Auth::class);

        $result = $this->execute('launch', 'kepegawaian');
        $result->assertRedirectTo('/login');
        $this->assertSame('kepegawaian', session('after_login_app'));
    }
}
