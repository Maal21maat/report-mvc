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
            // 'quote_link' => $this->generateUrl('quote'),
            // 'deck_link' => $this->generateUrl('quote'),
            // 'shuffle_link' => $this->generateUrl('quote'),
            // 'draw_link' => $this->generateUrl('quote')
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
    ): Response
    {
        $gameDeck = $session->get("game_deck");
        if (empty($gameDeck)) {
            $gameDeck = new Deck();
            $session->set("game_deck", $gameDeck);
        }


        // $gameDeck = new Deck();
        $gameDeck = $gameDeck->showDeck();
        $deckCards = [];
        foreach ($gameDeck as $card) {
            $deckCards[] = "{$card->getRank()} of {$card->getSuit()}";
        }

        $data = [
            'gameDeck' => $deckCards,
        ];

        // return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_shuffle")]
    public function shuffleApi(
        SessionInterface $session
    ): Response
    {
        $gameDeck = $session->get("game_deck");
        if (empty($gameDeck)) {
            $gameDeck = new Deck();
            $session->set("game_deck", $gameDeck);
        }


        // $gameDeck = new Deck();
        $gameDeck = $gameDeck->shuffleDeck();
        $deckCards = [];
        foreach ($gameDeck as $card) {
            $deckCards[] = "{$card->getRank()} of {$card->getSuit()}";
        }

        $data = [
            'gameDeck' => $deckCards,
        ];

        // return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

}
