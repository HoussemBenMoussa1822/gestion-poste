<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ReclamationController extends AbstractController
{
    
     


    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(Request $request ,EntityManagerInterface $entityManager)
    {

        $Reclamation = new Reclamation ();

        $form = $this ->createFormBuilder($Reclamation)
                      ->add ('nom')
                      ->add ('prenom')
                      ->add ('email')
                      ->add ('contenu')
                      ->add ('image')
                      ->getForm();
       
      
                $form->handleRequest($request)  ;  
                
                if ($form->isSubmitted() && $form->isValid()) {
                  $Reclamation->setCreatedAt(new \DatetimeImmutable ());
                  $entityManager->persist($Reclamation);
                  $entityManager->flush();
      
                  
            return $this->redirectToRoute('reclamationadmin', ['id' => $Reclamation ->getId()]);

        }

                  
        return $this->render('reclamation/index.html.twig', [
            'formReclamation' => $form->createView()
          
        ]);

   
    }


    /**
     * @Route("/reclamationadmin", name="reclamationadmin")
     */
    public function reclamationadmin(): Response
    {

        $repo = $this ->getDoctrine()->getRepository(Reclamation::class);
        $Reclamations=$repo->findAll();
        return $this->render('reclamation/Reclamationadmin.html.twig', [
            'controller_name' => 'ReclamationController',
             'Reclamations' => $Reclamations
           
        ]);
    }
}
