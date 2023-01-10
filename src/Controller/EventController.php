<?php

namespace App\Controller;

use App\Form\TestEventFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(Request $request): Response
    {
        $data = array(
            'name' => 'Zinedine'
        );
        $form = $this->createForm(TestEventFormType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

        }

        return $this->render('event/index.html.twig', [
            'eventForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/salle', name: 'admin-salle')]
    public function adminSalle(): Response
    {

        return $this->render('event/salle.html.twig');
    }
}
