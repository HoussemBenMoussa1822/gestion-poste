<?php

namespace App\Controller;
use App\Entity\Evenement;
use App\Entity\Category;
use App\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use App\Entity\Urlizer;


class EvenementController extends AbstractController
{
    
  
    /**
     * @Route("/ADDEVENT/{idc}", name="ADDEVENT")
     */
    public function addEvenement(Request  $request,Category $idc) {

        $Evenement = new Evenement(); // construct vide
        $Evenement->setIdc($idc);
        $form = $this->createForm(EvenementType::class,$Evenement);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $uploadedFile */
           $uploadedFile = $form['image']->getData();
           $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
           $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
           $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
           $uploadedFile->move(
               $destination,
               $newFilename
           );
               $Evenement->setImage($newFilename);
               

           
            $em = $this->getDoctrine()->getManager();
           
            $em->persist($Evenement); // commit Post
            $em->flush(); //push table
            // Page ely fiha table ta3 affichage

            return $this->redirectToRoute('Categoryadmin'); // yhezo lel page ta3 affichage
        }
        return $this->render('evenement/ajouterevenement.html.twig',array('f'=>$form->createView()));// yab9a fi form

    }

    /**
     * @Route("/supprimer_Event/{id}", name="suppressionevent")
     */
    public function  supprimerEvenement($id) {
        $em= $this->getDoctrine()->getManager();
        $i = $em->getRepository(Evenement::class)->find($id);

        $em->remove($i);
        $em->flush();

        return $this->redirectToRoute('Categoryadmin');

    }
    /**
     * @Route ("/modifierevent/{idc}/{id}", name="modifierevent")
     */
    public function modifierevent(Request $req,$idc,$id)
    {
        
        $Evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $form=$this->createForm(EvenementType::class,$Evenement);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $a=$this->getDoctrine()->getManager();
            $a->flush();
            return $this->redirectToRoute('Categoryadmin');
        }
        return $this->render('evenement/modifier_event.html.twig',array('f'=>$form->createView()));
    }
    /**
 * @Route("/evenement/{id}", name="evenement")
 */
public function evenement(int $id): Response
{
    $evenement = $this->getDoctrine()->getRepository(Evenement::class)->find($id);

    return $this->render("evenement/detaileventAdmin.html.twig", [
        "f" => $evenement,
    ]);
}


/**
     * @Route("/event", name="event") 
     */
    public function index(): Response
    {
        $repo = $this ->getDoctrine()->getRepository(evenement::class);
        $evenements=$repo->findAll();
    

        return $this->render('evenement/index.html.twig',[
            'controller_name' => 'EvenementController',
            'evenements' => $evenements
        ]);
    
}
}
 