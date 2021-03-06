<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    public function user(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('base.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $users
        ]);
    }
    /**
     * @Route("/anchors",name="anchors")
     */
    public function anchors()
    {
        return $this->render('home/anchors.html.twig');
    }

    /**
     * @Route("/help",name="help")
     */
    public function help()
    {
        return $this->render('home/help.html.twig');
    }
    
    /**
     * @Route("/packJetons",name="packJetons")
     */
    public function packJetons()
    {
        return $this->render('home/PackJetons.html.twig');
    }
    /**
     * @Route("/historique", name="historique")
     */

     public function historique(){
         return $this->render('home/Historique.html.twig');
     }
}
