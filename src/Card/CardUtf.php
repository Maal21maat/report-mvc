<?php

namespace App\Card;

class CardUtf extends Card
{
    public function display()
    {
        $suitsSymbols = array(
            'C' => "\u{2663}", // ♣
            'D' => "\u{2666}", // ♦
            'H' => "\u{2665}", // ♥
            'S' => "\u{2660}"  // ♠
        );

        $rank = $this->getRank();
        $suit = $this->getSuit();

        $symbol = isset($suitsSymbols[$suit]) ? $suitsSymbols[$suit] : $suit;
        return $rank . $symbol;
    }
}