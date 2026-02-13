<?php

namespace App\Controller;

use App\Form\E02Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class E02Controller extends AbstractController
{
    #[Route("/e02", name: "e02")]
    public function index(Request $request): Response
    {
        $form = $this->createForm(E02Type::class);
        $form->handleRequest($request);

        $lastLine = null;
        $filePath = $this->getParameter('notes_file');

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = $data['message'];
            $includeTimestamp = $data['includeTimestamp'];

            if ($includeTimestamp === 'yes') {
                $line = $message . ' - ' . date('Y-m-d H:i:s');
            }
            else {
                $line = $message;
            }

            $line .= PHP_EOL;

            file_put_contents($filePath, $line, FILE_APPEND);

            $lastLine = trim($line);
        }

        return $this->render('e02/index.html.twig', [
            'form' => $form->createView(),
            'lastLine' => $lastLine,
        ]);
    }
}
