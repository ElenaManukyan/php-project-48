<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private function getFixturePath(string $filename): string
    {
        return __DIR__ . '/fixtures/' . $filename;
    }

    private function getFilePaths(string $extension): array
    {
        return [
            $this->getFixturePath("file1_nested.{$extension}"),
            $this->getFixturePath("file2_nested.{$extension}"),
        ];
    }

    public static function extensionProvider(): array
    {
        return [
            'json files' => ['json'],
            'yaml files' => ['yml'],
        ];
    }

    #[DataProvider('extensionProvider')]
    public function testStylishFormat(string $extension): void
    {
        [$file1, $file2] = $this->getFilePaths($extension);

        $this->assertStringEqualsFile(
            $this->getFixturePath('expected_nested.txt'),
            str_replace("\r\n", "\n", genDiff($file1, $file2))
        );
    }

    #[DataProvider('extensionProvider')]
    public function testDefaultFormat(string $extension): void
    {
        [$file1, $file2] = $this->getFilePaths($extension);

        $this->assertStringEqualsFile(
            $this->getFixturePath('expected_nested.txt'),
            str_replace("\r\n", "\n", genDiff($file1, $file2))
        );
    }

    #[DataProvider('extensionProvider')]
    public function testPlainFormat(string $extension): void
    {
        [$file1, $file2] = $this->getFilePaths($extension);

        $this->assertStringEqualsFile(
            $this->getFixturePath('expected_plain.txt'),
            str_replace("\r\n", "\n", genDiff($file1, $file2, 'plain'))
        );
    }

    #[DataProvider('extensionProvider')]
    public function testJsonFormat(string $extension): void
    {
        [$file1, $file2] = $this->getFilePaths($extension);

        $this->assertStringEqualsFile(
            $this->getFixturePath('expected_json.json'),
            str_replace("\r\n", "\n", genDiff($file1, $file2, 'json'))
        );
    }
}
