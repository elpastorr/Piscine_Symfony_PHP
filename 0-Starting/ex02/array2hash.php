<?php
function array2hash(array $array) : array{
    $result = [];

    foreach ($array as [$name, $age]){
        $result[$age] = $name;
    }
    return $result;
}