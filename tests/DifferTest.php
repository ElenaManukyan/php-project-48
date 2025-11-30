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

    private function getFixtureContent(string $filename): string
    {
        $content = file_get_contents($this->getFixturePath($filename));
        return trim(str_replace("\r\n", "\n", $content));
    }

    #[DataProvider('diffProvider')]
    public function testGenDiff(string $file1, string $file2, string $format, string $expected): void
    {
        $filePath1 = $this->getFixturePath($file1);
        $filePath2 = $this->getFixturePath($file2);
        $expectedContent = $this->getFixtureContent($expected);

        $this->assertEquals($expectedContent, genDiff($filePath1, $filePath2, $format));
    }

    public static function diffProvider(): array
    {
        return [
            'stylish json' => ['file1_nested.json', 'file2_nested.json', 'stylish', 'expected_nested.txt'],
            'stylish yaml' => ['file1_nested.yml', 'file2_nested.yml', 'stylish', 'expected_nested.txt'],
            'plain json' => ['file1_nested.json', 'file2_nested.json', 'plain', 'expected_plain.txt'],
            'plain yaml' => ['file1_nested.yml', 'file2_nested.yml', 'plain', 'expected_plain.txt'],
        ];
    }
}
