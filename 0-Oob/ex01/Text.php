<?php

class Text
{
    public $arg;

    function __construct($strings)
    {
        $this->arg = $strings;
    }

    public function append(array $str)
    {
        foreach ($str as $string)
        {
            $this->arg[] = $string;
        }
    }

    public function readData(string $filename)
    {
        $file = fopen("$filename", "w");
        fwrite($file, "<!DOCTYPE html>\n<html>\n\t<head>\n\t\t<title>Site random</title>\n\t</head>\n\t<body>\n");

        $i = 0;
        while ($i < count($this->arg))
        {
            $tmp = $this->arg[$i];
            fwrite($file, "\t\t<p> $tmp <p>\n");
            $i++;
        }
        fwrite($file, "\t</body>\n</html>\n");
        fclose($file);
    }
}