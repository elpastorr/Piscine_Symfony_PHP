<?php

include "HotBeverage.php";

class TemplateEngine
{
    public function createFile(HotBeverage $text)
    {
        $name = $text->getName();

        $reflector = new ReflectionClass($text);

        $properties = $reflector->getProperties();

        $content = file_get_contents("template.html");

        if (!$content)
            exit("Template name not found\n");

        foreach ($properties as $prop)
        {
            $props = explode("$", "$prop")[1];
            $array = explode("=", "$props");
            $key = trim($array[0]);
            $value = $prop->getValue($text);
            echo "\nkey: ", $key, "\nvalue: ", $value;
            $content = str_replace('{' . $key . '}', "$value", $content);
        }

        file_put_contents("$name.html", $content);
    }
}