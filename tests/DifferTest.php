<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

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

    public function testGenDiffFlatJson(): void
    {
        $file1 = $this->getFixturePath('file1.json');
        $file2 = $this->getFixturePath('file2.json');
        $expected = $this->getFixtureContent('expected_flat.txt');

        $this->assertEquals($expected, genDiff($file1, $file2));
    }

    public function testGenDiffIdenticalFiles(): void
    {
        $file1 = $this->getFixturePath('file1.json');

        $expected = "{\n    follow: false\n    host: hexlet.io\n    proxy: 123.234.53.22\n    timeout: 50\n}";

        $this->assertEquals($expected, genDiff($file1, $file1));
    }

    public function testGenDiffEmptyFiles(): void
    {
        $tempDir = sys_get_temp_dir();
        $emptyFile1 = $tempDir . '/empty1.json';
        $emptyFile2 = $tempDir . '/empty2.json';

        file_put_contents($emptyFile1, '{}');
        file_put_contents($emptyFile2, '{}');

        $expected = "{\n}";

        $this->assertEquals($expected, genDiff($emptyFile1, $emptyFile2));

        unlink($emptyFile1);
        unlink($emptyFile2);
    }

    public function testGenDiffFlatYaml(): void
    {
        $file1 = $this->getFixturePath('file1.yml');
        $file2 = $this->getFixturePath('file2.yml');
        $expected = $this->getFixtureContent('expected_flat.txt');

        $this->assertEquals($expected, genDiff($file1, $file2));
    }
}
