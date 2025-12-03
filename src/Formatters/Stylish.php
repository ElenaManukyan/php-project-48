<?php

namespace Differ\Formatters\Stylish;

const INDENT_SIZE = 4;
const INDENT_SHIFT = 2;

function render(array $diff): string
{
    $formattedDiff = formatDiff($diff, 1);

    return "{\n{$formattedDiff}\n}\n";
}

function formatDiff(array $diff, int $depth): string
{
    $lines = array_map(function ($node) use ($depth) {
        return formatNode($node, $depth);
    }, $diff);

    return implode("\n", $lines);
}

function formatNode(array $node, int $depth): string
{
    $key = $node['key'];
    $type = $node['type'];

    $indent = makeIndent($depth);
    $bracketIndent = makeIndent($depth, false);

    $hasChildren = array_key_exists('children', $node) ? formatDiff($node['children'], $depth + 1) : '';
    $justValue = array_key_exists('value', $node) ? formatValue($node['value'], $depth) : '';
    $oldValue = array_key_exists('oldValue', $node) ? formatValue($node['oldValue'], $depth) : '';
    $newValue = array_key_exists('newValue', $node) ? formatValue($node['newValue'], $depth) : '';

    return match ($type) {
        'nested' => "{$indent}  {$key}: {\n{$hasChildren}\n{$bracketIndent}}",

        'unchanged' => "{$indent}  {$key}: {$justValue}",

        'added' => "{$indent}+ {$key}: {$justValue}",

        'removed' => "{$indent}- {$key}: {$justValue}",

        'changed' => "{$indent}- {$key}: {$oldValue}\n{$indent}+ {$key}: {$newValue}",

        default => throw new \Exception("Unknown node type: {$type}"),
    };
}

function makeIndent(int $depth, bool $withShift = true): string
{
    $size = $depth * INDENT_SIZE;
    if ($withShift) {
        $size -= INDENT_SHIFT;
    }
    return str_repeat(' ', $size);
}

function formatValue(mixed $value, int $depth): string
{
    if (is_null($value)) {
        return 'null';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_array($value)) {
        return formatArrayValue($value, $depth);
    }

    return (string) $value;
}

function formatArrayValue(array $value, int $depth): string
{
    $indent = makeIndent($depth + 1, false);
    $bracketIndent = makeIndent($depth, false);

    $keys = array_keys($value);
    $lines = array_map(function ($key) use ($value, $depth, $indent) {
        $val = formatValue($value[$key], $depth + 1);
        return "{$indent}{$key}: {$val}";
    }, $keys);

    $implodedLines = implode("\n", $lines);

    return "{\n{$implodedLines}\n{$bracketIndent}}";
}
