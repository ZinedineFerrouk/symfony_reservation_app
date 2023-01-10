<?php

namespace App\Controller\Api;

use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSalleController extends AbstractController
{
    public function __construct(private SalleRepository $salleRepository){}

    #[Route('/api/salles', name: 'api_salle', methods: ['GET'])]
    public function index(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            return $this->json(['status' => 'error', 'message' => 'Erreur'], Response::HTTP_UNAUTHORIZED);
        }
        //$salles = $this->salleRepository->findAll();
        return $this->json(['test' => 'tess']);
    }
}
