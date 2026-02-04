<?php

function capital_city_from(string $state) : string {
    $states = [
    'Oregon' => 'OR',
    'Alabama' => 'AL',
    'New Jersey' => 'NJ',
    'Colorado' => 'CO',
    ];
    $capitals = [
    'OR' => 'Salem',
    'AL' => 'Montgomery',
    'NJ' => 'trenton',
    'KS' => 'Topeka',
    ];

    if (!array_key_exists($state, $states)) {
        return "Unknown\n";
    }
    $abbreviation = $states[$state];
    if (!array_key_exists($abbreviation, $capitals)) {
        return "Unknown\n";
    }
    return $capitals[$abbreviation]."\n";
}
