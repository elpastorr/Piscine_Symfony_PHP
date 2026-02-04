<?php

$file = __DIR__ . '/ex01.txt';

if (!file_exists($file)) {
    echo "Error: File not found\n";
    exit(1);
}

$content = file_get_contents($file);
$values = explode(',', $content);

foreach ($values as $value) {
    $value = trim($value);
    if (!empty($value))
        echo $value, "\n";
}