<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Service\MyManager;
use App\Service\PostManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Entity\Tag;


class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {

/*        $obj  = $this->get(PostManager::class);   //new MyManager();
        dump($obj->toDo());
        die;*/

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(CategoryRepository $categoryRepository)
    {
        //$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('main/blog.html.twig', compact('categories'));
        //['posts' => $posts,]);
    }

    /**
     * @Route("/bytag", name="tagged")
     */
    public function tagged()
    {
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        return $this->render('main/tagged.html.twig', compact('tags'));
    }

    /**
     * @Route("tag/{id}", name="tag")
     */
    public function tag($id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);
        return $this->render('main/tag.html.twig', [
            'tag' => $tag,
        ]);
    }

    /**
     * @Route("article/{categorySlug}/{postSlug}", name="article")
     * @ParamConverter("post", options={"mapping": {"postSlug": "slug"}})
     * @ParamConverter("category", options={"mapping": {"categorySlug": "slug"}})
     */
    public function article(Post $post, Category $category)
    {
//        $post = $this->getDoctrine()->getRepository(Post::class)->find($articleId);
        return $this->render('main/article.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{categorySlug}", name="category")
     * @ParamConverter("category", options={"mapping": {"categorySlug": "slug"}})
     */
    public function category(Category $category)
    {
        return $this->render('main/category.html.twig', ['category' => $category,]);
    }
}