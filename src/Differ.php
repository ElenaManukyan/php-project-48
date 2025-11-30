<?php

namespace Differ\Differ;

use function Functional\sort;
use function Differ\Parsers\parse;
use function Differ\Parsers\getFormat;

function genDiff(string $pathToFile1, string $pathToFile2): string
{
    $absolutePath1 = getAbsolutePath($pathToFile1);
    $absolutePath2 = getAbsolutePath($pathToFile2);

    $content1 = file_get_contents($absolutePath1);
    $content2 = file_get_contents($absolutePath2);

    $format1 = getFormat($absolutePath1);
    $format2 = getFormat($absolutePath2);

    $data1 = (array) parse($content1, $format1);
    $data2 = (array) parse($content2, $format2);

    $diff = buildDiff($data1, $data2);

    return formatDiff($diff);
}

function getAbsolutePath(string $path): string
{
    if (str_starts_with($path, '/')) {
        return $path;
    }
    return getcwd() . '/' . $path;
}

function buildDiff(array $data1, array $data2): array
{
    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));

    $sortedKeys = sort($allKeys, fn($a, $b) => strcmp($a, $b), false);

    $diff = array_map(function ($key) use ($data1, $data2) {
        $inFirst = array_key_exists($key, $data1);
        $inSecond = array_key_exists($key, $data2);

        if ($inFirst && !$inSecond) {
            return ['key' => $key, 'type' => 'removed', 'value' => $data1[$key]];
        }

        if (!$inFirst && $inSecond) {
            return ['key' => $key, 'type' => 'added', 'value' => $data2[$key]];
        }

        if ($data1[$key] === $data2[$key]) {
            return ['key' => $key, 'type' => 'unchanged', 'value' => $data1[$key]];
        }

        return [
            'key' => $key,
            'type' => 'changed',
            'oldValue' => $data1[$key],
            'newValue' => $data2[$key]
        ];
    }, $sortedKeys);

    return $diff;
}

function formatValue(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    return (string) $value;
}

function formatDiff(array $diff): string
{
    if (empty($diff)) {
        return "{\n}";
    }

    $lines = array_map(function ($item) {
        $key = $item['key'];

        return match ($item['type']) {
            'removed' => "  - {$key}: " . formatValue($item['value']),
            'added' => "  + {$key}: " . formatValue($item['value']),
            'unchanged' => "    {$key}: " . formatValue($item['value']),
            'changed' => "  - {$key}: " . formatValue($item['oldValue']) . "\n" .
                         "  + {$key}: " . formatValue($item['newValue']),
        };
    }, $diff);

    return "{\n" . implode("\n", $lines) . "\n}";
}
