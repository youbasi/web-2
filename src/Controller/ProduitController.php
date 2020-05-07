<?php

namespace App\Controller;

use App\Entity\Enchere;
use App\Entity\Produit;
use App\Form\AnchorsType;
use App\Form\ProduitType;
use App\Repository\EnchereRepository;
use App\Service\FileUploader;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/nouveau", name="nouveau")
     */
   public function nouveau(Request $request, EntityManagerInterface $manager, FileUploader $fileUploader): Response
    {
        $produit = new Produit();
        $formProduit = $this->createForm(ProduitType::class, $produit);
        $formProduit->handleRequest($request);
        if($formProduit->isSubmitted() && $formProduit -> isValid() ){    
       $file = $produit->getImageFile();

        $filename = $fileUploader->upload($file);
        $produit->setImage($filename);
        $manager->persist($produit);        
        $manager->flush();
        
        return $this->redirectToRoute("anchors");
        
    }
    return $this->render('produit/nouveau.html.twig', [
        'produit' => '$produit',
        'form' => $formProduit->createView(),
    
    ]);
}
    /**
     * @Route("/NvEncheres", name = "nvencheres")
     */
    public function enchere(Request $request, EntityManagerInterface $manager):Response
    {
        $enchere = new Enchere();
        $formDate = $this->createForm(AnchorsType::class, $enchere);
        $formDate->handleRequest($request);
        if($formDate->isSubmitted() && $formDate->isValid()){
            $enchere->setNumero(uniqid());
            $manager->persist($enchere);
            $manager->flush();
            /*après avoir indiqué la date, j'ai mis redirection vers la création du produit
            pour que l'utilisateur continue le processus
            */
            return $this->redirectToRoute("nouveau");
        }
        return $this->render('produit/nouvelleEnchere.html.twig',[
            'enchere'=>'$enchere',
            'form'=>$formDate->createView(),
        ]);
    }
    /**
     * @Route("/anchors", name = "anchors")
     */
    public function affichage(ProduitRepository $produitRepository, EnchereRepository $enchereRepository)
    {
        
        $anchors = $produitRepository->findAll();
        $produits = $enchereRepository->findAll();
        return $this->render('home/anchors.html.twig', [
            'controller_name' => 'ProduitController',
            'anchors' => $anchors,
            'produits' => $produits
        ]);
    }
}
