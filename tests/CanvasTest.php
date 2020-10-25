<?php

namespace Canvas\Tests;

use Canvas\Canvas;
use Canvas\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CanvasTest.
 *
 * @covers \Canvas\Canvas
 */
class CanvasTest extends TestCase
{
    use RefreshDatabase;

    public function testInstalledVersion(): void
    {
        $this->assertSame('', Canvas::installedVersion());
    }

    public function testAvailableLanguageCodes(): void
    {
        $this->assertIsArray(Canvas::availableLanguageCodes());
    }

    public function testAvailableTranslations(): void
    {
        $this->assertIsString(Canvas::availableTranslations(config('app.locale')));
    }

    public function testAvailableRoles(): void
    {
        $this->assertSame([
            User::CONTRIBUTOR => 'Contributor',
            User::EDITOR => 'Editor',
            User::ADMIN => 'Admin',
        ], Canvas::availableRoles());
    }

    public function testAssetsAreUpToDate(): void
    {
        $this->assertSame(true, Canvas::assetsUpToDate());
    }

    public function testBasePath(): void
    {
        $this->assertIsString(Canvas::basePath());
    }

    public function testBaseStoragePath(): void
    {
        $this->assertSame(config('canvas.storage_path').'/images', Canvas::baseStoragePath());
        $this->assertIsString(Canvas::baseStoragePath());
    }

    public function testURLIsValid(): void
    {
        $response = Canvas::isValid('https://www.example.com');

        $this->assertTrue($response);

        $response = Canvas::isValid('://www.example.c');

        $this->assertFalse($response);
    }

    public function testTrimURL(): void
    {
        $response = Canvas::trim('https://www.example.com?string-to-trim');

        $this->assertSame($response, 'www.example.com');
    }

    public function testGravatar(): void
    {
        $size = 80;
        $default = 'identicon';
        $rating = 'pg';
        $response = Canvas::gravatar('user@example.com', $size, $default, $rating);

        $this->assertIsString($response);
        $this->assertStringContainsString('secure.gravatar.com', $response);
        $this->assertStringContainsString(sprintf('s=%s', $size), $response);
        $this->assertStringContainsString(sprintf('d=%s', $default), $response);
        $this->assertStringContainsString(sprintf('r=%s', $rating), $response);
    }
}
