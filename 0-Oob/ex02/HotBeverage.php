<?php

class HotBeverage
{
    protected $nom;
    protected $price;
    protected $resistance;

    public function getName() {
        return $this->nom;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getResistence() {
        return $this->resistance;
    }
}