<?php

namespace Differ\Formatters;

use Differ\Formatters\Stylish;
use Differ\Formatters\Plain;
use Differ\Formatters\Json;

function format(array $diffArrTree, string $formatName): string
{
    return match ($formatName) {
        'stylish' => Stylish\render($diffArrTree) . PHP_EOL,
        'plain' => Plain\render($diffArrTree) . PHP_EOL,
        'json' => Json\render($diffArrTree) . PHP_EOL,
        default => throw new \Exception("Unknown format: {$formatName}")
    };
}
