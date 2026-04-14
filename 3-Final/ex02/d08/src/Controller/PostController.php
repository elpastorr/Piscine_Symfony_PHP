<?php
namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index')]
    public function defaultAction(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PostType::class, new Post());
        $posts = $em->getRepository(Post::class)->findBy([], ['created' => 'DESC']);

        if ($request->isXmlHttpRequest() && $request->isMethod('POST')) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            try {
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $post = $form->getData();
                    $em->persist($post);
                    $em->flush();
                    return new JsonResponse([
                        'success' => true,
                        'message' => 'post.success',
                        'post' => [
                            'title'   => $post->getTitle(),
                            'created' => $post->getCreated()->format('d/m/Y H:i'),
                        ]
                    ]);
                }

                $errors = [];
                foreach ($form->getErrors(true) as $error) {
                    $errors[] = $error->getMessage();
                }
                return new JsonResponse(['success' => false, 'message' => implode(' ', $errors)], 422);

            } catch (\Exception $e) {
                return new JsonResponse(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return $this->render('post/index.html.twig', [
            'post_form'  => $form->createView(),
            'is_logged_in' => (bool) $this->getUser(),
            'posts'      => $posts,
        ]);
    }

    #[Route('/posts', name: 'app_post_list')]
    public function listAction(EntityManagerInterface $em): Response
    {
        $posts = $em->getRepository(Post::class)->findAll();
    
        return $this->render('post/list.html.twig', [
            'posts' => $posts,
        ]);
    }
}