<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteJson
{
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
}
