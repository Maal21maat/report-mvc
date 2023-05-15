<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardUtf;
use App\Card\Deck;
use App\Card\Hand;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        $data = [
            // Behövs inte nu
        ];
        return $this->render('api/api.html.twig', $data);
    }

    #[Route("/api/quote", name: "quote")]
    public function jsonNumber(): Response
    {
        $quotes = [
            'The greatest glory in living lies not in never falling, but in rising every time we fall. -Nelson Mandela',
            'The way to get started is to quit talking and begin doing. -Walt Disney',
            'Life is what happens when you are busy making other plans. -John Lennon',
            'The future belongs to those who believe in the beauty of their dreams. -Eleanor Roosevelt'
        ];

        $randomNumber = array_rand($quotes);
        $quote = $quotes[$randomNumber];

        date_default_timezone_set("Europe/Stockholm");

        $data = [
            'Todays quote' => $quote,
            'Todays date' => date("Y-m-d"),
            'Timestamp' => date("H:i:s")
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
        // return $this->render('quote.html.twig', $response);
    }

    #[Route("/api/deck", name: "api_deck")]
    public function deckApi(
        SessionInterface $session
    ): Response {
        $gameDeck = $session->get("game_deck");
        if (empty($gameDeck)) {
            $gameDeck = new Deck();
            $session->set("game_deck", $gameDeck);
        }

        $gameDeck = $gameDeck->showDeck();
        $deckCards = [];
        foreach ($gameDeck as $card) {
            $deckCards[] = "{$card->getRank()} of {$card->getSuit()}";
        }

        $data = [
            'title' => 'Deck, sortered',
            'gameDeck' => $deckCards,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_shuffle")]
    public function shuffleApi(
        SessionInterface $session
    ): Response {
        $gameDeck = new Deck();
        $session->set("game_deck", $gameDeck);
        $gameDeck = $gameDeck->shuffleDeck();
        $deckCards = [];
        foreach ($gameDeck as $card) {
            $deckCards[] = "{$card->getRank()} of {$card->getSuit()}";
        }

        $data = [
            'title' => 'Deck, shuffled, and new session',
            'gameDeck' => $deckCards,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/draw", name: "api_draw")]
    public function drawApi(
        SessionInterface $session
    ): Response {
        $gameDeck = $session->get("game_deck");
        if (empty($gameDeck)) {
            $gameDeck = new Deck();
            $gameDeck = $gameDeck->shuffleDeck();
            $session->set("game_deck", $gameDeck);
        }

        $drawHand = new Hand();
        $cards = $gameDeck->draw(1);
        foreach ($cards as $card) {
            $drawHand->addCard($card);
        }
        $cardsCount = count($gameDeck->getCards());
        $session->set("game_deck", $gameDeck);

        $drawHandCards = [];
        foreach ($drawHand->getCards() as $card) {
            $drawHandCards[] = "{$card->getRank()} of {$card->getSuit()}";
        }

        $data = [
            'title' => 'Draw 1 card',
            'cardsInDeck' => $cardsCount,
            'drawHand' => $drawHandCards,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/draw/:{num<\d+>}", name: "api_draw_more")]
    public function drawnumberApi(
        SessionInterface $session,
        int $num
    ): Response {
        $gameDeck = $session->get("game_deck");
        if (empty($gameDeck)) {
            $gameDeck = new Deck();
            $gameDeck = $gameDeck->shuffleDeck();
            $session->set("game_deck", $gameDeck);
        }

        $drawHand = new Hand();
        $cards = $gameDeck->draw($num);
        foreach ($cards as $card) {
            $drawHand->addCard($card);
        }
        $cardsCount = count($gameDeck->getCards());
        $session->set("game_deck", $gameDeck);

        $drawHandCards = [];
        foreach ($drawHand->getCards() as $card) {
            $drawHandCards[] = "{$card->getRank()} of {$card->getSuit()}";
        }

        $data = [
            'title' => 'Draw many card',
            'DrawNumberOfCards' => $num,
            'cardsInDeck' => $cardsCount,
            'drawHand' => $drawHandCards,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

}
