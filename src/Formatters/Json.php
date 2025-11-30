<?php

namespace Differ\Formatters\Json;

function format(array $diff): string|false
{
    return json_encode($diff, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
