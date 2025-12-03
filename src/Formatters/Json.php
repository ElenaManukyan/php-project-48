<?php

namespace Differ\Formatters\Json;

function render(array $diff): string
{
    $result = json_encode($diff, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    if ($result === false) {
        throw new \Exception("Failed to encode diff to JSON: " . json_last_error_msg());
    }

    return "{$result}\n";
}
