<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format as stylishFormat;
use function Differ\Formatters\Plain\format as plainFormat;

function format(array $diff, string $formatName): string
{
    return match ($formatName) {
        'stylish' => stylishFormat($diff),
        'plain' => plainFormat($diff),
        default => throw new \Exception("Unknown format: {$formatName}")
    };
}
