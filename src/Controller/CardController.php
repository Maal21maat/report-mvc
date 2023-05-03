<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\Deck;
use App\Card\Hand;
use App\Card\Game;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route("/card/deck", name: "card/deck")]
    public function deck(): Response
    {
        $deck = new Deck();
        $sortedDeck = $deck->showDeck();
        $data = ['sortedDeck' => $sortedDeck];
        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card/deck/shuffle")]
    public function shuffle(): Response
    {
        $deck = new Deck();
        $shuffleDeck = $deck->shuffleDeck();
        $data = ['shuffleDeck' => $shuffleDeck];
        return $this->render('card/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card/deck/draw")]
    public function draw(): Response
    {
        return $this->render('card/draw.html.twig');
    }

    #[Route("/card/deck/draw/number", name: "card/deck/draw/number")]
    public function drawnumber(): Response
    {
        return $this->render('card/draw_number.html.twig');
    }
}
