<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index(CommentRepository $commentRepository)
    {
        return $this->render('comment/index.html.twig', [
           // 'controller_name' => 'CommentController',
            'comments' => $commentRepository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="comment_add")
     */
    public function add(Request $request)
    {
         dump($request);
         return $this->render('comment/index.html.twig',['comments'=>'commenttt']);
   }
}
