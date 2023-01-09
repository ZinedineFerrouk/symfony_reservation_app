<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Service\TokenService;
use App\Service\MailerService;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Form\ResetPasswordConfirmType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public function __construct(private UserRepository $userRepo, private UserPasswordHasherInterface $hasher, private UrlGeneratorInterface $urlGenerator, private EventDispatcherInterface $eventDispatcher){}

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
    public function logout(Security $security){}

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

            // Appel du Subscriber
            $this->eventDispatcher->dispatch(new UserRegisterEvent);

            return $this->redirect('login');
        }

        return $this->render('security/register.html.twig', [
            'user' => $user,
            'registerForm' => $form,
        ]);
    }

    #[Route('/reset-password', name: 'reset-password')]
    public function resetPassword(Request $request,  MailerService $mailerService, TokenService $tokenService)
    {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $user = $this->userRepo->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('danger', 'Aucun compte ne correspond à l\'email renseigné');
                return $this->redirectToRoute('reset-password');
            }

            $user->setTokenApp($tokenService->generateRandomToken());
            $this->userRepo->save($user, true);

            // Envoi de mail
            $mailerService->sendPasswordResetEmail($user, $this->urlGenerator->generate('reset-password-token', ['token' => $user->getTokenApp()], UrlGeneratorInterface::ABSOLUTE_URL));
            // Renvoyer un message flash success

            return $this->redirect('reset-password');
        }

        return $this->render('security/reset_password.html.twig', [
            'resetPasswordForm' => $form,
        ]);
    }

    #[Route('/reset-password/{token}', name: 'reset-password-token')]
    public function resetPasswordWithToken(Request $request, UserRepository $userRepository, string $token)
    {     
        $user = $userRepository->findOneBy(['token_app' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'Le token ne correspond pas');
            return $this->redirectToRoute('reset-password');
        }   
        
        $form = $this->createForm(ResetPasswordConfirmType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $user->setPassword($this->hasher->hashPassword($user, $password));

            $user->setTokenApp(null);
            $this->userRepo->save($user, true);

            $this->addFlash('success', 'Votre mot de passe à bien été mis à jour.');

            return $this->redirect('login');
        }

        return $this->render('security/reset_password_token.html.twig', [
            'resetPasswordTokenForm' => $form,
        ]);
    }
}
