<?php

namespace App\Card;

class Hand
{
    protected $cards;

    public function __construct() {
        $this->cards = array();
    }

    public function addCard($card) {
        array_push($this->cards, $card);
    }

    public function removeCard($card) {
        $index = array_search($card, $this->cards);
        if ($index !== false) {
            array_splice($this->cards, $index, 1);
        }
    }

    public function getCards() {
        return $this->cards;
    }
}