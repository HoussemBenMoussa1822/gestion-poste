<?php

namespace App\Controller;
use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
    
    /**
     * @Route("/add_Commentaire/{idpost}", name="addC")
     */
    public function addCommentaire(Request  $request, Post $idpost) {

        $Commentaire = new Commentaire(); // construct vide
        $Commentaire->setIdpost($idpost);
        $form = $this->createForm(CommentaireType::class,$Commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           

            $em = $this->getDoctrine()->getManager();
           
            $em->persist($Commentaire); // commit Commentaire
            $em->flush(); //push table
            // Page ely fiha table ta3 affichage

            return $this->redirectToRoute('affichage'); // yhezo lel page ta3 affichage
        }
        return $this->render('commentaire/ajouter_commentaire.html.twig',array('f'=>$form->createView())); // yab9a fi form

    }
    

    /**
     * @Route("/supprimer_Commentaire/{id}", name="suppressionC")
     */
    public function  supprimerCommentaire($id) {
        $em= $this->getDoctrine()->getManager();
        $i = $em->getRepository(Commentaire::class)->find($id);

        $em->remove($i);
        $em->flush();

        return $this->redirectToRoute('affichage');

    }
    /**
     * @Route ("/modifierC/{idpost}/{id}", name="modifierC")
     */
    public function modifierCommentaire(Request $req,$idpost,$id)
    {
        
        $Commentaire=$this->getDoctrine()->getRepository(Commentaire::class)->find($id);
        $form=$this->createForm(CommentaireType::class,$Commentaire);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $a=$this->getDoctrine()->getManager();
            $a->flush();
            return $this->redirectToRoute('affichage');
        }
        return $this->render('Commentaire/modifier_Commentaire.html.twig',array('f'=>$form->createView()));
    }
  

}
