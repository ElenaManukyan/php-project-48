<?php

namespace Differ\Formatters;

function format(array $diffArrTree, string $formatName): string
{
    return match ($formatName) {
        'stylish' =>  Stylish\render($diffArrTree),
        'plain' =>  Plain\render($diffArrTree),
        'json' =>  Json\render($diffArrTree),
        default => throw new \Exception("Unknown format: {$formatName}")
    };
}
