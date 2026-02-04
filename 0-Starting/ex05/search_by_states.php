<?php
function search_by_states(string $str){
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

    $str_return=[];
    $index = 0;
    $inputs = explode(',', $str);
    foreach ($inputs as $input) {
        $input = trim($input);
        foreach ($states as $state_name => $key) {
            if ($state_name == $input) {
                if (array_key_exists($key, $capitals))
                    $str_return[$index++] = $capitals[$key]. " is the capital of ". $state_name. ".\n";
                else
                    $str_return[$index++] = $state_name. " is neither a capital nor a state.\n";
                break;
            }
            if (in_array($input, $capitals)) {
                $state_found = array_search($input, $capitals);
                if ($state_fullname = array_search($state_found, $states))
                    $str_return[$index++] = $input. " is the capital of ". $state_fullname. ".\n";
                else
                    $str_return[$index++] = $input. " is neither a capital nor a state.\n";
                break;
            }
            $str_return[$index++] = $input. " is neither a capital nor a state.\n";
            break;
        }
    }
    foreach ($str_return as $value) {
        echo $value;
    }
}