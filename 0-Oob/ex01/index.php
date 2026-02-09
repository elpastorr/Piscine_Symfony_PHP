<?php

include "TemplateEngine.php";

$array = array("Qu'il est difficile", "d'etre le roi", "de la france");

$text = new Text($array);

$engine = new TemplateEngine();

$engine->createFile("test.html", $text);
