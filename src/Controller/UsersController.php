<?php

namespace App\Controller;

use App\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;





class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
     
    





    
    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request ,EntityManagerInterface $entityManager  )
    { 

      $Profil = new Profil ();

  $form = $this ->createFormBuilder($Profil)
                ->add ('nom')
                ->add ('prenom')
                ->add ('email')
                ->add ('numeroTel')
                ->add ('mot_de_passe')
                ->getForm();
 

          $form->handleRequest($request)  ;  
          
          if ($form->isSubmitted() && $form->isValid()) {
            $Profil->setCreatedAt(new \DatetimeImmutable ());
            $entityManager->persist($Profil);
            $entityManager->flush();


            return $this->redirectToRoute('Users', ['id' => $Profil ->getId()]);

          }
         
 
        return $this->render('users/inscription.html.twig', [
            'formProfil' => $form->createView()
        ]);
    }










          /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('users/login.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
              /**
     * @Route("/profil", name="profil")
     */
    public function profil(): Response
    {
        return $this->render('users/profil.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
         
    /**
     * @Route("/General", name="General")
     */
    public function General(): Response
    {
        return $this->render('users/General.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
         
      

    /**   
     * @Route("/Users", name="Users")
     */
    public function Users(): Response
    {

        $repo = $this ->getDoctrine()->getRepository(Profil::class);
        $Profils=$repo->findAll();

        return $this->render('users/Users.html.twig', [
            'controller_name' => 'UsersController',
            'Profils' => $Profils
        ]);
    }

}

