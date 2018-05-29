<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 26/05/18
 * Time: 6:14 PM
 */

namespace App\Service;

use App\Entity\Post;
use App\Form\PostType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

use Symfony\Component\HttpFoundation\Request;

class PostManager
{
    private $formFactory;
    private $entityManager;

    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager
        )
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
    }

    public function createPost(Request $request)
    {
        $post = new Post();
        $form = $this->formFactory->create(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
            $this->entityManager->persist($post); //$em->persist($post);
            $this->entityManager->flush(); //$em->flush();

            return false; //$this->redirectToRoute('post_index');
        }

        return [
            'post' => $post,
            'form' => $form->createView(),
        ];

    }
}