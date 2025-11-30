<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format as stylishFormat;
use function Differ\Formatters\Plain\format as plainFormat;
use function Differ\Formatters\Json\format as jsonFormat;

function format(array $diff, string $formatName): string|false
{
    return match ($formatName) {
        'stylish' => stylishFormat($diff),
        'plain' => plainFormat($diff),
        'json' => jsonFormat($diff),
        default => throw new \Exception("Unknown format: {$formatName}")
    };
}
