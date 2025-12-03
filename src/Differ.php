<?php

namespace Differ\Differ;

use function Functional\sort;
use function Differ\Parsers\parse;
use function Differ\Formatters\format;

function genDiff(string $pathToFile1, string $pathToFile2, string $formatName = 'stylish'): string
{
    [ 'content' => $content1, 'format' => $format1 ] = getFileData($pathToFile1);
    [ 'content' => $content2, 'format' => $format2 ] = getFileData($pathToFile2);

    $data1 = parse($content1, $format1);
    $data2 = parse($content2, $format2);

    $diff = buildDiff($data1, $data2);

    return format($diff, $formatName);
}

function getFileData(string $path): array
{
    $absolutePath = getAbsolutePath($path);

    $content = file_get_contents($absolutePath);

    if ($content === false) {
        throw new \Exception("Cannot read file: {$absolutePath}");
    }

    $format = getFormat($absolutePath);

    return [ 'content' => $content, 'format' => $format ];
}

function getAbsolutePath(string $path): string
{
    if (str_starts_with($path, '/')) {
        return $path;
    }
    return getcwd() . '/' . $path;
}

function isAssociativeArray(mixed $value): bool
{
    if (!is_array($value)) {
        return false;
    }
    if ($value === []) {
        return false;
    }
    return array_keys($value) !== range(0, count($value) - 1);
}

function buildDiff(array $data1, array $data2): array
{
    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $sortedKeys = sort($allKeys, fn($a, $b) => strcmp($a, $b));

    return array_map(function ($key) use ($data1, $data2) {
        $inFirst = array_key_exists($key, $data1);
        $inSecond = array_key_exists($key, $data2);

        if ($inFirst && !$inSecond) {
            return [
                'key' => $key,
                'type' => 'removed',
                'value' => $data1[$key]
            ];
        }

        if (!$inFirst && $inSecond) {
            return [
                'key' => $key,
                'type' => 'added',
                'value' => $data2[$key]
            ];
        }

        $value1 = $data1[$key];
        $value2 = $data2[$key];

        if (isAssociativeArray($value1) && isAssociativeArray($value2)) {
            return [
                'key' => $key,
                'type' => 'nested',
                'children' => buildDiff($value1, $value2)
            ];
        }

        if ($value1 === $value2) {
            return [
                'key' => $key,
                'type' => 'unchanged',
                'value' => $value1
            ];
        }

        return [
            'key' => $key,
            'type' => 'changed',
            'oldValue' => $value1,
            'newValue' => $value2
        ];
    }, $sortedKeys);
}

function getFormat(string $filePath): string
{
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    return $extension;
}
