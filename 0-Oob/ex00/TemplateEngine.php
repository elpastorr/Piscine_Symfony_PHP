<?php
class TemplateEngine
{
    // public function createFile($filename, $templateName, $parameters)
    // {
    //     if (!is_readable($templateName)) {
    //         throw new Exception("Template not readable: $templateName");
    //     }

    //     $content = file_get_contents($templateName);

    //     $result = preg_replace_callback('/\{([^\}]+)\}/', function ($matches) use ($parameters) {
    //         $key = $matches[1];
    //         return array_key_exists($key, $parameters) ? $parameters[$key] : '';
    //     }, $content);

    //     $written = @file_put_contents($fileName, $result);
    //     if ($written === false) {
    //         throw new Exception("Unable to write file: $fileName");
    //     }

    //     return true;
    // }
}
