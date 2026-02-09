<?php
class TemplateEngine
{
    public function createFile($fileName, $templateName, $parameters)
    {
        $file = fopen("$fileName", "w");

        $content = file_get_contents("$templateName");

        if (!$content)
            exit("Template name not found\n");

        $i = 0;
        while ($i < count($parameters))
        {
            $ptr = $parameters[$i];
            $value = current($ptr);
            $content = str_replace('{' . $ptr[1] . '}', "$value", $content);
            $i++;
        }
        file_put_contents($fileName, $content);
    }
}