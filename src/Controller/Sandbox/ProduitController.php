<?php

namespace App\Controller\Sandbox;

use App\Entity\Pays;
use App\Entity\Produit;
use App\Entity\ProduitMagasin;
use App\Form\ProduitMagasinType;
use App\Form\ProduitPaysType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;




#[Route('sandbox/produit', name: 'produit')]

class ProduitController extends AbstractController
{
    //indexAction: accueil du controleur Produit
    #[Route('', name: '')]
    public function indexAction(): Response
    {
        return $this->redirectToRoute('produit_list', ['page' => 1]);
    }

    // listAction: liste de tous les produits
    #[Route('/list/{page}', name: '_list',
        requirements: ['page' => '[1-9]\d*'], //strictement positif
        defaults: ['page' => 0], //la valeur par défaut ne respecte pas les contraites
    )]
    public function listAction(int $page, EntityManagerInterface $em): Response
    {
        $produitRepository = $em -> getRepository(Produit::class);
        $produits = $produitRepository -> findAll();
        $args = array(
            'page' => $page,
            'produits' => $produits,
        );
        return $this ->render('Produit/list.html.twig', $args);
    }

    //viewAction :affiche le détail d'un produit
    #[Route('/view/{id}', name: '_view', requirements: ['id' => '[1-9]\d*'],)]
    public function viewAction(int $id, EntityManagerInterface $em): Response
    {
        $produitRespository = $em -> getRepository(Produit::class);
        $produit = $produitRespository -> find($id);

        if(is_null($produit))
        {
            $this -> addFlash('info', 'view: produit'.$id.'inexistant');
            return  $this -> redirectToRoute('produit_list');
        }

        $args = array(
            'produit' => $produit,
        );

        return $this-> render('Produit/view.html.twig', $args);
    }

    //addAction: ajout d'un produit dans la BD
    #[Route('/add', name:'_add')]
    public function addAction():Response
    {
        $this -> addFlash('info', 'échec ajout produit');
        return $this -> redirectToRoute('produit_view', ['id'=> 3]);
    }

    //editAction: modification d'un produit existant
    #[Route('/edit/{id}', name: '_edit', requirements: ['id' => '[1-9]\d*'],)]
    public function editAction(int $id): Response
    {
        $this -> addFlash('info', 'échec modification produit' .$id);
        return $this ->redirectToRoute('produit_view', ['id' => $id]);
    }

    //deleteAction: suppression d'un produit
    #[Route('/delete/{id}', name: '_delete', requirements: ['id' => '[1-9]\d*'],)]
    public function deleteAction(int $id, EntityManagerInterface $em): Response
    {
        $produitRepository = $em -> getRepository(Produit::class);
        $produit = $produitRepository -> find($id);

        if (is_null($produit))
            throw new NotFoundHttpException('erreur suppression produit'.$id);

        $em -> remove($produit);
        $em -> flush();
        $this -> addFlash('info', 'suppression produit'.$id.'réussie');

        return $this ->redirectToRoute('produit_list');
    }

    //paysAddAction: ajouter une relation produit/pays
    //créer un controlleur pour les tabs jointures est un peu violent: on fait le choix
    //de rattacher ces actions au controlleur de la tab "produits": ProduitController
    #[Route('/pays/add', name: '_pays_add',)]
    public function paysAddAction(EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(ProduitPaysType::class);
        $form->add('send', SubmitType::class, ['label' => 'add produit/pays']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /* @var Produit $produit */
            /* @var Pays $pays */
            $produit = $form->get('produit')->getData();
            $pays = $form->get('pays')->getData();
            if (! $produit->getPayss()->contains($pays))
            {
                //$produit->addPays($pays);             // ne met pas à jour l'objet $pays
                $pays->addProduit($produit);            // met à jour les deux entités
                $em->flush();
                $this->addFlash('info', 'ajout produit/pays réussi');
                return $this->redirectToRoute('produit_view', ['id' => $produit->getId()]);
            }
        }

        if ($form->isSubmitted())
        {
            $this->addFlash('info', 'erreur formulaire produit/pays');
            if ($form->isValid())
                $form->addError(new FormError('l\'association existe déjà'));
        }

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Produit/pays_add.html.twig', $args);


    }

    //magasinAddAction: ajouter une relation produit/magasin
    #[Route('/magasin/add', name: '_magasin_add',)]
    public function magasinAddAction(EntityManagerInterface $em, Request $request): Response
    {
        $produitMagasin = new ProduitMagasin();

        $form = $this->createForm(ProduitMagasinType::class, $produitMagasin);
        $form->add('send', SubmitType::class, ['label' => 'add produit/magasin']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($produitMagasin);
            $em->flush();
            $this->addFlash('info', 'ajout produit/magasin réussi');
            return $this->redirectToRoute('produit_view', ['id' => $produitMagasin->getProduit()->getId()]);
        }

        if ($form->isSubmitted())
            $this->addFlash('info', 'erreur formulaire produit/magasin');

        $args = array(
            'myform' => $form->createView(),
        );
        return $this->render('Produit/magasin_add.html.twig', $args);

    }


    /**
     * test de QueryBuilder
     */
    #[Route(
        '/viewQB/{id}/{method}',
        name: '_view_qb',
        requirements: [
            'id' => '[1-9]\d*',
            'method' => 'avec|sans',
        ],
    )]
    public function viewQB(int $id, string $method, EntityManagerInterface $em)
    {
        $produitRepository = $em->getRepository(Produit::class);

        if ($method === 'avec')
            $produit = $produitRepository->findWithMagasins($id);
        else
            $produit = $produitRepository->find($id);
        if (is_null($produit))
            throw new NotFoundHttpException('erreur viewQB produit ' . $id);

        $args = array(
            'method' => $method,
            'produit' => $produit,
        );
        return $this->render('Produit/viewQB.html.twig', $args);
    }

}
