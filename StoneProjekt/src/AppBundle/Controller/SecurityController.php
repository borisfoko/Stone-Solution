<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only append on post)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setEmail($user->getUsername() . "@htw-berlin.de");
            $user->addRole('ROLE_USER');
            // 4) save the user
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // 5) Add a flash message
            $this->get('session')->getFlashBag()
                ->add("succes", "Sie wurden erfolgreich registriert. Nur noch ein Schritt. \n Schauen Sie bitte Ihre Email und aktivieren Sie Ihr Konto.")
                ;

            // Redirect to homepage
            return $this->redirectToRoute('homepage', array('exemple1' => $user->getVorname() . " " . $user->getNachname()));
        }

        return $this->render(
          'Security/register.html.twig',
          array('form' => $form->createView())
        );

    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils){
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('Security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}
