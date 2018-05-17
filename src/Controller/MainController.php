<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('main/blog.html.twig', compact('categories'));
            //['posts' => $posts,]);
    }

    /**
     * @Route("/article/{articleId}", name="article")
     */
    public function article($articleId)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($articleId);
        return $this->render('main/article.html.twig', [
            'post' => $post,
        ]);
    }

}
