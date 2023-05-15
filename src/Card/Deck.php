<?php

namespace App\Card;

class Deck
{
    public $cards;

    public function __construct()
    {
        $this->cards = array();
        // create 52 cards
        $ranks = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King', 'Ace');
        $suits = array('Clubs', 'Diamonds', 'Hearts', 'Spades');
        foreach ($ranks as $rank) {
            foreach ($suits as $suit) {
                $card = new CardUtf($rank, $suit);
                array_push($this->cards, $card);
            }
        }
    }

    public function shuffleDeck()
    {
        shuffle($this->cards);
        return $this->cards;
    }

    public function draw($numCards = 1)
    {
        $cards = array();
        for ($i = 0; $i < $numCards; $i++) {
            $card = array_shift($this->cards);
            array_push($cards, $card);
        }
        return $cards;
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function showDeck()
    {
        $cards = $this->getCards();
        usort($cards, function ($card1, $card2) {
            if ($card1->getSuit() == $card2->getSuit()) {
                $rank1 = $this->getRankValue($card1->getRank());
                $rank2 = $this->getRankValue($card2->getRank());
                return $rank1 - $rank2;
            }
            return strcmp($card1->getSuit(), $card2->getSuit());
        });
        return $cards;
    }

    protected function getRankValue($rank)
    {
        $rankValues = array(
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '10' => 10,
            'Jack' => 11,
            'Queen' => 12,
            'King' => 13,
            'Ace' => 14
        );
        return $rankValues[$rank];
    }
}
