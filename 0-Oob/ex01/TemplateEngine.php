<?php

include "Text.php";

class TemplateEngine
{
    public function createFile($fileName, Text $text)
    {
        $text->append(array("Je fais la sourde oreille", "a tout ce que le", "peuple il me raconte"));

        $text->readData($fileName);
    }
}