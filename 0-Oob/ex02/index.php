<?php

include "TemplateEngine.php";
include "Tea.php";
include "Coffee.php";

$tea = new Tea("Cup of tea", "21", "2", "boisson anglaise", "ca fait pisser");
$coffee = new Coffee("Coffee", "42", "5", "boisson italienne", "ca fait trembler");

$engine = new TemplateEngine();

$engine->createFile($tea);
$engine->createFile($coffee);
