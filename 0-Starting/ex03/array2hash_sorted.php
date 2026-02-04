<?php
function array2hash_sorted(array $array) : array{
    $result = [];

    foreach ($array as [$name, $age]){
        $result[$name] = $age;
    }
    krsort($result);
    return $result;
}