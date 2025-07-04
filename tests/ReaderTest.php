<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Chokri\PDF\Reader;

class ReaderTest extends TestCase
{
    public function testReadRawReturnsString(): void
    {
        $file = __DIR__ . '/test.pdf';
        file_put_contents($file, '%PDF-1.4\n%Test PDF file');
        $reader = new Reader();
        $data = $reader->readRaw($file);
        $this->assertIsString($data);
        $this->assertStringContainsString('%PDF', $data);
        unlink($file);
    }

    public function testReadRawThrowsOnMissingFile(): void
    {
        $reader = new Reader();
        $this->expectException(\RuntimeException::class);
        $reader->readRaw(__DIR__ . '/notfound.pdf');
    }
}
