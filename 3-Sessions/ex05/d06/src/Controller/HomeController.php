<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PostRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, SessionInterface $session): Response
    {
        $posts = $postRepository->findBy([], ['created' => 'DESC']);

        $animals = ['dog', 'cat', 'lion', 'tiger', 'fox', 'bear', 'wolf'];

        $now = time();
        $anonymousName = $session->get('anonymous_name');
        $last = $session->get('last_request_time', $now);

        if (!$anonymousName || ($now - $last) > 60) {
            $animal = $animals[array_rand($animals)];
            $anonymousName = 'Anonymous ' . $animal;
            $session->set('anonymous_name', $anonymousName);
        }

        $session->set('last_request_time', $now);
        $seconds_since_last = $now - $last;

        return $this->render('home/index.html.twig', [
            'anonymous_name' => $anonymousName,
            'seconds_since_last' => $seconds_since_last,
            'posts' => $posts,
        ]);
    }
}
