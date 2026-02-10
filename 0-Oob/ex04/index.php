<?php

include "TemplateEngine.php";

$elem = new Elem('html');
$body = new Elem('body');

$body->pushElement(new Elem('p', 'Lorem ipsum', ['class' => 'text-muted']));

$elem->pushElement($body);

echo $elem->getHTML();
try {
    $elem = new Elem('undefined');
}
catch(MyException $e)
{
    echo($e);
    return 1;
}
finally
{
    echo "Exited after throwing exception\n";
}