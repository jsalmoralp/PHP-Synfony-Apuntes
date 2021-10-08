<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function userRegister(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $user->setRoles(['ROLE_USER']); //Can be: 'ROLE_USER','ROLE_ADMIN'
          $user->setBanned(false);

          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();

          $this->addFlash('Succefuly', 'The User Register was Succefuly!');
          return $this->redirectToRoute('register');

        }
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'form_userRegistration' => $form->createView(),
        ]);
    }
}
