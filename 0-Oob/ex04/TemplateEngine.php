<?php

include "Elem.php";

class TemplateEngine
{
    public function createFile(Elem $fileName)
    {
        $fileName->pushElement();
    }
}