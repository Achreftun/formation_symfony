<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AffectationController extends AbstractController
{
    /**
     * @Route("/affectation", name="affectation_index")
     */
    public function index(FormationRepository $formationRepository)
    {
        return $this->render('affectation/index.html.twig', [
            'controller_name' => 'AffectationController',
            'formations' => $formationRepository->findbyUserId($this->getUser()->getId()),
            'autres' => $formationRepository->findWithoutUserId($this->getUser()->getId()),
        ]);
    }

    /**
     * @Route("/new/{id}", name="affectation_add", methods={"GET","POST"})
     */
    public function new(Formation $formation)
    {
        $user = $this->getUser();
        $user->addFormation($formation);
        $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('affectation_index');
    }

    /**
     * @Route("/{id}", name="affectation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user)
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_logout');
    }
}
