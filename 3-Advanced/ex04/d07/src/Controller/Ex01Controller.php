<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Ex01Controller extends AbstractController
{
    #[Route('/ex01', name: 'ex01')]
    public function index(): Response
    {
        $number = $this->getParameter('d07.number');

        return new Response('Number: ' . $number);
    }
}
