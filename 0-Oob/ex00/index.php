<?php

include "TemplateEngine.php";

$parameters = array(array("Site random", "nom"), array("Werber", "auteur"), array("Fourmis", "description"), array("21", "prix"));

$engine = new TemplateEngine();

$engine->createFile("test.html", "book_description.html", $parameters);
