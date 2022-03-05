<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
Use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

   
 /**
     * @Route("/", name="home")
     */
 public function home()
 {
    return $this->render('post/index.html.twig');

 }

            /**
     * @Route("/About", name="About")
     */
    public function About()
    {
       return $this->render('user/about.html.twig');
   
    }


  




}