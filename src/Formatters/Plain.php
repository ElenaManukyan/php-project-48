<?php

namespace Differ\Formatters\Plain;

function format(array $diff): string
{
    $lines = formatDiff($diff, []);
    return implode("\n", $lines);
}

function formatDiff(array $diff, array $path): array
{
    $lines = array_map(function ($node) use ($path) {
        return formatNode($node, $path);
    }, $diff);

    return array_merge(...array_map(fn($item) => is_array($item) ? $item : [$item], 
        array_filter($lines, fn($line) => $line !== null && $line !== '')));
}

function formatNode(array $node, array $path): mixed
{
    $key = $node['key'];
    $type = $node['type'];
    $currentPath = array_merge($path, [$key]);
    $propertyPath = implode('.', $currentPath);

    return match ($type) {
        'nested' => formatDiff($node['children'], $currentPath),
        'unchanged' => null,
        'added' => "Property '{$propertyPath}' was added with value: " . formatValue($node['value']),
        'removed' => "Property '{$propertyPath}' was removed",
        'changed' => "Property '{$propertyPath}' was updated. From " . 
                     formatValue($node['oldValue']) . " to " . formatValue($node['newValue']),
    };
}

function formatValue(mixed $value): string
{
    if (is_null($value)) {
        return 'null';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_array($value)) {
        return '[complex value]';
    }

    if (is_string($value)) {
        return "'{$value}'";
    }

    return (string) $value;
}
