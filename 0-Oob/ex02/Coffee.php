<?php

include_once "HotBeverage.php";

class Coffee extends HotBeverage
{
    private $description;
    private $comment;

    function __construct($nom, $price, $resistance, $description, $comment)
    {
        $this->nom = $nom;
        $this->price = $price;
        $this->resistance = $resistance;
        $this->description = $description;
        $this->comment = $comment;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getComment() {
        return $this->comment;
    }
}