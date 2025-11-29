<?php

namespace Hexlet\Code;

class Parser
{
    public static function parse(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File '$filePath' does not exist.");
        }

        $fileContent = file_get_contents($filePath);

        if ($fileContent === false) {
            throw new \Exception("Cannot read file '$filePath'.");
        }

        $data = json_decode($fileContent);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $errorMessage = json_last_error_msg();
            throw new \Exception("Invalid JSON in file '$filePath': $errorMessage");
        }

        return $data;
    }
}
