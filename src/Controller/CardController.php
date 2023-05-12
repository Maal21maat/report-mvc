<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardUtf;
use App\Card\Deck;
use App\Card\DeckUtf;
use App\Card\Hand;
use App\Card\Game;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

    #[Route("/card/reset", name: "card_reset")]
    public function cardReset(
        SessionInterface $session
    ): Response
    {
        $session->invalidate();
        return $this->render('card/card.html.twig');
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response
    {
        if (empty($session->get("game_deck"))) {
            $gameDeck = new Deck();
            $gameDeck->shuffleDeck();
            $drawHand = new Hand();
            $cardsCount = count($gameDeck->getCards());
            $session->set("game_deck", $gameDeck);
            $session->set("game_cards_in_deck", $cardsCount);
            $session->set("game_hand", $drawHand);
        }

        $gameDeck = $session->get("game_deck");
        $cardsCount = $session->get("game_cards_in_deck");
        $shuffledDeck = $gameDeck->shuffleDeck();
        $data = [
            'gameDeck' => $shuffledDeck,
            'numberCards' => $cardsCount,
            'deckStatus' => "blandad"
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(
        SessionInterface $session
    ): Response
    {
        if (empty($session->get("game_deck"))) {
            $gameDeck = new Deck();
            $gameDeck->shuffleDeck();
            $drawHand = new Hand();
            $cardsCount = count($gameDeck->getCards());
            $session->set("game_deck", $gameDeck);
            $session->set("game_cards_in_deck", $cardsCount);
            $session->set("game_hand", $drawHand);
        }

        $gameDeck = $session->get("game_deck");
        $cardsCount = $session->get("game_cards_in_deck");
        $sortedDeck = $gameDeck->showDeck();
        $data = [
            'gameDeck' => $sortedDeck,
            'numberCards' => $cardsCount,
            'deckStatus' => "sorterad"
        ];
        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw")]
    public function draw(
        SessionInterface $session
    ): Response
    {
        if (empty($session->get("game_deck"))) {
            $gameDeck = new Deck();
            $gameDeck->makeDeck();
            $drawHand = new Hand();
            $cardsCount = count($gameDeck->getCards());
            $session->set("game_deck", $gameDeck);
            $session->set("game_cards_in_deck", $cardsCount);
            $session->set("game_hand", $drawHand);
        }
        
        $gameDeck = $session->get("game_deck");
        $drawHand = new Hand();
        $cards = $gameDeck->draw(1);
        foreach ($cards as $card) {
            $drawHand->addCard($card);
        }
        $cardsCount = count($gameDeck->getCards());

        $session->set("game_number_of_cards", 1);
        $session->set("game_deck", $gameDeck);
        $session->set("game_cards_in_deck", $cardsCount);
        $session->set("game_hand", $drawHand);

        $data = [
            "gameDrawNumberCards" => $session->get("game_number_of_cards"),
            "gameCardsLeftDeck" => $session->get("game_cards_in_deck"),
            "drawHand" => $session->get("game_hand"),
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/:{num<\d+>}", name: "card_draw_more")]
    public function drawnumber(
        SessionInterface $session,
        int $num
    ): Response
    {
        if (empty($session->get("game_deck"))) {
            $gameDeck = new Deck();
            $gameDeck->shuffleDeck();
            $drawHand = new Hand();
            $cardsCount = count($gameDeck->getCards());
            $session->set("game_deck", $gameDeck);
            $session->set("game_cards_in_deck", $cardsCount);
            $session->set("game_hand", $drawHand);
        }
        
        $gameDeck = $session->get("game_deck");
        $drawHand = new Hand();
        $cards = $gameDeck->draw($num);
        foreach ($cards as $card) {
            $drawHand->addCard($card);
        }
        $cardsCount = count($gameDeck->getCards());

        $session->set("game_number_of_cards", $num);
        $session->set("game_deck", $gameDeck);
        $session->set("game_cards_in_deck", $cardsCount);
        $session->set("game_hand", $drawHand);

        $data = [
            "gameDrawNumberCards" => $session->get("game_number_of_cards"),
            "gameCardsLeftDeck" => $session->get("game_cards_in_deck"),
            "drawHand" => $session->get("game_hand"),
        ];

        return $this->render('card/draw.html.twig', $data);
    }
}
