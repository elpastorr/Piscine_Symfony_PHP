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

                    $data = [
                        'type' => 'new_post',
                        'post' => [
                            'id'      => $post->getId(), // IMPORTANT: you forgot this before!
                            'title'   => $post->getTitle(),
                            'created' => $post->getCreated()->format('d/m/Y H:i'),
                        ]
                    ];

                    $ch = curl_init('http://127.0.0.1:8080/broadcast');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_exec($ch);
                    curl_close($ch);

                    return new JsonResponse([
                        'success' => true,
                        'message' => 'post.success',
                        'post' => [
                            'id'      => $post->getId(),
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

    #[Route('/view/{id}', name: 'app_post_view', methods: ['GET'])]
    public function viewAction(Post $post): JsonResponse
    {
        $this->denyAccessUnlessGranted('PUBLIC_ACCESS');

        return new JsonResponse([
            'success' => true,
            'post' => [
                'id'      => $post->getId(),
                'title'   => $post->getTitle(),
                'content' => $post->getContent(),
                'created' => $post->getCreated()->format('d/m/Y H:i'),
            ]
        ]);
    }

    #[Route('/delete/{id}', name: 'app_post_delete', methods: ['DELETE'])]
    public function deleteAction(Post $post, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
        $em->remove($post);
        $em->flush();

        $data = [
            'type' => 'delete_post',
            'id'   => $post->getId()
        ];

        $ch = curl_init('http://127.0.0.1:8080/broadcast');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        return new JsonResponse([
            'success' => true,
            'id' => $post->getId()
        ]);
    }  
}