<?php

namespace App\Controller\Sandbox;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil_index')]
    public function indexAction(): Response
    {
        return $this->render('Accueil/index.html.twig');
    }

    // pour inclusion de contrôleur dans le template secondaire : action non routable
    //càd n'est pas accessible via un URL saisie dans le navi.
    //Cette action n'a de sens que si elle est incluse ds un template complet
    public function menuAction(): Response
    {
        $args = array(
        );
        return $this->render('Layouts/menu.html.twig', $args);
    }
}
