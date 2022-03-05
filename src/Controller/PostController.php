<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Commentaire;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

use App\Entity\Urlizer;


class PostController extends AbstractController
{


    /**
     * @Route("/PostM", name="Post")
     */
    public function index(): Response
    {
        return $this->render('Post/map.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
    /**
     * @Route("/Postadmin", name="Postadmin")
     */
     public function afficher()
    {
        $Post=$this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->render('Post/Postadmin.html.twig',['Post'=>$Post]);


    }

    /**
     * @Route("/add_Post", name="add")
     */
    public function addPost(Request  $request) {

        $post = new Post(); // construct vide
        $form = $this->createForm(PostType::class,$post);
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
               $post->setImage($newFilename);


            $em = $this->getDoctrine()->getManager();
           
            $em->persist($post); // commit Post
            $em->flush(); //push table
            // Page ely fiha table ta3 affichage

            return $this->redirectToRoute('affichage'); // yhezo lel page ta3 affichage
        }
        return $this->render('post/ajouter_post.html.twig',array('f'=>$form->createView())); // yab9a fi form

    }
    /**
     * @Route("/affichage_Post/{string?}", name="affichage")
     */

    public function  affichagePost(?string $string, Request $request) {
        $post = new Post(); // construct vide
        $form = $this->createForm(PostType::class,$post);
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
               $post->setImage($newFilename);


            $em = $this->getDoctrine()->getManager();
           
            $em->persist($post); // commit Post
            $em->flush(); //push table
            // Page ely fiha table ta3 affichage

            return $this->redirectToRoute('affichage'); // yhezo lel page ta3 affichage
        }
        $Posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->findAll(); // select * from product
        $Commentaires = [];
        foreach($Posts as $Post) 
        { 
            $postid = $Post->getId();
            $Commentaires[strval($postid)] = $this->getDoctrine()->getManager()->getRepository(Commentaire::class)->findBy(['idpost' => $Post->getId()]);//strval recupére postid comme chaine de caractére pour qu'il peut acceder avec au tableau 
           
            
        }

        return $this->render("post/affichage_post.html.twig",array("Posts"=>$Posts,"Commentaires"=>$Commentaires,"f" => $form->createView()));

    
    
}

    /**
     * @Route("/supprimer_post/{id}", name="suppression")
     */
    public function  supprimerPost($id) {
        $em= $this->getDoctrine()->getManager();
        
        $i = $em->getRepository(Post::class)->find($id);

        $h = $em->getRepository(Commentaire::class)->findBy(['idpost'=>$id]); 
        foreach($h as $commentaire){$em->remove($commentaire);}
         
        
        $em->remove($i);
        $em->flush();

        return $this->redirectToRoute("affichage");

    }
    
    /**
     * @Route("/supprimer_postadmin/{id}", name="suppressionA")
     */
    public function  supprimerPostadmin($id) {
        $em= $this->getDoctrine()->getManager();
        
        $i = $em->getRepository(Post::class)->find($id);

        $h = $em->getRepository(Commentaire::class)->findBy(['idpost'=>$id]); 
        foreach($h as $commentaire){$em->remove($commentaire);}
         
        
        $em->remove($i);
        $em->flush();

        return $this->redirectToRoute("Postadmin");

    }
    /**
     * @Route ("/modifier/{id}", name="modifier")
     */
    public function modifier($id,Request $req)
    {
       
        $Post=$this->getDoctrine()->getRepository(Post::class)->find($id);
        $form=$this->createForm(PostType::class,$Post);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
               /** @var UploadedFile $uploadedFile */
          $uploadedFile = $form['image']->getData();
          $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
          $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
          $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
          $uploadedFile->move(
              $destination,
              $newFilename
          );
              $Post->setImage($newFilename);
            $a=$this->getDoctrine()->getManager();
            $a->flush();
            return $this->redirectToRoute('affichage');
        }
        return $this->render('Post/modifier_post.html.twig',array('f'=>$form->createView()));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $Post =  $em->getRepository('AppBundle:Post')->findEntitiesByString($requestString);
        if(!$Post) {
            $result['Post']['error'] = "Post Not found :( ";
        } else {
            $result['Post'] = $this->getRealEntities($Post);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($Post){
        foreach ($Post as $Post){
            $realEntities[$Post->getId()] = [$Post->getType(),$Post->getImage(),$Post->getDescription(),$Post->getLocalisation()];

        }
        return $realEntities;
    }


}
