<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Formation;
use App\Repository\UserRepository;
use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvitationController extends AbstractController
{
    /**
     * @Route("/invitation", name="invitation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository, UserRepository $userRepository)
    {
        return $this->render('invitation/index.html.twig', [
            'controller_name' => 'InvitationController',
            'formations' => $formationRepository->findbyUserId($this->getUser()->getId()),
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="invitation_add", methods={"POST"})
     */
    public function new(Request $request, FormationRepository $formationRepository, UserRepository $userRepository)
    {
        $idUser = $request->request->get('idUser');
        $idFormation = $request->request->get('idFormation');
        $formation = $formationRepository->find($idFormation);
        $user = $userRepository->find($idUser);
        if (!$user->getFormations()->contains($formation)) {
            $user->addFormation($formation);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->redirectToRoute('affectation_index');
    }
}
