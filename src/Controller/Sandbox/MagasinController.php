<?php

namespace App\Controller\Sandbox;

use App\Entity\Magasin;
use App\Form\MagasinType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('sandbox/magasin', name: 'magasin')]

class MagasinController extends AbstractController
{

    #[Route('/add', name: '_add')]
    public function addAction(EntityManagerInterface $em, Request $request): Response
    {
        $magasin = new Magasin();

        $form = $this->createForm(MagasinType::class, $magasin);
        $form->add('send', SubmitType::class, ['label' => 'add magasin']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($magasin);
            $em->flush();
            $this->addFlash('info', 'ajout magasin réussi');
            return $this->redirectToRoute('produit_list');    // il faudrait l'action qui liste les magasins
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'formulaire ajout magasin incorrect');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Magasin/add.html.twig', $args);
    }


    //gérer le nombre en stock d'un produit
    #[Route('/valeur-stock/{id}', name: '_valeur_stock', requirements: ['id' => '[1-9]\d*'],)]
    public function valeurStockAction(int $id): Response
    {
        // total fictif en attendant une requête sur la base de données
        $total = 315726;
        $args = array(
            'id' => $id,
            'total' => $total,
        );
        return $this->render('Magasin/valeurStock.html.twig', $args);
    }

    //affiche la liste des produits dont prix unitaire est compris dans une fourchette
    #[Route('/stock/{id}/{valinf}/{valsup}',
        name: '_stock',
        requirements: [
            'id' => '[1-9]\d*', //est obligatoire, est la clé primaire désignant le magasin
            'valinf' => '0|[1-9]\d*',//la valeur inférieur de la fourchette, c'est un entier positif
            'valsup' => '-1|0|[1-9]\d*',//valeur supérieure, soit entier positif
        ],
        defaults: [
            'valinf' => 0,
            'valsup' => -1,//signifique la fourchette n'a pas de borne supérieure
        ],
    )]
    public function stockAction(int $id, int $valinf, int $valsup): Response
    {
        //une liste fictive en dur de
        //triplets (nom du produit, prix unitaire, quantite en stock)
        $produits = array(
            [ 'denomination' => 'portable',   'quantite' => 37, 'prixUnitaire' => 660 ],
            [ 'denomination' => 'ordinateur', 'quantite' => 12, 'prixUnitaire' => 980 ],
            [ 'denomination' => 'USB',  'quantite' => 8,  'prixUnitaire' => 20 ],
        );
        $args = array(
            'id' => $id,
            'valinf' => $valinf,
            'valsup' => $valsup,
            'produits' => $produits,
        );
        return $this->render('Magasin/stock.html.twig', $args);
    }
}
