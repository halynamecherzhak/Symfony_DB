<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 2/6/2019
 * Time: 2:23 PM
 */
namespace  App\Controller;

use App\Entity\User;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Annotation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{

    /**
     * @Route("/",name="app_homepage")
     */

    public  function  index()
    {

        //extract data from db
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('users/index.html.twig', array('users'=>$users));
    }

    /**
     * @Route("/user/{id}", name="user_show")
     */

    //shows user description
    public  function show($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        return $this->render('users/show.html.twig', array('user' => $user));

    }

    /**
     * @Route("/user/save")
     */
//    public  function  save()
//    {
//
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $user = new User();
//
//        $user->setName('Maryna');
//        $user->setDescription('I am a teacher');
//
//        //create SQL command
//        $entityManager->persist($user);
//
//        $entityManager->flush();
//
//        return new Response('Saves user with the id of' .$user->getId());
//
//    }
}
