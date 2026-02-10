<?php

include "TemplateEngine.php";

$html = new Elem("html");

$head = new Elem("head");
$meta = new Elem("meta", "null", ["charset" => "UTF-8"]);
$title = new Elem("title", "My Page");

// $meta2 = new Elem("meta", "null", ["charset" => "UTF-8"]);
// $head->pushElement($meta2);

// $title2 = new Elem("title", "My Page 2");
// $head->pushElement($title2);

$head->pushElement($meta);
$head->pushElement($title);

$body = new Elem("body");
$p = new Elem("p", "Just text.");
$table = new Elem("table");
$tr = new Elem("tr");
$td = new Elem("td", "cell");
$tr->pushElement($td);
$table->pushElement($tr);
$ul = new Elem("ul");
$ol = new Elem("ol");
$li = new Elem("li", "Item 1");
$ul->pushElement($li);
$ol->pushElement($li);

// $p->pushElement($tr);
// $table->pushElement($li);
// $tr->pushElement($li);
// $ul->pushElement($p);
// $ol->pushElement($p);


$body->pushElement($p);
$body->pushElement($table);
$body->pushElement($ul);
$body->pushElement($ol);

$html->pushElement($head);
$html->pushElement($body);

echo $html->validPage() ? "Valid Page\n" : "Invalid Page\n";

echo $html->getHTML();