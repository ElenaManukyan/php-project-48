<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $content, string $format): array
{
    return match ($format) {
        'json' => json_decode($content, true),
        'yml', 'yaml' => Yaml::parse($content),
        default => throw new \Exception("Unknown format: {$format}")
    };
}

function getFormat(string $filePath): string
{
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    return $extension;
}

