<?php

namespace App\Card;

class Card
{
    protected $rank;
    protected $suit;
  
    public function __construct($rank, $suit) {
      $this->rank = $rank;
      $this->suit = $suit;
    }
  
    public function getRank() {
      return $this->rank;
    }
  
    public function getSuit() {
      return $this->suit;
    }
}