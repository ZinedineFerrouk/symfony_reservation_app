<?php

namespace App\Controller\Api;

use App\Entity\Salle;
use App\Form\SalleFormType;
use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSalleController extends AbstractController
{
    public function __construct(private SalleRepository $salleRepository){}

    #[Route('/api/salles', name: 'api_salle', methods: ['GET'])]
    public function index(Request $request)
    {
        // Renvoi une erreur si la requête faite dans le front n'est pas de type XmlHttpRequest
        if (!$request->isXmlHttpRequest()){
            return $this->json(['status' => 'ERROR', 'message' => 'Désolé la requête n\'est pas conforme'], Response::HTTP_UNAUTHORIZED);
        }

        $salles = array();
        foreach ($this->salleRepository->findAll() as $salle )
        {
            $salles[] = $salle->getInfos();
        }
        return $this->json($salles, Response::HTTP_OK);
    }

    #[Route('/api/salles/add', name: 'api_salle_add', methods: ['GET', 'POST'])]
    public function addNewSalle(Request $request)
    {
        // Renvoi une erreur si la requête faite dans le front n'est pas de type XmlHttpRequest
        if (!$request->isXmlHttpRequest()){
            return $this->json(['status' => 'ERROR', 'message' => 'Désolé la requête n\'est pas conforme'], Response::HTTP_UNAUTHORIZED);
        }

        // Création d'une nouvelle salle avec un FormType correcpondant crée dans le back
        $salle = new Salle();
        $form = $this->createForm(SalleFormType::class, $salle, ['csrf_protection' => false]);

        // JSON_DECOCE pour récupère le contenu des données insérer dans le formulaire
        $formData = json_decode($request->getContent(), true);

        // Ici on traite les les données du FRONT
        $form->submit($formData);

        if ($form->isValid()){
            // Persit & Flush
            $this->salleRepository->save($salle, true);
            return $this->json('Success', Response::HTTP_OK);
        } else {
            $errors = $this->getFormErrors($form);
            return $this->json([
                'status' => 'Failure',
                'errors' => $errors,
                ], Response::HTTP_OK);
        }
    }

    protected function getFormErrors(Form $form): array
    {
        $errors = array();
        foreach ($form->getErrors() as $error){
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof Form) {
                if ($childErrors = $this->getFormErrors($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}
