<?php

namespace App\Controller;

use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Repository\CommentRepository;


use App\Controller\Form;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Comment;

class CommentController extends Controller
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index(CommentRepository $commentRepository)
    {
        return $this->render('comment/index.html.twig', [
           // 'controller_name' => 'xCommentController',
            'comments' => $commentRepository->findAll()
        ]);
    }


    /**
     * @Route("/add", name="comment_add")
     */
    public function add(Request $request)
    {

//        $form->get('post_id')->setData($request->get('post_id_id'));
//        $form->get('content')->setData($request->get('comment'));
//        $form->handleRequest($request);
//        dump($form);

//        $this->getDoctrine()->getManager()->flush()

//       dump($this->redirect($request->request->get('HTTP_REFERER')));

        /*        if ($form->isSubmitted()){
                    if ($form->isValid()) {
                        return new Response('Saved new product with id ');
                        return $this->redirect($request->headers->get('referer'));*/

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $comment = new Comment();

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($comment); // $form);

        $form = $this->createForm(CommentType::class, $comment);
        dump($request->request->get('form')['content']);
        $form->get('content')->setData($request->request->get('form')['content']);  //setContent($request->request->get('form')['content']);
//                        {{ $request->request->get('post_id_id'); }}
        $form->get('post_id')->setData($request->request->get('form')['post_id']); //$form->setPostId($request->request->get('form')['post_id']);
        dump($form);
//        die;


        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return new Response('Saved new product with id '.$form->getId());

//        return $this->redirect($request->headers->get('referer'));
    }
    /*     }
     }*/


}
