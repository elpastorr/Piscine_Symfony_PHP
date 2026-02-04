<?php

$file = file_get_contents('ex06.txt');
if ($file == false) {
    exit("Error reading ex06.txt");
}
$lines = explode("\n", $file);

$html = "<!DOCTYPE html>\n<html>\n<head>\n\t<meta charset=\"UTF-8\">\n\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n\t<link rel=\"stylesheet\" href=\"style.css\">";
$html .= "\n\t<title>Mendeleev Table</title>\n\t<style>\n\t\ttable { border-collapse: collapse; }\n\t\ttd { border: 1px solid black; width: 100px; height: 60px; vertical-align: top; padding: 5px; }\n\t</style>\n</head>\n<body>";
$html .= "\n\t<h1 style=\"text-align: center; \">Mendeleev Periodic Table</h1>\n";

$grid = array_fill(0,7, array_fill(0, 18, null));

foreach ($lines as $key => $line) {
    foreach (explode('=', $line) as $key => $infos) {
        if ($key == 0) {
            $infos = trim($infos);
            $name = $infos;
        }
        else {
            $elements = explode(',', $infos);

            $position = substr($elements[0], 10);
            $number = substr($elements[1], 8);
            $symbol = substr($elements[2], 8);
            $molar = substr($elements[3], 7);
            $electron = substr($elements[4], 10);
            $period = substr_count($electron, ' ');

            $grid[$period][$position] = [
                'name' => $name,
                'symbol' => $symbol,
                'number' => $number,
                'molar' => $molar,
            ];
        }
    }
}

$html .= "\t<table>\n";

$i = 0;
while ($i < count($grid)) {
    $j = 0;
    $html .= "\t\t<tr>\n";

    while ($j < count($grid[$i])) {
        if ($grid[$i][$j] === null) {
            $html .= "\t\t\t<td></td>\n";
        }
        else {
            $cell = "<div class='symbol'>{$grid[$i][$j]['symbol']}</div>";
            $cell .= "<div class='element'>{$grid[$i][$j]['name']}</div>";
            $cell .= "<div>No. {$grid[$i][$j]['number']}</div>";
            $cell .= "<div>{$grid[$i][$j]['molar']} g/mol</div>";
            $html .= "\t\t\t<td> {$cell} </td>\n";
        }
        $j++;
    }
    $html .= "\t\t</tr>\n";
    $i++;
}

$html .= "\t</table>\n";
$html .= "</body>\n</html>\n";

if (!($htmlFile = fopen("mendeleiev.html", "w")))
    exit("Error creating mendeleiev.html");
fwrite($htmlFile, $html);
fclose($htmlFile);
echo "HTML file 'mendeleiev.html' created successfully.\n";