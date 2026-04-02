<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em, PostRepository $repo): Response
    {
        if ($request->isMethod('POST')) {
            $post = new Post();
            $post->setTitle($request->request->get('title'));
            $post->setContent($request->request->get('content'));
    
            $em->persist($post);
            $em->flush();
    
            return new JsonResponse(['message' => 'Post created']);
        }
    
        $posts = $repo->findAll();
    
        return $this->render('index.html.twig', [
            'posts' => $posts
        ]);
    }
}