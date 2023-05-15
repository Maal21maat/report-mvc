<?php

namespace App\Card;

class CardUtf extends Card
{
    public function display()
    {
        $suitsSymbols = array(
            'Clubs' => "\u{2663}", // ♣
            'Diamonds' => "\u{2666}", // ♦
            'Hearts' => "\u{2665}", // ♥
            'Spades' => "\u{2660}"  // ♠
        );

        $rank = $this->getRank();
        $suit = $this->getSuit();

        $symbol = isset($suitsSymbols[$suit]) ? $suitsSymbols[$suit] : $suit;
        return $rank . $symbol;
    }
}