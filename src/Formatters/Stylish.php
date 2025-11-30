<?php

namespace Differ\Formatters\Stylish;

const INDENT_SIZE = 4;
const INDENT_SHIFT = 2;

function format(array $diff): string
{
    return "{\n" . formatDiff($diff, 1) . "\n}";
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

    return match ($type) {
        'nested' => "{$indent}  {$key}: {\n" . 
                    formatDiff($node['children'], $depth + 1) . 
                    "\n{$bracketIndent}}",
        
        'unchanged' => "{$indent}  {$key}: " . formatValue($node['value'], $depth),
        
        'added' => "{$indent}+ {$key}: " . formatValue($node['value'], $depth),
        
        'removed' => "{$indent}- {$key}: " . formatValue($node['value'], $depth),
        
        'changed' => "{$indent}- {$key}: " . formatValue($node['oldValue'], $depth) . "\n" .
                     "{$indent}+ {$key}: " . formatValue($node['newValue'], $depth),
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

    return "{\n" . implode("\n", $lines) . "\n{$bracketIndent}}";
}