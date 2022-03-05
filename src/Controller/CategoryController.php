<?php

namespace App\Controller;
use App\Entity\Evenement;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
   
    
    
     

    /**
     * @Route("/add_category", name="addCAT")
     */
    public function addCategory(Request  $request) {

        $Category = new Category(); // construct vide
        $form = $this->createForm(CategoryType::class,$Category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
          


            $em = $this->getDoctrine()->getManager();
           
            $em->persist($Category); // commit Post
            $em->flush(); //push table
            // Page ely fiha table ta3 affichage

            return $this->redirectToRoute('Categoryadmin'); // yhezo lel page ta3 affichage
        }
        return $this->render('category/ajouter_category.html.twig',array('f'=>$form->createView())); // yab9a fi form

    }
  

    /**
     * @Route("/Categoryadmin", name="Categoryadmin") 
     */
    public function Categoryadmin(?string $string, Request $request)
    {
        $Categorys = $this->getDoctrine()->getManager()->getRepository(Category::class)->findAll(); // select * from product
        $Evenements = [];
        foreach($Categorys as $Category) 
        { 
            $categoryid = $Category->getId();
            $Evenements[strval($categoryid)] = $this->getDoctrine()->getManager()->getRepository(Evenement::class)->findBy(['idc' => $Category->getId()]);//strval recupére postid comme chaine de caractére pour qu'il peut acceder avec au tableau 
           
            
        }

        return $this->render("category/categoryadmin.html.twig",array("Categorys"=>$Categorys,"Evenements"=>$Evenements));

    
    
}
     /**
     * @Route("/affichagevenementducat/{id}", name="affichagevenementducat") 
     */
    public function affichageEventCategoryadmin($id): Response
    {
        $repo = $this ->getDoctrine()->getRepository(evenement::class);
        $evenements=$repo->findAll();
       
        //
        return $this->render('category/detailcat.html.twig',array( 
            'controller_name' => 'EvenementController',
            'evenements' => $evenements,'f'=> $category,
        ));
    }



    /**
     * @Route("/supprimer_category/{id}", name="suppressioncat")
     */
    public function  supprimercat($id) {
        $em= $this->getDoctrine()->getManager();
        
        $i = $em->getRepository(Category::class)->find($id);

        $h = $em->getRepository(Evenement::class)->findBy(['idc'=>$id]); 
        foreach($h as $Evenement){$em->remove($Evenement);}
         
        
        $em->remove($i);
        $em->flush();

        return $this->redirectToRoute("Categoryadmin");

    }


    /**
     * @Route ("/modifiercat/{id}", name="modifiercat")
     */
    public function modifiercat($id,Request $req)
    {
       
        $Category=$this->getDoctrine()->getRepository(Category::class)->find($id);
        $form=$this->createForm(CategoryType::class,$Category);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
            $a=$this->getDoctrine()->getManager();
            $a->flush();
            return $this->redirectToRoute('Categoryadmin');
        }
        return $this->render('category/modifier_category.html.twig',array('f'=>$form->createView()));
    }



}