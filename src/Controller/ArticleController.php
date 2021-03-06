<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\Sorting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\Common\Persistence\ObjectManager;


class ArticleController extends AbstractController
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function countArticles()
    {
        $count = 0;

        $articlesRepository = $this->objectManager
            ->getRepository(Article::class);
        $articles = $articlesRepository->findAll();

        if (is_array($articles)) {
            $content_count = count($articles);
        } else {
            $content_count = 0;
        }

        for ($article = 0; $article < $content_count; $article++) {
            $count++;
        }

        return $articles->$count;
    }

    /**
     * @Route("/articles", name="article_list")
     * @Method({"GET"})
     */

    public function index()
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('articles/index.html.twig', array('articles' => $articles));
    }

    /**
     * @Route("/article/delete/{id}", name="article_delete")
     */

    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository(Article::class)->find($id);

        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('article_list');
    }

    /**
     * @Route("/article/new", name="new_article")
     * Method({"GET", "POST"})
     */

    public function newArticle(Request $request)
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('body', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/article/sort" , name="sort_article")
     *  Method({"GET", "POST"})
     */
    public function sort(ArticleRepository $repository)
    {

        $articles = $repository->sortArticleByTitle();

        return $this->render('articles/sorted_articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */

    //shows user description
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('articles/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/article/edit/{id}", name="edit_article")
     * Method({"GET"})
     */

    public function edit(Request $request, $id)
    {

        $article = new Article();
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('body', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }
        return $this->render('articles/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/sorting" , name="sort")
     *  Method({"GET"})
     */
    public function sortingByTitle(Sorting $sorting)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->selectTitles();

        usort($article, array($sorting, 'callback'));

        return $this->render('articles/example.html.twig', [
            'articles' => $article,
        ]);

    }

}