<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Service\MyManager;
use App\Service\PostManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Entity\Tag;

use App\Entity\Comment;
use App\Form\CommentType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



use Symfony\Component\HttpFoundation\Response;

//use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Form;

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
    public function blog(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        //$categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $categories = $categoryRepository->findAll();

        dump($postRepository->getPostsByCategory($categories[0]));

//        die;
        return $this->render('main/blog.html.twig', compact('categories'));
        //['posts' => $posts,]);
    }

    /**
     * @Route("article/{categorySlug}/{postSlug}", name="article")
     * @ParamConverter("post", options={"mapping": {"postSlug": "slug"}})
     * @ParamConverter("category", options={"mapping": {"categorySlug": "slug"}})
     */
    public function article(Post $post, Category $category)
    {
         $comment = new Comment(); //$task = new Task();
            $form = $this->createFormBuilder($comment)//$task)
            ->add('content', TextType::class)
            ->add('post_id', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit Comment'))
                ->setAction('/add')
            ->getForm();
        dump($form);
        dump($post);

        return $this->render('main/article.html.twig', ['post' => $post, 'form' => $form->createView(),]);


//        $post = $this->getDoctrine()->getRepository(Post::class)->find($articleId);
    }

    /**
     * @Route("cat/{categorySlug}", name="category")
     * @ParamConverter("category", options={"mapping": {"categorySlug": "slug"}})
     */
    public function category(Category $category)
    {
        return $this->render('main/category.html.twig', ['category' => $category,]);
    }

    /**
     * @Route("/t/tag/{id}", name="tagg")
//     * @ParamConverter("tagg", options={"mapping": {"tagTitle": "title"}})
     */
    public function tagg($id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);
        return $this->render('main/tag.html.twig', compact('tag'));
    }

    public function tags(TagRepository $repository, $place = null)
    {
        $tags = $repository->findAll(); dump($place);
        return $this->render('main/partial/tags.html.twig', compact('tags'));
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
     * @Route("bytag/{id}", name="tag")
     */
    public function tag($id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($id);
        return $this->render('main/tag.html.twig', [
            'tag' => $tag,
        ]);
    }


}