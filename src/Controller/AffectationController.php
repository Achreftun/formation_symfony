<?php

namespace App\Controller;


use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/affectation")
 */
class AffectationController extends AbstractController
{
    /**
     * @Route("", name="affectation_index")
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
        $entityManager->flush();
        return $this->redirectToRoute('affectation_index');
    }

    /**
     * @Route("/delete/{id}", name="affectation_delete", methods={"GET"})
     */
    public function delete(Formation $formation)
    {
        $user = $this->getUser();
        $user->removeFormation($formation);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('affectation_index');
    }
}
