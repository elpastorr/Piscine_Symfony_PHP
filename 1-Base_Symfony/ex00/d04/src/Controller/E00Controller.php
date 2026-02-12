<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class E00Controller
{
    #[Route("/e00/firstpage", name: "e00_firstpage")]
    public function firstPage(): Response
    {
        return new Response("Hello world!");
    }
}
