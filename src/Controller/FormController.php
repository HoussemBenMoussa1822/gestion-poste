<?php

namespace App\Controller;
use App\Entity\Form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function index(): Response
    {
        
        $repo = $this ->getDoctrine()->getRepository(Profil::class);
        $Forums=$repo->findAll();
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
            'Forums' => $Forums
        ]);
    }

    
        /**
     * @Route("/  formForm", name=" formForm")
     */
    public function Forumadd (Request $request ,EntityManagerInterface $entityManager )
    {

        $Forum = new  Forum();

        $form = $this ->createFormBuilder( $Forum)
                      ->add ('contenu')
                      ->add ('createdAt')
                      ->getForm();
       
      
                $form->handleRequest($request)  ;  
                
                if ($form->isSubmitted() && $form->isValid()) {
                
                  $entityManager->persist( $Forum);
                  $entityManager->flush();
      
      
                  return $this->redirectToRoute('formForm', ['id' =>  $Forum ->getId()]);
      
                }
        return $this->render('form/form.html.twig', [
            'Forum1' => $form->createView()
        ]);
    }



      /**
     * @Route("/chat", name="chat")
     */
    public function chat(): Response
    {
        return $this->render('form/form.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }
        
    /**
     * @Route("/FOROMadmin", name="FOROMadmin")
     */
    public function FOROMadmin(): Response
    {
        return $this->render('form/FOROMadmin.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }
}
