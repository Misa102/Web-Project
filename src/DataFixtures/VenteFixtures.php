<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Manuel;
use App\Entity\Magasin;
use App\Entity\Pays;
use App\Entity\Produit;
use App\Entity\ProduitMagasin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VenteFixtures extends Fixture
{
    public function load(ObjectManager $mana): void
    {
        /**=============================================================================================================
         * PAYSs
         *============================================================================================================*/
        $pays1 = new Pays();
        $pays1
            -> setNom('United State of America')
            -> setNom('USA');
        $mana->persist($pays1);

        $pays2 = new Pays();
        $pays2
            -> setNom('England')
            -> setCode('En');
        $mana->persist($pays2);

        $pays3 =new Pays();
        $pays3
            -> setNom('VietNam')
            ->setCode('Vi');
        $mana->persist($pays3);

        $pays4 = new Pays();
        $pays4
            -> setNom('France')
            -> setCode('Fr');
        $mana->persist($pays4);

        /**=============================================================================================================
         * MAGASINs
         *============================================================================================================*/
        $magasin1 = new Magasin();
        $magasin1
            ->setNom('Magasin N°1');
        $mana->persist($magasin1);

        $magasin2 = new Magasin();
        $magasin2
            ->setNom('Magasin N°2');
        $mana->persist($magasin2);

        $magasin3 = new Magasin();
        $magasin3
            ->setNom('Magasin N°3');
        $mana->persist($magasin3);

        $magasin4 = new Magasin();
        $magasin4
            ->setNom('Magasin N°4');
        $mana->persist($magasin4);


        /**=============================================================================================================
         * *********************************************************************************************************** *
         *============================================================================================================*/

        /**
         * PRODUIT 1
         */
        //produit 1
        $produit1 = new Produit();
        $produit1
            -> setDenomination('airPods')
            -> setCode('8 52 110 473')
            -> setDateCreation(new \DateTime())
            -> setActif(true)
            -> setDescriptif('descriptif pr01')
            -> setManuel(null);
        $mana -> persist($produit1);

        //ajout pays pour le produit 1
        $pays1 -> addProduit($produit1);
        $pays3 -> addProduit($produit1);

        $pro1Maga1 = new ProduitMagasin();
        $pro1Maga1
            ->setProduit($produit1)
            ->setMagasin($magasin1)
            ->setQuantite(243)
            ->setPrixUnitaire(125.46);
        $mana->persist($pro1Maga1);
        $produit1->addProduitMagasin($pro1Maga1);
        $magasin1->addProduitMagasin($pro1Maga1);

        $pro1Maga4 = new ProduitMagasin();
        $pro1Maga4
            ->setProduit($produit1)
            ->setMagasin($magasin4)
            ->setQuantite(178)
            ->setPrixUnitaire(124.0);
        $mana->persist($pro1Maga4);
        $produit1->addProduitMagasin($pro1Maga4);
        $magasin1->addProduitMagasin($pro1Maga4);


        //Image 1.1 produit 1
        $image1_1 = new Image();
        $image1_1
            ->setUrl('http://image1_1')
            ->setUrlMini('http://ahg893vdx')
            ->setAlt('une image 1 1')
            ->setProduit($produit1);
        $mana->persist($image1_1);

        //Image 1.2 du produit 1
        $image1_2 = new Image();
        $image1_2
            ->setUrl('http://image1_2')
            ->setUrlMini(null)               // valeur par défaut
            ->setAlt('une image 1 2')
            ->setProduit($produit1);
        $mana->persist($image1_2);


        /**
         * PRODUIT 2
         */
        //manuel 2 pour le produit 2
        $manuel2 = new Manuel();
        $manuel2
            -> setUrl('http://manueldeproduitnum2')
            -> setSommaire('Voici la sommaire');
        $mana -> persist($manuel2);

        //produit 2
        $produit2 = new Produit();
        $produit2
            -> setDenomination('iPad')
            -> setCode('4 23 243 001')
            -> setDateCreation(new \DateTime())
            -> setActif(false)
            -> setDescriptif('descriptif pr02')
            -> setManuel($manuel2);// asscocier le manuel 2 au produit 2
        $mana -> persist($produit2);

        //ajout produit 2 dans pays 4
        $pays4 -> addProduit($produit2);

        $pro2Maga1 = new ProduitMagasin();
        $pro2Maga1
            ->setProduit($produit2)
            ->setMagasin($magasin1)
            ->setQuantite(79)
            ->setPrixUnitaire(673.54);
        $mana->persist($pro2Maga1);
        $produit1->addProduitMagasin($pro2Maga1);
        $magasin1->addProduitMagasin($pro2Maga1);

        $pro2Maga2 = new ProduitMagasin();
        $pro2Maga1
            ->setProduit($produit2)
            ->setMagasin($magasin2)
            ->setQuantite(24)
            ->setPrixUnitaire(700.63);
        $mana->persist($pro2Maga2);
        $produit1->addProduitMagasin($pro2Maga2);
        $magasin1->addProduitMagasin($pro2Maga2);

        $pro2Maga4 = new ProduitMagasin();
        $pro2Maga4
            ->setProduit($produit2)
            ->setMagasin($magasin4)
            ->setQuantite(35)
            ->setPrixUnitaire(675.39);
        $mana->persist($pro2Maga4);
        $produit1->addProduitMagasin($pro2Maga4);
        $magasin1->addProduitMagasin($pro2Maga4);

        //images pour produit 2
        $image2_1 = new Image();
        $image2_1
            ->setUrl('http://image2_1')
            ->setUrlMini('http://jsg09gr')
            ->setAlt('une image 2 1')
            ->setProduit($produit2);
        $mana->persist($image2_1);

        $image2_2 = new Image();
        $image2_2
            ->setUrl('http://image2_2')
            ->setUrlMini('http://gh38mf')
            ->setAlt('une image 2 2')
            ->setProduit($produit2);
        $mana->persist($image2_2);

        $image2_3 = new Image();
        $image2_3
            ->setUrl('http://image2_3')
            ->setUrlMini('http://bvte54')
            ->setAlt('une image 2 3')
            ->setProduit($produit2);
        $mana->persist($image2_3);


        /**
         * PRODUIT 3
         */
        //produit 3
        $produit3 = new Produit();
        $produit3
            -> setDenomination('macBook')
            -> setCode('3 10 006 132')
            -> setDateCreation(new \DateTime())
            -> setActif(true)
            -> setDescriptif('descriptif pr03');
        $mana->persist($produit3);

        //produit 3 n'appartient aucun pays, ni image

        /**
         * PRODUIT 4
         */
        //manuel 4 pour le produit 4
        $manuel4 = new Manuel();
        $manuel4
            -> setUrl('http://manuel4pourproduit4')
            -> setSommaire(null);
        $mana-> persist($manuel4);

        //produit 4
        $produit4 = new Produit();
        $produit4
            -> setDenomination('appleWatch')
            -> setCode('8 44 783 712')
            -> setDateCreation(new \DateTime())
            -> setActif(true)
            -> setDescriptif('descriptif pr04')
            -> setManuel($manuel4);// associer le manuel4 au produit4
        $mana->persist($produit4);

        //ajout le produit 4 dans pays 2
        $pays2 -> addProduit($produit4);

        $pro4Maga2 = new ProduitMagasin();
        $pro4Maga2
            ->setProduit($produit4)
            ->setMagasin($magasin2)
            ->setQuantite(19)
            ->setPrixUnitaire(389.37);
        $mana->persist($pro2Maga4);
        $produit1->addProduitMagasin($pro4Maga2);
        $magasin1->addProduitMagasin($pro4Maga2);

        $pro4Maga3 = new ProduitMagasin();
        $pro4Maga3
            ->setProduit($produit4)
            ->setMagasin($magasin3)
            ->setQuantite(43)
            ->setPrixUnitaire(332.11);
        $mana->persist($pro4Maga3);
        $produit1->addProduitMagasin($pro4Maga3);
        $magasin1->addProduitMagasin($pro4Maga3);

        $pro4Maga4 = new ProduitMagasin();
        $pro4Maga4
            ->setProduit($produit4)
            ->setMagasin($magasin4)
            ->setQuantite(56)
            ->setPrixUnitaire(342.53);
        $mana->persist($pro4Maga4);
        $produit1->addProduitMagasin($pro4Maga4);
        $magasin1->addProduitMagasin($pro4Maga4);


        $mana ->flush();

    }
}
