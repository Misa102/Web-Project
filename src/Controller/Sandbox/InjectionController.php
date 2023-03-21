<?php

namespace App\Controller\Sandbox;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[Route('sandbox/injection', name: 'sandbox_injection')]


class InjectionController extends AbstractController
{
//tp3_7.1
    #[Route('/create-flash', name: '_create_flash')]
    public function createFlashAction(Session $session): Response
    {
        // par exemple cette action supprime une entrée dans la base de données,les deux lignes sont strictement equivalentes.
        $session->getFlashBag()->add('info', 'L\'enregistrement a été supprimé');
        $this->addFlash('info', 'L\'enregistrement a été supprimé (bis repetita)');
        $this->addFlash('error', 'Il pourrait y avoir une erreur');
        $this->addFlash('error', 'Il pourrait y avoir une erreur (bis repetita)');
        return $this->redirectToRoute('sandbox_injection_display_flash');
    }

    #[Route('/display-flash', name: '_display_flash')]
    public function displayFlashAction(): Response
    {
        return $this -> render ('Sandbox/Injection/displayFlash.html.twig');
    }

}
