<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class E01Controller extends AbstractController
{
    private array $articles = [
        'gull' => 'Gulls are seabirds commonly found on coastlines...',
        'bee' => 'According to all known laws of aviation, there is no way a bee should be able to fly.',
         'lion' => 'Lions are big cats known as the king of the jungle...'
    ];

    #[Route("/e01", name: "e01_main")]
    public function main(): Response
    {
        return $this->render('e01/main.html.twig', [
            'articles' => $this->articles
        ]);
    }

    #[Route("/e01/{article}", name: "e01_article")]
    public function article(string $article): Response
    {
        if (isset($this->articles[$article])) {
            return $this->render('e01/article.html.twig', [
                'title' => ucfirst($article),
                'content' => $this->articles[$article]
            ]);
        }

        return $this->render('e01/main.html.twig', [
            'articles' => $this->articles
        ]);
    }
}
