<?php

namespace App\Controller;

use App\Entity\ParticipationPublic;
use App\Entity\ParticipationPrive;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ParticipationPublicRepository;
use App\Repository\ParticipationPriveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipationController extends AbstractController
{
    
    
    
    
    
    
    /**
     * @Route("/participationpublic", name="participationpublic")
     */
    public function index(Request $request ,EntityManagerInterface $entityManager )
    {

        $ParticipationPublic = new ParticipationPublic ();

        $form = $this ->createFormBuilder($ParticipationPublic)
                      ->add ('nom')
                      ->add ('prenom')
                      ->add ('email')
                      ->add ('donation')
                      ->getForm();
       
      
                $form->handleRequest($request)  ;  
                
                if ($form->isSubmitted() && $form->isValid()) {
                  $ParticipationPublic->setCreatedAt(new \DatetimeImmutable ());
                  $entityManager->persist($ParticipationPublic);
                  $entityManager->flush();
      
      
                  return $this->redirectToRoute('participationpublicadmin', ['id' => $ParticipationPublic ->getId()]);
      
                }

        return $this->render('participation/participationpublic.html.twig', [
            'formParticipationPublic' => $form->createView()
        ]);
    } 

 






    /**
     * @Route("/participationprive", name="participationprive")
     */
    public function index1(Request $request ,EntityManagerInterface $entityManager )
    {

        $ParticipationPrive = new ParticipationPrive ();

        $form = $this ->createFormBuilder($ParticipationPrive)
                      ->add ('nom')
                      ->add ('numeroTel')
                      ->add ('email')
                      ->add ('nbrPrisecharge')
                      ->getForm();
       
      
                $form->handleRequest($request)  ;  
                
                if ($form->isSubmitted() && $form->isValid()) {
                  $ParticipationPrive->setCreatedAt(new \DatetimeImmutable ());
                  $entityManager->persist($ParticipationPrive);
                  $entityManager->flush();
      
      
                  return $this->redirectToRoute('participationpriveadmin', ['id' => $ParticipationPrive ->getId()]);
      
                }

        return $this->render('participation/participationprive.html.twig', [
            'formParticipationPrive' => $form->createView()
        ]);
    } 







  



        /**
     * @Route("/participationpublicadmin", name="participationpublicadmin")
     */

    public function participationpublicadmin(): Response
    {
        $repo = $this ->getDoctrine()->getRepository(ParticipationPublic::class);
        $ParticipationPublics=$repo->findAll();
        return $this->render('participation/participationpublicadmin.html.twig', [
            'controller_name' => 'ParticipationController',
            'ParticipationPublics' => $ParticipationPublics,
        ]);
    } 


    

    /**
     * @Route("/participationpriveadmin", name="participationpriveadmin")
     */

    public function participationpriveadmin(): Response
    {
      
        $repo = $this ->getDoctrine()->getRepository(ParticipationPrive::class);
        $ParticipationPrives=$repo->findAll();
        return $this->render('participation/participationpriveadmin.html.twig', [
            'controller_name' => 'ParticipationController',
            'ParticipationPrives' => $ParticipationPrives,
        ]);
    } 










        /** 
     * @Route("/paiment", name="paiment")
     */
    public function paiment(): Response
    {
        return $this->render('participation/paiment.html.twig', [
            'controller_name' => 'ParticipationController',
        ]); 
    } 
        





                /**
     * @Route("/verif", name="verif")
     */
    public function verif(): Response
    {
        return $this->render('participation/verif.html.twig', [
            'controller_name' => 'ParticipationController',
        ]);
    } 


                /**
     * @Route("/verif2", name="verif2")
     */
    public function verif2(): Response
    {
        return $this->render('participation/verif2.html.twig', [
            'controller_name' => 'ParticipationController',
        ]);
    } 
}
