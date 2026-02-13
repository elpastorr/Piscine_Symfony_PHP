<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class E03Controller extends AbstractController
{
    #[Route("/e03", name: "e03")]
    public function index(): Response
    {
        $shadesNB = $this->getParameter('e03.number_of_colors');

        $baseColors = [
            'black' => [0, 0, 0],
            'red'   => [255, 0, 0],
            'green' => [0, 255, 0],
            'blue'  => [0, 0, 255],
        ];

        $shades = [];

        foreach ($baseColors as $name => $rgb) {
            for ($i = 0; $i < $shadesNB; $i++) {
                $factor = $i / max($shadesNB - 1, 1);

                $r = (int) ($rgb[0] * $factor);
                $g = (int) ($rgb[1] * $factor);
                $b = (int) ($rgb[2] * $factor);

                $shades[$name][] = sprintf('rgb(%d,%d,%d)', $r, $g, $b);
            }
        }

        return $this->render('e03/index.html.twig', [
            'shades' => $shades,
            'shadesNB' => $shadesNB,
        ]);
    }
}
