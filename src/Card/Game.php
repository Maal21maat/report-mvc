<?php

namespace App\Card;

class Game
{
    private $deck;
    private $hand;

    public function __construct() {
        $this->deck = new Deck();
        $this->deck->shuffle();
        $this->hand = new Hand();
    }

    public function drawCard($numCards = 1) {
        $cards = $this->deck->draw($numCards);
        foreach ($cards as $card) {
            $this->hand->add($card);
        }
    }

    public function getHand() {
        return $this->hand;
    }
}