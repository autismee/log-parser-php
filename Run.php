<?php

require_once("LogParser.php");

try {
    $fileName = $argv[1];
    if (!file_exists($fileName)) {
        throw new Exception("File \"$fileName\" not found");
    }

    if (!isset($argv[1])) {
        throw new Exception('Filename not specified');
    }

    $fileContents = file_get_contents($fileName);
    if ($fileContents === false) {
        throw new Exception("File reading error \"$fileName\"");
    }

    $LogParser = new LogParser($fileContents);
} catch (Exception $exception) {
    echo "Error {$exception->getMessage()}" . PHP_EOL;
}