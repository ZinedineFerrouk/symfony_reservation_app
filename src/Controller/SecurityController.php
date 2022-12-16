<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function __construct(private UserRepository $userRepo, private UserPasswordHasherInterface $hasher){}

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Check si l'utilisateur est déjà connecter
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(Security $security): Response
    {
        // logout the user in on the current firewall
        $response = $security->logout();

        // you can also disable the csrf logout
        $response = $security->logout(false);
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();

            $user->setRoles(['ROLE_USER']);
            $user->setEmail($userData->getEmail());
            $user->setPassword($this->hasher->hashPassword($user, $userData->getPassword()));

            $this->userRepo->save($user, true);

            return $this->redirect('login');
        }

        return $this->render('security/register.html.twig', [
            'user' => $user,
            'registerForm' => $form,
        ]);
    }
}
